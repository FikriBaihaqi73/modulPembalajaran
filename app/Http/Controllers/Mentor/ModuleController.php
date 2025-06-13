<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mentor = Auth::user();
        $query = Module::where('user_id', $mentor->id)->with(['major', 'moduleCategory']);

        // Apply search filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Apply module category filter (if module_category_ids is provided as an array)
        if ($request->has('module_category_ids') && is_array($request->input('module_category_ids'))) {
            $categoryIds = $request->input('module_category_ids');
            $query->whereHas('moduleCategory', function ($q) use ($categoryIds) {
                $q->whereIn('module_categories.id', $categoryIds);
            });
        } else if ($request->has('module_category_id') && $request->input('module_category_id') != '') {
            // Fallback for single category filter if still used (can be removed later if not needed)
            $categoryId = $request->input('module_category_id');
            $query->whereHas('moduleCategory', function ($q) use ($categoryId) {
                $q->where('module_categories.id', $categoryId);
            });
        }

        $modules = $query->paginate(10);
        $moduleCategories = ModuleCategory::where('major_id', $mentor->major_id)->get(); // Get categories for the filter dropdown

        return view('mentor.modules.index', compact('modules', 'moduleCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mentor = Auth::user();
        $moduleCategories = ModuleCategory::where('major_id', $mentor->major_id)->get();
        return view('mentor.modules.create', compact('moduleCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mentor = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml,image/webp|max:3072', // Max 3MB (3072 KB)
            'module_category_ids' => ['required', 'array'], // Expect an array of IDs
            'module_category_ids.*' => ['exists:module_categories,id',
                function ($attribute, $value, $fail) use ($mentor) {
                    if (!ModuleCategory::where('id', $value)->where('major_id', $mentor->major_id)->exists()) {
                        $fail('Kategori modul yang dipilih tidak valid untuk jurusan Anda.');
                    }
                },
            ],
        ]);

        $thumbnailUrl = null;
        if ($request->hasFile('thumbnail')) {
            try {
                $config = new Configuration();
                $config->cloud->cloudName = env('CLOUDINARY_CLOUD_NAME');
                $config->cloud->apiKey = env('CLOUDINARY_API_KEY');
                $config->cloud->apiSecret = env('CLOUDINARY_API_SECRET');
                $config->url->secure = true;

                $cloudinary = new Cloudinary($config);

                $imagePath = $request->file('thumbnail')->getRealPath();

                $uploadResult = $cloudinary->uploadApi()->upload($imagePath, [
                    'folder' => 'module_thumbnails',
                    'quality' => 'auto:low'
                ]);

                $thumbnailUrl = $uploadResult['secure_url'];
                Log::info('Returned from Cloudinary SDK (thumbnail):', ['url' => $thumbnailUrl]);

            } catch (\Exception $e) {
                Log::error('Cloudinary upload failed (thumbnail):', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                return redirect()->back()
                    ->with('error', 'Pengunggahan thumbnail gagal: ' . $e->getMessage())
                    ->withInput();
            }
        }

        $module = Module::create([
            'name' => $validatedData['name'],
            'content' => $validatedData['content'],
            'thumbnail' => $thumbnailUrl,
            'major_id' => $mentor->major_id,
            'user_id' => $mentor->id,
        ]);

        // Attach categories to the module
        $module->moduleCategory()->sync($validatedData['module_category_ids']);

        return redirect()->route('mentor.modules.index')->with('success', 'Modul berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mentor = Auth::user();
        $module = Module::where('user_id', $mentor->id)->with(['major', 'moduleCategory'])->findOrFail($id);
        return view('mentor.modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mentor = Auth::user();
        $module = Module::where('user_id', $mentor->id)->with('moduleCategory')->findOrFail($id);
        $moduleCategories = ModuleCategory::where('major_id', $mentor->major_id)->get();
        return view('mentor.modules.edit', compact('module', 'moduleCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mentor = Auth::user();
        $module = Module::where('user_id', $mentor->id)->findOrFail($id);

        $oldContent = $module->content; // Get old content before update

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml,image/webp|max:3072', // Max 3MB (3072 KB)
            'module_category_ids' => ['required', 'array'], // Expect an array of IDs
            'module_category_ids.*' => ['exists:module_categories,id',
                function ($attribute, $value, $fail) use ($mentor) {
                    if (!ModuleCategory::where('id', $value)->where('major_id', $mentor->major_id)->exists()) {
                        $fail('Kategori modul yang dipilih tidak valid untuk jurusan Anda.');
                    }
                },
            ],
        ]);

        $thumbnailUrl = $module->thumbnail;
        if ($request->hasFile('thumbnail')) {
            try {
                // Initialize Cloudinary SDK for deletion
                $config = new Configuration();
                $config->cloud->cloudName = env('CLOUDINARY_CLOUD_NAME');
                $config->cloud->apiKey = env('CLOUDINARY_API_KEY');
                $config->cloud->apiSecret = env('CLOUDINARY_API_SECRET');
                $config->url->secure = true;

                $cloudinaryDelete = new Cloudinary($config);

                // Delete old thumbnail if exists
                if ($module->thumbnail) {
                    $publicId = $this->extractCloudinaryPublicId($module->thumbnail, 'module_thumbnails');
                    if ($publicId) {
                        $cloudinaryDelete->uploadApi()->destroy($publicId);
                        Log::info('Old thumbnail deleted from Cloudinary on module update:', ['public_id' => $publicId]);
                    }
                }

                // Initialize Cloudinary SDK for upload
                $cloudinaryUpload = new Cloudinary($config);
                $imagePath = $request->file('thumbnail')->getRealPath();

                $uploadResult = $cloudinaryUpload->uploadApi()->upload($imagePath, [
                    'folder' => 'module_thumbnails',
                    'quality' => 'auto:low'
                ]);

                $thumbnailUrl = $uploadResult['secure_url'];
                Log::info('Returned from Cloudinary SDK (thumbnail update):', ['url' => $thumbnailUrl]);

            } catch (\Exception $e) {
                Log::error('Cloudinary upload failed (thumbnail update):', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                return redirect()->back()
                    ->with('error', 'Pengunggahan thumbnail gagal: ' . $e->getMessage())
                    ->withInput();
            }
        } else if ($request->hasFile('thumbnail') === false && $module->thumbnail) {
            // If thumbnail was previously set but now it's empty (e.g., user removed it)
            try {
                $config = new Configuration();
                $config->cloud->cloudName = env('CLOUDINARY_CLOUD_NAME');
                $config->cloud->apiKey = env('CLOUDINARY_API_KEY');
                $config->cloud->apiSecret = env('CLOUDINARY_API_SECRET');
                $config->url->secure = true;

                $cloudinaryDelete = new Cloudinary($config);

                $publicId = $this->extractCloudinaryPublicId($module->thumbnail, 'module_thumbnails');
                if ($publicId) {
                    $cloudinaryDelete->uploadApi()->destroy($publicId);
                    Log::info('Thumbnail removed by user and deleted from Cloudinary on module update:', ['public_id' => $publicId]);
                }
                $thumbnailUrl = null;
            } catch (\Exception $e) {
                Log::error('Failed to delete thumbnail from Cloudinary on module update (user removed):', [
                    'url' => $module->thumbnail,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        $module->update([
            'name' => $validatedData['name'],
            'content' => $validatedData['content'],
            'thumbnail' => $thumbnailUrl,
        ]);

        // Sync categories to the module
        $module->moduleCategory()->sync($validatedData['module_category_ids']);

        $newContent = $module->content; // Get new content after update

        // Compare old and new content to identify removed images
        $oldImageUrls = $this->extractCloudinaryImageUrls($oldContent);
        $newImageUrls = $this->extractCloudinaryImageUrls($newContent);

        $removedImageUrls = array_diff($oldImageUrls, $newImageUrls);

        if (!empty($removedImageUrls)) {
            try {
                $config = new Configuration();
                $config->cloud->cloudName = env('CLOUDINARY_CLOUD_NAME');
                $config->cloud->apiKey = env('CLOUDINARY_API_KEY');
                $config->cloud->apiSecret = env('CLOUDINARY_API_SECRET');
                $config->url->secure = true;

                $cloudinaryDelete = new Cloudinary($config);

                foreach ($removedImageUrls as $url) {
                    $publicId = $this->extractCloudinaryPublicId($url, 'tiptap_images');
                    if ($publicId) {
                        $cloudinaryDelete->uploadApi()->destroy($publicId);
                        Log::info('Tiptap image deleted from Cloudinary on module update:', ['public_id' => $publicId]);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Failed to delete Tiptap images from Cloudinary on module update:', [
                    'module_id' => $module->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        return redirect()->route('mentor.modules.index')->with('success', 'Modul berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mentor = Auth::user();
        $module = Module::where('user_id', $mentor->id)->findOrFail($id);

        try {
            $config = new Configuration();
            $config->cloud->cloudName = env('CLOUDINARY_CLOUD_NAME');
            $config->cloud->apiKey = env('CLOUDINARY_API_KEY');
            $config->cloud->apiSecret = env('CLOUDINARY_API_SECRET');
            $config->url->secure = true;

            $cloudinaryDelete = new Cloudinary($config);

            // Delete thumbnail from Cloudinary if it exists
            if ($module->thumbnail) {
                $publicId = $this->extractCloudinaryPublicId($module->thumbnail, 'module_thumbnails');
                if ($publicId) {
                    $cloudinaryDelete->uploadApi()->destroy($publicId);
                    Log::info('Thumbnail deleted from Cloudinary on module destroy:', ['public_id' => $publicId]);
                }
            }

            // Delete images from Tiptap content if they exist
            if ($module->content) {
                $imageUrls = $this->extractCloudinaryImageUrls($module->content);
                foreach ($imageUrls as $url) {
                    $publicId = $this->extractCloudinaryPublicId($url, 'tiptap_images');
                    if ($publicId) {
                        $cloudinaryDelete->uploadApi()->destroy($publicId);
                        Log::info('Tiptap image deleted from Cloudinary on module destroy:', ['public_id' => $publicId]);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete Cloudinary assets on module destroy:', [
                'module_id' => $module->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // Optionally, you might want to stop deletion here if Cloudinary deletion is critical
            // return redirect()->back()->with('error', 'Failed to delete associated images.');
        }

        $module->delete();

        return redirect()->route('mentor.modules.index')->with('success', 'Modul berhasil dihapus.');
    }

    /**
     * Helper function to extract Cloudinary image URLs from HTML content.
     */
    private function extractCloudinaryImageUrls(?string $htmlContent): array
    {
        $urls = [];
        if (!$htmlContent) {
            return $urls;
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (str_contains($src, 'res.cloudinary.com') && str_contains($src, '/tiptap_images/')) {
                $urls[] = $src;
            }
        }

        return array_unique($urls);
    }

    /**
     * Helper function to extract Cloudinary public ID from a URL.
     */
    private function extractCloudinaryPublicId(string $url, ?string $expectedFolder = null): ?string
    {
        $urlPath = parse_url($url, PHP_URL_PATH);
        $uploadPos = strpos($urlPath, '/upload/');
        if ($uploadPos !== false) {
            $afterUpload = substr($urlPath, $uploadPos + strlen('/upload/'));
            // Remove version number (e.g., 'v12345/') if present
            if (preg_match('/^v\d+\//', $afterUpload, $matches)) {
                $afterUpload = substr($afterUpload, strlen($matches[0]));
            }

            // At this point, $afterUpload should be "folder/public_id.extension" or "public_id.extension"

            // Find the last dot to separate filename from extension
            $lastDotPos = strrpos($afterUpload, '.');
            if ($lastDotPos !== false) {
                $publicIdWithFolder = substr($afterUpload, 0, $lastDotPos);

                // If an expected folder is provided, ensure the public ID starts with it
                // and return the full public ID including the folder path
                if ($expectedFolder) {
                    if (str_starts_with($publicIdWithFolder, $expectedFolder . '/')) {
                        return $publicIdWithFolder;
                    } else {
                        // Log a warning if the public ID doesn't match the expected folder structure
                        Log::warning('Cloudinary public ID does not match expected folder structure:', [
                            'url' => $url,
                            'extracted_public_id' => $publicIdWithFolder,
                            'expected_folder' => $expectedFolder
                        ]);
                        return null;
                    }
                } else {
                    // No specific folder expected, just return the public ID with folder structure (if any)
                    return $publicIdWithFolder;
                }
            }
        }
        Log::warning('Could not extract public ID from Cloudinary URL (parsing failed):', ['url' => $url, 'expected_folder' => $expectedFolder]);
        return null;
    }

    public function uploadImage(Request $request)
    {
        Log::info('Upload Image Request Received', $request->all());

        if (!$request->hasFile('image')) {
            Log::warning('No image file found in the request.');
            return response()->json(['error' => 'No image uploaded.'], 400);
        }

        $file = $request->file('image');
        Log::info('Image File Details:', [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(), // in bytes
        ]);

        try {
            $request->validate([
                'image' => 'required|image|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml,image/webp|max:3072', // Max 3MB
            ]);
            Log::info('Image validation successful.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Image validation failed:', ['errors' => $e->errors()]);
            return response()->json(['error' => 'Gagal mengunggah gambar. Pastikan ukuran gambar tidak melebihi 3MB dan formatnya benar.'], 422);
        }

        try {
            $config = new Configuration();
            $config->cloud->cloudName = env('CLOUDINARY_CLOUD_NAME');
            $config->cloud->apiKey = env('CLOUDINARY_API_KEY');
            $config->cloud->apiSecret = env('CLOUDINARY_API_SECRET');
            $config->url->secure = true;

            $cloudinary = new Cloudinary($config);

            $imagePath = $request->file('image')->getRealPath();

            $uploadResult = $cloudinary->uploadApi()->upload($imagePath, [
                'folder' => 'tiptap_images',
                'quality' => 'auto:low'
            ]);

            $uploadedFileUrl = $uploadResult['secure_url'];
            Log::info('Cloudinary upload successful:', ['url' => $uploadedFileUrl]);
            return response()->json(['url' => $uploadedFileUrl]);
        } catch (\Exception $e) {
            Log::error('Cloudinary upload failed:', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Gagal mengunggah gambar ke Cloudinary. Silakan coba lagi.'], 500);
        }
    }
}
