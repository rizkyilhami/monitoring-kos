<?php
$filePath = 'resources/views/login.blade.php';
$fileContent = file_get_contents($filePath);

// Use regex to replace any content inside specific tags with proper emojis
$fileContent = preg_replace('/<span id="sun-icon">[^<]*<\/span>/', '<span id="sun-icon">☀️</span>', $fileContent);
$fileContent = preg_replace('/<div class="icon-wrapper user">[^<]*<\/div>/', '<div class="icon-wrapper user">👤</div>', $fileContent);

// For moon, target the dark mode option
$fileContent = preg_replace('/<button class="theme-option" onclick="setTheme\(\'dark\'\)">.*?<span>[^<]*<\/span>/', '<button class="theme-option" onclick="setTheme(\'dark\')"><span>🌙</span>', $fileContent);

file_put_contents($filePath, $fileContent);
echo "Fixed corrupted emojis with regex\n";
