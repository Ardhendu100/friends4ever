<!-- resources/views/grapesjs.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>GrapesJS Demo</title>
    <link rel="stylesheet" href="{{ asset('grapesjs/grapes.min.css') }}">
</head>
<body>
    <div id="grapesjs-container"></div>

    <script src="{{ asset('grapesjs/grapes.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editor = grapesjs.init({
                container: '#grapesjs-container',
                // Configure GrapesJS options as needed
                storageManager: {
                    type: 'local',
                    autoload: true,
                    autosave: true,
                    stepsBeforeSave: 1
                },
                plugins: ['gjs-preset-webpage'],
                pluginsOpts: {
                    'gjs-preset-webpage': {
                        modalImportTitle: 'Import Template',
                        modalImportButton: 'Import',
                        modalImportLabel: '',
                        filestackOpts: {}, // Options for the Filestack uploader
                        noticeOnUnload: true,
                        customStyleManager: [] // Array of custom stylesheets
                    }
                },
                // Initialize with initial content
                fromElement: true,
                height: '100%',
                width: 'auto'
            });
        });
    </script>       
</body>
</html>
