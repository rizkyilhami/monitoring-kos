#!/usr/bin/env python
# -*- coding: utf-8 -*-
import os
import sys

filepath = 'resources/views/login.blade.php'
with open(filepath, 'rb') as f:
    content = f.read()

# Replace UTF-8 encoded corrupted emojis with proper UTF-8 emojis
# The corrupted patterns appear to be double-encoded
content = content.replace(b'\xc3\xa2\xc2\x98\xc2\x80\xc3\xaf\xc2\xb8', '☀️'.encode('utf-8'))
content = content.replace(b'\xc3\xb0\xc2\x9f\xc2\x8c\xc2\x99', '🌙'.encode('utf-8'))
content = content.replace(b'\xc3\xb0\xc2\x9f\xc2\x91\xc2\xa4', '👤'.encode('utf-8'))

with open(filepath, 'wb') as f:
    f.write(content)

print("Fixed corrupted emojis")
