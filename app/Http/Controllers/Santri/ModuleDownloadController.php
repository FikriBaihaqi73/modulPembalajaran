<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Str;
use DOMDocument;
use Illuminate\Support\Facades\Log;

class ModuleDownloadController extends Controller
{
    /**
     * Helper function to embed images as base64 in HTML content.
     *
     * @param string $htmlContent
     * @return string
     */
    private function embedImagesInHtml($htmlContent)
    {
        // 1. Ganti <iframe> YouTube dengan <a> pakai regex
        $htmlContent = preg_replace_callback(
            '/<iframe[^>]*src=["\\\']([^"\\\']+youtube[^"\\\']+)["\\\'][^>]*><\\/iframe>/i',
            function ($matches) {
                $src = $matches[1];
                // Ambil video ID
                if (preg_match('/(?:youtube(?:-nocookie)?\\.com\\/(?:embed\\/|v\\/|watch\\?v=|watch\\?.+&v=)([a-zA-Z0-9_-]{11})|youtu\\.be\\/([a-zA-Z0-9_-]{11}))/',$src, $idMatch)) {
                    $videoId = $idMatch[1] ?? $idMatch[2] ?? null;
                    if ($videoId) {
                        $youtubeLink = 'https://www.youtube.com/watch?v=' . $videoId;
                        return '<a href="' . $youtubeLink . '" target="_blank" style="color: #1e40af; text-align: center; display: block; margin-bottom: 1em; text-decoration: underline;">Tonton video di YouTube: ' . $youtubeLink . '</a>';
                    }
                }
                // Jika gagal, hapus saja iframe
                return '';
            },
            $htmlContent
        );

        // 2. Proses gambar seperti biasa
        $htmlContent = '<div>' . $htmlContent . '</div>';
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');

            Log::info('Processing image src: ' . $src);

            // Check if it's a full URL (http or https)
            if (Str::startsWith($src, 'http://') || Str::startsWith($src, 'https://')) {
                // Attempt to fetch external image data
                $imageData = @file_get_contents($src); // Use @ to suppress warnings, handle error explicitly

                if ($imageData !== false) {
                    $type = pathinfo($src, PATHINFO_EXTENSION);
                    if (empty($type)) {
                        // Try to guess type from content-type header if available
                        $headers = get_headers($src, 1);
                        if (isset($headers['Content-Type'])) {
                            if (is_array($headers['Content-Type'])) {
                                $contentType = $headers['Content-Type'][0];
                            } else {
                                $contentType = $headers['Content-Type'];
                            }
                            $type = explode('/', $contentType)[1] ?? null;
                        }
                    }

                    if ($type) {
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($imageData);
                        $img->setAttribute('src', $base64);
                        Log::info('External image converted to Base64 successfully.');
                    } else {
                        Log::warning('Could not determine image type for: ' . $src);
                    }
                } else {
                    Log::error('Failed to fetch external image: ' . $src);
                }
            } else if (Str::startsWith($src, '/storage/')) { // Keep handling for local storage images if any
                $imagePath = public_path($src);
                Log::info('Resolved local image path: ' . $imagePath);

                if (file_exists($imagePath)) {
                    $type = pathinfo($imagePath, PATHINFO_EXTENSION);
                    $data = file_get_contents($imagePath);
                    if ($data === false) {
                        Log::error('Failed to get contents of local image file: ' . $imagePath);
                        continue;
                    }
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    $img->setAttribute('src', $base64);
                    Log::info('Local image converted to Base64 successfully.');
                } else {
                    Log::warning('Local image file not found for embedding in PDF: ' . $imagePath);
                }
            } else {
                Log::info('Skipping unsupported image src format: ' . $src);
            }
        }

