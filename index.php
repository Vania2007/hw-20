<?php
$poemsPath = "poems";
$htmlPath = "poems-html";

if (!is_dir($htmlPath)) {
    mkdir($htmlPath);
}

if (is_dir($poemsPath)) {
    $files = scandir($poemsPath);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $filePath = $poemsPath . "/" . $file;
        if (is_file($filePath)) {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (empty($lines)) {
                continue;
            }

            $fileNameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);

            $title = array_shift($lines);
            $body = implode("\n", $lines);

            $htmlContent = <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$title</title>
</head>
<body>
    <h1>$title</h1>
    <pre>
$body
    </pre>
</body>
</html>
EOD;

            $htmlFilePath = $htmlPath . "/" . $fileNameWithoutExtension . ".html";

            file_put_contents($htmlFilePath, $htmlContent);

            echo "HTML-файл створено: $htmlFilePath\n";
        }
    }
} else {
    echo "Директорія $poemsPath не існує.\n";
}
?>
