#!/usr/bin/env python3
# -*- coding: utf-8 -*-

# Read the file with UTF-8 encoding
with open(r'd:\ANDERSON\monitoringkos\monitoring-kos\resources\views\login.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Define replacements
replacements = {
    'â˜€ï¸': '☀️',
    'ðŸŌ™': '🌙',
    'ðŸ'¤': '👤',
    'â†¶': '↶',
    'â˜Žï¸': '☎️',
    'ðŸ'¬': '💬',
    'ðŸ"‹': '📋',
    'ðŸ"º': '📺',
    'ðŸ›ï¸': '🛏️',
    'ðŸš½': '🚽',
    'ðŸš°': '🚰',
    'ðŸ"¡': '📡',
    'ðŸ…¿ï¸': '🅿️',
    'â„ï¸': '❄️',
    'Ã—': '×',
    'ðŸ›¡ï¸': '🛡️',
    'ðŸšª': '🚪',
}

# Apply replacements
for old_str, new_str in replacements.items():
    content = content.replace(old_str, new_str)

# Write the corrected file
with open(r'd:\ANDERSON\monitoringkos\monitoring-kos\resources\views\login.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('File fixed successfully!')
