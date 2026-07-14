@echo off
REM Use Windows' native encoding tools to fix the file
REM Read file, apply fixes, write back

powershell -NoProfile -Command ^
  "$file = 'resources/views/login.blade.php';" ^
  "$content = [System.IO.File]::ReadAllText($file);" ^
  "$content = $content -creplace 'sun-icon\">.*?</span>', 'sun-icon\">☀️</span>';" ^
  "$content = $content -creplace 'user\">.*?</div>', 'user\">👤</div>';" ^
  "$content = $content -creplace 'Mode Gelap</span>.*?<span>.*?</span>', 'Mode Gelap</span></button><button class=\"theme-option\" onclick=\"setTheme(''dark'')\"><span>🌙</span>';" ^
  "[System.IO.File]::WriteAllText($file, $content);" ^
  "Write-Host 'Fixed'"