        // Ambil isi <div> saja (tanpa <html><body>)
        $body = $dom->getElementsByTagName('div')->item(0);
        $innerHTML = '';
        foreach ($body->childNodes as $child) {
            $innerHTML .= $dom->saveHTML($child);
        }
        return $innerHTML;
    }

    /**
     * Download a single module as PDF.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function downloadSingleModulePdf(Module $module)
    {
        $module->load('moduleCategory', 'major');

        $thumbnailBase64 = null;
        if ($module->thumbnail) {
            // Directly fetch thumbnail from its URL (Cloudinary)
            $thumbnailData = @file_get_contents($module->thumbnail); // Use @ to suppress warnings

            if ($thumbnailData !== false) {
                $type = pathinfo($module->thumbnail, PATHINFO_EXTENSION);
                if (empty($type)) {
                    // Try to guess type from content-type header if available
                    $headers = get_headers($module->thumbnail, 1);
                    if (isset($headers['Content-Type'])) {
                        if (is_array($headers['Content-Type'])) {
                            $contentType = $headers['Content-Type'][0];
                        } else {
                            $contentType = $headers['Content-Type'];
                        }
                        $type = explode('/', $contentType)[1] ?? null;
                    }
                }
                if ($type) {
                    $thumbnailBase64 = 'data:image/' . $type . ';base64,' . base64_encode($thumbnailData);
                    Log::info('Thumbnail Base64 generated for: ' . $module->thumbnail);
                } else {
                    Log::warning('Could not determine thumbnail type for: ' . $module->thumbnail);
                }
            } else {
                Log::error('Failed to fetch thumbnail from URL: ' . $module->thumbnail);
            }
        }

        $processedContent = $this->embedImagesInHtml($module->content);

        // Log the processed HTML content before passing it to PDF for debugging
        Log::debug('Processed HTML content for PDF:', ['content' => $processedContent]);

        $data = [
            'module' => $module,
            'thumbnailBase64' => $thumbnailBase64,
            'processedContent' => $processedContent,
        ];

        $pdf = Pdf::loadView('santri.modules.pdf.single_module', $data);
        return $pdf->download(Str::slug($module->name) . '.pdf');
    }

    /**
     * Download modules by category as a ZIP archive containing PDFs.
     *
     * @param  string  $categoryName
     * @return \Illuminate\Http\Response
     */
    public function downloadModulesByCategoryZip($categoryName)
    {
        $category = ModuleCategory::where('name', $categoryName)->first();

        if (!$category) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        $modules = $category->modules()->with('moduleCategory', 'major')->get();

        if ($modules->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada modul ditemukan untuk kategori ini.');
        }

        $zipFileName = 'modul-' . Str::slug($categoryName) . '.zip';
        $tempPdfsDir = storage_path('app/temp_pdfs');

        // Ensure the temporary directory exists using native PHP functions
        if (!is_dir($tempPdfsDir)) {
            if (!mkdir($tempPdfsDir, 0775, true)) { // 0775 for read/write/execute for owner/group, read/execute for others
                Log::error('Failed to create temporary PDF directory: ' . $tempPdfsDir);
                return redirect()->back()->with('error', 'Gagal membuat direktori sementara untuk PDF.');
            }
        }

        $zip = new ZipArchive;
        $zipFilePath = $tempPdfsDir . '/' . $zipFileName;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($modules as $module) {
                $thumbnailBase64 = null;
                if ($module->thumbnail) {
                    $thumbnailData = @file_get_contents($module->thumbnail);

                    if ($thumbnailData !== false) {
                        $type = pathinfo($module->thumbnail, PATHINFO_EXTENSION);
                        if (empty($type)) {
                            $headers = get_headers($module->thumbnail, 1);
                            if (isset($headers['Content-Type'])) {
                                if (is_array($headers['Content-Type'])) {
                                    $contentType = $headers['Content-Type'][0];
                                } else {
                                    $contentType = $headers['Content-Type'];
                                }
                                $type = explode('/', $contentType)[1] ?? null;
                            }
                        }
                        if ($type) {
                            $thumbnailBase64 = 'data:image/' . $type . ';base64,' . base64_encode($thumbnailData);
                            Log::info('Thumbnail Base64 generated for ZIP: ' . $module->thumbnail);
                        } else {
                            Log::warning('Could not determine thumbnail type for ZIP: ' . $module->thumbnail);
                        }
                    } else {
                        Log::error('Failed to fetch thumbnail from URL for ZIP: ' . $module->thumbnail);
                    }
                }

                $processedContent = $this->embedImagesInHtml($module->content);

                // Log the processed HTML content before passing it to PDF
                Log::debug('Processed HTML content for PDF (ZIP):', ['content' => $processedContent]);

                $data = [
                    'module' => $module,
                    'thumbnailBase64' => $thumbnailBase64,
                    'processedContent' => $processedContent,
                ];

                $pdf = Pdf::loadView('santri.modules.pdf.single_module', $data);
                $pdfFileName = Str::slug($module->name) . '.pdf';
                $pdfPath = $tempPdfsDir . '/' . $pdfFileName;

                // --- START New Logging --- //
                Log::info('Attempting to save PDF to: ' . $pdfPath);
                Log::info('Parent directory for PDF: ' . dirname($pdfPath));
                Log::info('Is parent directory an actual directory? ' . (is_dir(dirname($pdfPath)) ? 'Yes' : 'No'));
                Log::info('Is parent directory writable? ' . (is_writable(dirname($pdfPath)) ? 'Yes' : 'No'));
                // --- END New Logging --- //

                $pdf->save($pdfPath);
                $zip->addFile($pdfPath, $pdfFileName);
            }
            $zip->close();

            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        }

        return redirect()->back()->with('error', 'Gagal membuat file ZIP.');
    }
}
