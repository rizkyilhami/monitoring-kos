<?php
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';
$content = file_get_contents($file);

// Simple direct regex that handles the theme menu buttons
$pattern = '/Mode Terang<\/span>[\s\n]*<\/button>[\s\n]*<button class="theme-option" onclick="setTheme\(\'dark\'\)">[\s\n]*<span>.*?<\/span>/';
$replacement = 'Mode Terang</span></button>
                            <button class="theme-option" onclick="setTheme(\'dark\')">
                                <span>🌙</span>';

$content = preg_replace($pattern, $replacement, $content);

// Fix the light mode button
$pattern2 = '/<button class="theme-option active" onclick="setTheme\(\'light\'\)">[\s\n]*<span>.*?<\/span>/';
$replacement2 = '<button class="theme-option active" onclick="setTheme(\'light\')">
                                <span>☀️</span>';

$content = preg_replace($pattern2, $replacement2, $content);

file_put_contents($file, $content);
echo "Fixed theme buttons\n";
