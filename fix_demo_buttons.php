<?php

$filePath = 'resources/views/login.blade.php';
$content = file_get_contents($filePath);

// Replace admin demo button emoji with SVG
$adminSVG = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px; stroke-width: 2; margin-bottom: 8px; display: block; margin-left: auto; margin-right: auto;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>';

$content = preg_replace(
    '/<div style="font-size: 20px; margin-bottom: 8px;">.*?<\/div>\s+<div class="demo-btn-admin">Admin Demo<\/div>/s',
    $adminSVG . '\n                            <div class="demo-btn-admin">Admin Demo</div>',
    $content
);

file_put_contents($filePath, $content);
echo "Demo buttons fixed!\n";
?>
