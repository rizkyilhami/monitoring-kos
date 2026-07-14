<?php
$file = 'd:\\ANDERSON\\monitoringkos\\monitoring-kos\\resources\\views\\login.blade.php';
$content = file_get_contents($file);

// Target the specific theme buttons with corrupted spans
// Match and replace the entire button elements
$content = preg_replace(
    '/<button class="theme-option active" onclick="setTheme\(\'light\'\)">[\s\S]*?<span>.*?<\/span>[\s\S]*?<\/button>/',
    '<button class="theme-option active" onclick="setTheme(\'light\')">
                                <span>☀️</span>
                                <span>Mode Terang</span>
                            </button>',
    $content
);

$content = preg_replace(
    '/<button class="theme-option" onclick="setTheme\(\'dark\'\)">[\s\S]*?<span>.*?<\/span>[\s\S]*?<\/button>/',
    '<button class="theme-option" onclick="setTheme(\'dark\')">
                                <span>🌙</span>
                                <span>Mode Gelap</span>
                            </button>',
    $content
);

file_put_contents($file, $content);
echo "Theme buttons fixed!\n";
