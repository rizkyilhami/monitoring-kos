const fs = require('fs');
const path = require('path');

const filePath = path.join(__dirname, 'resources/views/login.blade.php');

try {
  let content = fs.readFileSync(filePath, 'utf8');
  
  // Replace corrupted emojis with clean ones
  // Using regex patterns that match the corrupted display with surrounding context
  content = content.replace(/<span id="sun-icon">[^<]*<\/span>/g, '<span id="sun-icon">☀️</span>');
  content = content.replace(/<button class="theme-option active" onclick="setTheme\('light'\)">.*?<span>[^<]*<\/span>/s, '<button class="theme-option active" onclick="setTheme(\'light\')"><span>☀️</span>');
  content = content.replace(/<button class="theme-option" onclick="setTheme\('dark'\)">.*?<span>[^<]*<\/span>/s, '<button class="theme-option" onclick="setTheme(\'dark\')"><span>🌙</span>');
  content = content.replace(/<div class="icon-wrapper user">[^<]*<\/div>/g, '<div class="icon-wrapper user">👤</div>');
  content = content.replace(/<button class="undo-btn" onclick="hideContact\(\)">[^<]*Undo<\/button>/g, '<button class="undo-btn" onclick="hideContact()">↶ Undo</button>');
  content = content.replace(/<div class="contact-icon">[^<]*<\/div>/g, '<div class="contact-icon">☎️</div>');
  
  fs.writeFileSync(filePath, content, 'utf8');
  console.log('Fixed all corrupted emojis');
} catch (err) {
  console.error('Error:', err.message);
}
