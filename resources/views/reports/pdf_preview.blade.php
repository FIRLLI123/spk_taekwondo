<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Laporan PDF</title>
    <style>
        :root {
            color-scheme: light;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #0f172a;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .topbar {
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0 16px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #e2e8f0;
            box-sizing: border-box;
            border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        }

        .file-info {
            min-width: 0;
        }

        .title {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        .filename {
            font-size: 12px;
            opacity: 0.8;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 48vw;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-link,
        .action-button {
            border: 0;
            border-radius: 10px;
            padding: 9px 14px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.16s ease, opacity 0.16s ease;
        }

        .action-link:hover,
        .action-button:hover {
            transform: translateY(-1px);
            opacity: 0.96;
        }

        .action-button {
            background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
            color: #fff;
        }

        .action-link {
            background: linear-gradient(135deg, #dc2626 0%, #fb7185 100%);
            color: #fff;
        }

        .viewer {
            width: 100%;
            height: calc(100% - 54px);
            border: 0;
            background: #ffffff;
        }

        @media (max-width: 768px) {
            .topbar {
                height: auto;
                padding: 12px;
                align-items: flex-start;
                flex-direction: column;
            }

            .filename {
                max-width: 100%;
            }

            .viewer {
                height: calc(100% - 116px);
            }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="file-info">
            <div class="title">Preview Laporan PDF</div>
            <div class="filename">{{ $filename }}</div>
        </div>
        <div class="actions">
            <button class="action-button" type="button" onclick="printPdf()">Print PDF</button>
            <a class="action-link" href="{{ $downloadUrl }}">Download PDF</a>
        </div>
    </div>

    <iframe class="viewer" id="pdfViewer" title="Preview PDF"></iframe>

    <script>
        (function () {
            var base64 = @json($pdfBase64);
            var byteChars = atob(base64);
            var byteNumbers = new Array(byteChars.length);

            for (var i = 0; i < byteChars.length; i++) {
                byteNumbers[i] = byteChars.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);
            var blob = new Blob([byteArray], { type: 'application/pdf' });
            var blobUrl = URL.createObjectURL(blob);

            window.__pdfBlobUrl = blobUrl;
            document.getElementById('pdfViewer').src = blobUrl;
        })();

        function printPdf() {
            if (!window.__pdfBlobUrl) {
                return;
            }

            var iframe = document.getElementById('pdfViewer');
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
                return;
            }

            window.open(window.__pdfBlobUrl, '_blank');
        }
    </script>
</body>
</html>
