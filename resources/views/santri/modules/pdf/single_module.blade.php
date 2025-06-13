<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $module->title }}</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            line-height: 1.5; /* Slightly relaxed line-height */
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .container {
            width: 90%; /* Use percentage for better adaptation to paper width */
            margin: 20px auto; /* Adjusted vertical margin */
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px; /* Simple border-radius */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Simple box-shadow */
        }
        h1 {
            font-size: 26px; /* Adjusted main heading size */
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
            margin-top: 0;
            margin-bottom: 12px;
        }
        h2 {
            font-size: 18px; /* Adjusted sub-heading size */
            font-weight: 600;
            color: #1f2937;
            margin-top: 20px;
            margin-bottom: 8px;
        }
        .meta-info {
            font-size: 13px;
            color: #6b7280;
            margin-top: 8px;
            margin-bottom: 15px;
        }
        .badge-container {
            display: block;
            margin-top: 12px;
            margin-bottom: 20px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 500;
            line-height: 1;
            white-space: nowrap;
            margin-right: 6px;
            margin-bottom: 6px;
        }
        .badge.blue {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .badge.purple {
            background-color: #f3e8ff;
            color: #6b21a8;
        }
        .module-thumbnail {
            max-width: 100%; /* Allow thumbnail to scale within container */
            height: auto;
            display: block;
            margin: 15px auto; /* Centered with adjusted margin */
            border-radius: 8px; /* Simple border-radius */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Simple box-shadow */
        }
        .module-content {
            margin-top: 20px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .module-content p {
            margin-bottom: 1em;
            text-align: justify;
        }
        .module-content ul, .module-content ol {
            margin-left: 1.5em;
            margin-bottom: 1em;
        }
        .module-content li {
            margin-bottom: 0.5em;
        }
        .module-content img {
            max-width: 100%; /* Allow images in content to scale within their parent */
            height: auto;
            display: block;
            margin: 1em auto;
            border-radius: 8px; /* Simple border-radius */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Simple box-shadow */
        }
        .module-content pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: monospace;
            font-size: 0.9em;
            margin-bottom: 1em;
        }
        .module-content strong {
            font-weight: 700;
        }
        .module-content em {
            font-style: italic;
        }
        .module-content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1em;
        }
        .module-content th, .module-content td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .module-content th {
            background-color: #f2f2f2;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        @if ($thumbnailBase64)
            <img src="{{ $thumbnailBase64 }}" alt="Thumbnail Modul" class="module-thumbnail">
        @endif

        <h1>{{ $module->name }}</h1>
        <div class="meta-info">
            <span>Dibuat pada: {{ \Carbon\Carbon::parse($module->created_at)->locale('id')->translatedFormat('d F Y') }}</span>
        </div>

        <div class="badge-container">
            Kategori:
            @forelse($module->moduleCategory as $category)
                <span class="badge blue">{{ $category->name }}</span>
            @empty
                <span class="badge">Tidak ada kategori</span>
            @endforelse
            @if ($module->major)
                <span class="badge purple">{{ $module->major->name }}</span>
            @endif
        </div>

        @if ($module->description)
            <h2>Deskripsi</h2>
            <p>{{ $module->description }}</p>
        @endif

        @if ($processedContent)
            <div class="module-content">
                <h2>Konten Modul</h2>
                <div>{!! $processedContent !!}</div>
            </div>
        @endif
    </div>
</body>
</html>
