<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmarthCost Login - Monitoring Kos</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
    @endif
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            font-family: 'Poppins', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,133.3C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            pointer-events: none;
            z-index: 0;
        }

        .sidebar {
            background: rgba(11, 30, 60, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .content-area {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            position: relative;
            overflow-x: hidden;
        }

        .content-area::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .content-area::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(118, 75, 162, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .logo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .logo-box:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .logo-box svg {
            width: 28px;
            height: 28px;
            color: white;
        }

        .sidebar h1 {
            color: white;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 3px;
            padding-bottom: 16px;
            margin-bottom: 16px;
            border-bottom: 2px solid;
            border-image: linear-gradient(90deg, #667eea 0%, #764ba2 100%) 1;
            position: relative;
        }

        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            animation: slideRight 0.6s ease-out;
        }

        @keyframes slideRight {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #a0aec0;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            border-left: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s ease;
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(102, 126, 234, 0.15);
            color: #f1f5f9;
            border-left-color: #667eea;
            padding-left: 24px;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link:hover svg {
            transform: translateX(4px);
            filter: drop-shadow(0 0 8px rgba(102, 126, 234, 0.5));
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.15) 100%);
            color: #f1f5f9;
            border-left-color: #667eea;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }

        .nav-link.active::before {
            width: 100%;
        }

        .theme-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 248, 255, 0.9) 100%);
            border: 1.5px solid rgba(102, 126, 234, 0.3);
            border-radius: 14px;
            color: #1e40af;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15), inset 0 1px 2px rgba(255, 255, 255, 0.8);
            letter-spacing: 0.3px;
        }

        .theme-btn:hover {
            background: linear-gradient(135deg, white 0%, rgba(230, 245, 255, 1) 100%);
            border-color: rgba(102, 126, 234, 0.6);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.25), inset 0 1px 2px rgba(255, 255, 255, 1);
            transform: translateY(-3px) scale(1.02);
        }

        .theme-btn span:first-child {
            font-size: 18px;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .theme-btn:hover span:first-child {
            transform: scale(1.1) rotate(10deg);
        }

        /* Theme Menu */
        .theme-menu {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(240, 248, 255, 0.95) 100%);
            border: 1.5px solid rgba(102, 126, 234, 0.25);
            border-radius: 16px;
            box-shadow: 0 16px 48px rgba(102, 126, 234, 0.2), 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 1000;
            animation: slideDown 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(8px);
            padding: 8px;
            min-width: 180px;
        }

        .theme-menu.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-15px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Spark Effect Styles */
        .spark-container {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .spark {
            position: absolute;
            pointer-events: none;
            font-size: 16px;
            font-weight: bold;
        }

        @keyframes spark-burst {
            0% {
                opacity: 1;
                transform: translate(0, 0) scale(1);
            }

            100% {
                opacity: 0;
                transform: translate(var(--tx), var(--ty)) scale(0);
            }
        }

        .spark.active {
            animation: spark-burst 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        /* House icon animation */
        .house-icon {
            display: inline-block;
            width: 24px;
            height: 24px;
            transition: transform 0.3s ease;
        }

        .theme-btn:hover .house-icon {
            transform: scale(1.1) translateY(-2px);
        }

        .theme-btn.spark-active {
            animation: button-pulse 0.4s ease-out;
        }

        @keyframes button-pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .theme-mode-option {
            padding: 14px 18px;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #1e40af;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.2px;
            position: relative;
            overflow: hidden;
        }

        .theme-mode-option::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.08) 100%);
            opacity: 0;
            transition: opacity 0.25s ease;
            z-index: -1;
            border-radius: 12px;
        }

        .theme-mode-option:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.1) 100%);
            transform: translateX(4px);
            color: #1565d8;
        }

        .theme-mode-option:hover::before {
            opacity: 1;
        }

        .theme-mode-option.active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.25) 0%, rgba(118, 75, 162, 0.2) 100%);
            color: #1565d8;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15), inset 0 1px 3px rgba(255, 255, 255, 0.8);
            transform: translateX(4px) scale(1.02);
        }

        .theme-mode-option span:first-child {
            font-size: 20px;
            display: inline-block;
            transition: transform 0.25s ease;
        }

        .theme-mode-option:hover span:first-child {
            transform: scale(1.15);
        }

        .theme-mode-option.active span:first-child {
            transform: scale(1.2) rotate(5deg);
            animation: pulse 0.5s ease;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1.2) rotate(5deg);
            }

            50% {
                transform: scale(1.25) rotate(5deg);
            }
        }

        /* Language Button */
        .lang-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(139, 92, 246, 0.1) 100%);
            border: 1.5px solid rgba(59, 130, 246, 0.3);
            border-radius: 14px;
            color: #1e40af;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1), inset 0 1px 2px rgba(255, 255, 255, 0.6);
            letter-spacing: 0.3px;
        }

        .lang-btn:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25) 0%, rgba(139, 92, 246, 0.15) 100%);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15), inset 0 1px 2px rgba(255, 255, 255, 0.8);
            transform: translateY(-2px) scale(1.02);
        }

        .lang-btn span:first-child {
            font-size: 16px;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .lang-btn:hover span:first-child {
            transform: rotate(20deg) scale(1.1);
        }

        /* Language Menu */
        .lang-menu {
            display: none;
            position: absolute;
            top: 48px;
            right: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(240, 248, 255, 0.95) 100%);
            border: 1.5px solid rgba(59, 130, 246, 0.25);
            border-radius: 16px;
            box-shadow: 0 16px 48px rgba(59, 130, 246, 0.15), 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 999;
            animation: slideDownLang 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(8px);
            padding: 8px;
            min-width: 190px;
        }

        .lang-menu.show {
            display: block;
        }

        @keyframes slideDownLang {
            from {
                opacity: 0;
                transform: translateY(-15px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .lang-option {
            padding: 14px 18px;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #1e40af;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.2px;
            position: relative;
            overflow: hidden;
        }

        .lang-option::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12) 0%, rgba(139, 92, 246, 0.08) 100%);
            opacity: 0;
            transition: opacity 0.25s ease;
            z-index: -1;
            border-radius: 12px;
        }

        .lang-option:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(139, 92, 246, 0.1) 100%);
            transform: translateX(4px);
            color: #1565d8;
        }

        .lang-option:hover::before {
            opacity: 1;
        }

        .lang-option.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25) 0%, rgba(139, 92, 246, 0.2) 100%);
            color: #1565d8;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15), inset 0 1px 3px rgba(255, 255, 255, 0.8);
            transform: translateX(4px) scale(1.02);
        }

        .lang-option span:first-child {
            font-size: 22px;
            display: inline-block;
            transition: transform 0.25s ease;
            min-width: 24px;
        }

        .lang-option:hover span:first-child {
            transform: scale(1.15) rotate(10deg);
        }

        .lang-option.active span:first-child {
            transform: scale(1.2) rotate(-5deg);
            animation: wave 0.5s ease;
        }

        @keyframes wave {

            0%,
            100% {
                transform: scale(1.2) rotate(-5deg);
            }

            50% {
                transform: scale(1.25) rotate(-5deg);
            }
        }

        /* Dark Mode Styles */
        html.dark-mode {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        }

        html.dark-mode body {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        }

        html.dark-mode .content-area {
            background: rgba(45, 55, 72, 0.95);
            backdrop-filter: blur(20px);
        }

        html.dark-mode .content-area::before,
        html.dark-mode .content-area::after {
            opacity: 0.3;
        }

        html.dark-mode .heading-title {
            color: #f1f5f9;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
            -webkit-text-stroke: 0.6px rgba(0, 0, 0, 0.8);
            text-stroke: 0.6px rgba(0, 0, 0, 0.8);
            paint-order: stroke fill;
        }

        html.dark-mode .heading-subtitle {
            color: rgba(255, 255, 255, 0.8);
        }

        html:not(.dark-mode) .heading-title {
            color: #051d41;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            -webkit-text-stroke: 0.5px rgba(5, 29, 65, 0.5);
            text-stroke: 0.5px rgba(5, 29, 65, 0.5);
        }

        html:not(.dark-mode) .heading-subtitle {
            color: #64748b;
        }

        html.dark-mode .card-login {
            background: linear-gradient(135deg, rgba(55, 65, 81, 0.8) 0%, rgba(55, 65, 81, 0.6) 100%);
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        html.dark-mode .card-login:hover {
            background: linear-gradient(135deg, rgba(75, 85, 99, 0.9) 0%, rgba(75, 85, 99, 0.8) 100%);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.3);
        }

        html.dark-mode .card-login h3 {
            color: #f1f5f9;
        }

        html.dark-mode .card-login p {
            color: #cbd5e1;
        }

        html.dark-mode .icon-wrapper.admin {
            box-shadow: 0 4px 15px rgba(21, 101, 216, 0.3);
        }

        html.dark-mode .icon-wrapper.admin:hover {
            box-shadow: 0 8px 25px rgba(21, 101, 216, 0.5);
        }

        html.dark-mode .icon-wrapper.user {
            box-shadow: 0 4px 15px rgba(52, 181, 121, 0.3);
        }

        html.dark-mode .icon-wrapper.user:hover {
            box-shadow: 0 8px 25px rgba(52, 181, 121, 0.5);
        }

        html.dark-mode .info-banner {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
            border-color: rgba(102, 126, 234, 0.3);
        }

        html.dark-mode .info-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        html.dark-mode .info-text {
            color: #cbd5e1;
        }

        html.dark-mode .form-container {
            background: #374151;
            color: #e2e8f0;
        }

        html.dark-mode .form-header h2 {
            color: #f1f5f9;
        }

        html.dark-mode .form-field label {
            color: #cbd5e1;
        }

        html.dark-mode .password-toggle-btn {
            color: #718096;
        }

        html.dark-mode .password-toggle-btn:hover {
            color: #1565d8;
        }

        html.dark-mode .form-field input {
            background: #2d3748;
            color: #e2e8f0;
            border-color: #4b5563;
        }

        html.dark-mode .form-field input::placeholder {
            color: #9ca3af;
        }

        html.dark-mode .form-field input:focus {
            border-color: #1565d8;
            background: #2d3748;
            color: #e2e8f0;
        }

        html.dark-mode .demo-btn {
            background: #2d3748;
            border-color: #4b5563;
            color: #e2e8f0;
        }

        html.dark-mode .demo-btn:hover {
            background: #3a4556;
        }

        html.dark-mode .demo-select {
            background: #2d3748;
            color: #e2e8f0;
            border-color: #4b5563;
        }

        html.dark-mode .theme-btn {
            background: linear-gradient(135deg, rgba(45, 55, 72, 0.95) 0%, rgba(30, 41, 59, 0.9) 100%);
            border-color: rgba(102, 126, 234, 0.4);
            color: #cbd5e1;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4), inset 0 1px 2px rgba(255, 255, 255, 0.1);
        }

        html.dark-mode .theme-btn:hover {
            background: linear-gradient(135deg, rgba(55, 65, 82, 0.98) 0%, rgba(35, 46, 64, 0.95) 100%);
            border-color: rgba(102, 126, 234, 0.6);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.2), inset 0 1px 2px rgba(255, 255, 255, 0.15);
        }

        html.dark-mode .theme-menu {
            background: linear-gradient(135deg, rgba(45, 55, 72, 0.98) 0%, rgba(30, 41, 59, 0.95) 100%);
            border-color: rgba(102, 126, 234, 0.35);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.5), 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        html.dark-mode .theme-mode-option {
            color: #e2e8f0;
        }

        html.dark-mode .theme-mode-option:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.25) 0%, rgba(118, 75, 162, 0.2) 100%);
            color: #60a5fa;
        }

        html.dark-mode .theme-mode-option.active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.35) 0%, rgba(118, 75, 162, 0.3) 100%);
            color: #60a5fa;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25), inset 0 1px 3px rgba(255, 255, 255, 0.1);
        }

        html.dark-mode .lang-btn {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(139, 92, 246, 0.15) 100%);
            border-color: rgba(59, 130, 246, 0.4);
            color: #93c5fd;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3), inset 0 1px 2px rgba(255, 255, 255, 0.1);
        }

        html.dark-mode .lang-btn:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3) 0%, rgba(139, 92, 246, 0.25) 100%);
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15), inset 0 1px 2px rgba(255, 255, 255, 0.15);
        }

        html.dark-mode .lang-menu {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.98) 0%, rgba(15, 23, 42, 0.95) 100%);
            border-color: rgba(59, 130, 246, 0.35);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.5), 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        html.dark-mode .lang-option {
            color: #93c5fd;
        }

        html.dark-mode .lang-option:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25) 0%, rgba(139, 92, 246, 0.2) 100%);
            color: #60a5fa;
        }

        html.dark-mode .lang-option.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.35) 0%, rgba(139, 92, 246, 0.3) 100%);
            color: #60a5fa;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25), inset 0 1px 3px rgba(255, 255, 255, 0.1);
        }

        html.dark-mode .contact-container {
            background: #374151;
            color: #e2e8f0;
        }

        html.dark-mode .contact-header h2 {
            color: #f1f5f9;
        }

        html.dark-mode .contact-phone {
            color: #f1f5f9;
        }

        html.dark-mode .about-container {
            background: #374151;
            color: #e2e8f0;
        }

        html.dark-mode .about-header {
            border-color: #4b5563;
        }

        html.dark-mode .about-header h2 {
            color: #f1f5f9;
        }

        html.dark-mode .about-title {
            color: #f1f5f9;
        }

        html.dark-mode .about-subtitle {
            color: #cbd5e1;
        }

        html.dark-mode .about-info-card {
            background: #2d3748;
            border-color: #1565d8;
        }

        html.dark-mode .about-info-label {
            color: #9ca3af;
        }

        html.dark-mode .about-info-value {
            color: #f1f5f9;
        }

        html.dark-mode .facility-card {
            background: #2d3748;
            border-color: #4b5563;
        }

        html.dark-mode .facility-card:hover {
            background: #3a4556;
            border-color: #1565d8;
        }

        html.dark-mode .facility-name {
            color: #e2e8f0;
        }

        .heading-title {
            font-size: 38px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 12px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            letter-spacing: -1px;
            -webkit-text-stroke: 0.6px rgba(0, 0, 0, 0.8);
            text-stroke: 0.6px rgba(0, 0, 0, 0.8);
            paint-order: stroke fill;
        }

        .heading-divider {
            width: 60px;
            height: 5px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 3px;
            margin: 16px 0;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .heading-subtitle {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 12px;
            font-weight: 500;
        }

        .card-login {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            border-radius: 20px;
            padding: 32px 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .card-login::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            transition: all 0.4s ease;
        }

        .card-login:hover::before {
            top: -30%;
            right: -30%;
        }

        .card-login:hover {
            box-shadow: 0 16px 48px rgba(102, 126, 234, 0.2);
            transform: translateY(-8px);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
        }

        .icon-wrapper {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            font-size: 48px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            position: relative;
            z-index: 1;
            border: 4px solid;
            overflow: hidden;
        }

        .icon-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .icon-wrapper.admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            animation: rotateIcon 4s linear infinite;
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.35), inset 0 -2px 8px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .icon-wrapper.admin:hover {
            transform: scale(1.15) rotateZ(15deg);
            box-shadow: 0 16px 40px rgba(102, 126, 234, 0.5), inset 0 -2px 8px rgba(0, 0, 0, 0.2);
            animation: rotateIcon 2s linear infinite;
            border-color: rgba(255, 255, 255, 0.6);
        }

        .icon-wrapper.user {
            background: linear-gradient(135deg, #34b579 0%, #1e7e34 100%);
            color: #ffffff;
            animation: pulseIcon 2s ease-in-out infinite;
            box-shadow: 0 12px 32px rgba(52, 181, 121, 0.35), inset 0 -2px 8px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .icon-wrapper.user:hover {
            transform: scale(1.15);
            box-shadow: 0 16px 40px rgba(52, 181, 121, 0.5), inset 0 -2px 8px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.6);
        }

        @keyframes rotateIcon {
            from {
                transform: rotateZ(0deg);
            }

            to {
                transform: rotateZ(360deg);
            }
        }

        @keyframes pulseIcon {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        .card-title {
            font-size: 20px;
            font-weight: 800;
            color: #051d41;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .card-desc {
            font-size: 14px;
            color: #718096;
            margin-bottom: 24px;
            line-height: 1.5;
            max-width: 280px;
            min-height: auto;
            font-weight: 500;
        }

        .btn-login {
            width: 100%;
            padding: 14px 24px;
            border-radius: 12px;
            border: none;
            color: white;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 15px;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.4s ease;
            z-index: -1;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login svg {
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }

        .btn-login:hover svg {
            transform: translateX(2px);
        }

        .btn-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-admin:hover {
            background: linear-gradient(135deg, #5668d4 0%, #6a4092 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(102, 126, 234, 0.4);
        }

        .btn-user {
            background: linear-gradient(135deg, #34b579 0%, #2a9a66 100%);
            box-shadow: 0 6px 20px rgba(52, 181, 121, 0.3);
        }

        .btn-user:hover {
            background: linear-gradient(135deg, #2fa371 0%, #238a58 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(52, 181, 121, 0.4);
        }

        .info-banner {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 1.5px solid rgba(102, 126, 234, 0.3);
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-top: 32px;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .info-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            font-weight: bold;
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.25);
        }

        .info-text {
            font-size: 14px;
            color: #051d41;
            line-height: 1.6;
            font-weight: 500;
        }

        .info-text strong {
            color: #1565d8;
            font-weight: 600;
        }

        .footer-copyright {
            font-size: 12px;
            color: #a0aec0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 20px;
            margin-top: auto;
            line-height: 1.6;
        }

        /* Form Login Modal */
        .form-container {
            display: none;
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            margin-top: 40px;
            animation: slideIn 0.3s ease-out;
        }

        .form-container.show {
            display: block;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #051d41;
        }

        .demo-badge {
            background: #e6f0ff;
            border: 1px solid #d0e2ff;
            color: #1565d8;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .demo-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 24px;
        }

        .demo-btn {
            background: #f4f7fa;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
        }

        .demo-btn:hover {
            background: #eaf2ff;
            border-color: #d0e2ff;
        }

        .demo-btn-admin {
            font-size: 14px;
            font-weight: 600;
            color: #051d41;
        }

        .demo-btn-desc {
            font-size: 12px;
            color: #718096;
            margin-top: 4px;
        }

        .demo-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            color: #051d41;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
        }

        .demo-select:hover {
            border-color: #1565d8;
        }

        .demo-select:focus {
            outline: none;
            border-color: #1565d8;
            box-shadow: 0 0 0 3px rgba(21, 101, 216, 0.1);
        }

        .form-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .form-field {
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-wrapper input {
            width: 100%;
            padding-right: 44px;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #a0aec0;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .password-toggle-btn:hover {
            color: #1565d8;
        }

        .password-toggle-btn svg {
            width: 20px;
            height: 20px;
        }

        .form-field label {
            font-size: 13px;
            font-weight: 600;
            color: #051d41;
            margin-bottom: 8px;
        }

        .form-field input {
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            color: #051d41;
            transition: all 0.3s ease;
        }

        .form-field input:focus {
            outline: none;
            border-color: #1565d8;
            box-shadow: 0 0 0 3px rgba(21, 101, 216, 0.1);
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        .form-desc {
            font-size: 12px;
            color: #718096;
            line-height: 1.5;
            flex: 1;
            min-width: 200px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #1565d8 0%, #0d4bc4 100%);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(7, 96, 221, 0.3);
        }

        .close-btn {
            background: none;
            border: none;
            color: #a0aec0;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            color: #051d41;
        }

        /* Contact Display */
        .contact-container {
            display: none;
            background: white;
            border-radius: 16px;
            padding: 48px 32px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            margin-top: 40px;
            animation: slideIn 0.3s ease-out;
            text-align: center;
        }

        .contact-container.show {
            display: block;
        }

        .contact-header {
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .contact-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #051d41;
        }

        .undo-btn {
            background: white;
            border: 2px solid #1565d8;
            color: #1565d8;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .undo-btn:hover {
            background: #eaf2ff;
            transform: translateY(-2px);
        }

        .contact-icon {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1565d8 0%, #0d4bc4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            margin: 0 auto 32px;
            box-shadow: 0 8px 24px rgba(21, 101, 216, 0.3);
        }

        .contact-info {
            margin-bottom: 32px;
        }

        .contact-label {
            font-size: 14px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .contact-phone {
            font-size: 32px;
            font-weight: 700;
            color: #051d41;
            margin-bottom: 12px;
            letter-spacing: 1px;
        }

        .contact-desc {
            font-size: 14px;
            color: #718096;
            max-width: 400px;
            margin: 0 auto 40px;
            line-height: 1.6;
        }

        .contact-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .contact-action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .contact-action-btn.whatsapp {
            background: #34b579;
            color: white;
        }

        .contact-action-btn.whatsapp:hover {
            background: #2a9a66;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 181, 121, 0.3);
        }

        .contact-action-btn.copy {
            background: #1565d8;
            color: white;
        }

        .contact-action-btn.copy:hover {
            background: #0d4bc4;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(21, 101, 216, 0.3);
        }

        /* About Display */
        .about-container {
            display: none;
            background: white;
            border-radius: 16px;
            padding: 48px 32px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            margin-top: 40px;
            animation: fadeIn 0.5s ease-out;
        }

        .about-container.show {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .about-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
        }

        .about-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #051d41;
            margin: 0;
        }

        .about-title-section {
            margin-bottom: 40px;
        }

        .about-title {
            font-size: 28px;
            font-weight: 700;
            color: #051d41;
            margin-bottom: 16px;
        }

        .about-subtitle {
            font-size: 14px;
            color: #718096;
            line-height: 1.8;
            max-width: 600px;
        }

        .about-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 40px;
        }

        .about-info-card {
            background: #f4f7fa;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #1565d8;
        }

        .about-info-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .about-info-value {
            font-size: 16px;
            color: #051d41;
            font-weight: 600;
        }

        .facilities-section {
            margin-top: 40px;
        }

        .facilities-title {
            font-size: 20px;
            font-weight: 700;
            color: #051d41;
            margin-bottom: 24px;
        }

        .facilities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 16px;
        }

        .facility-card {
            background: linear-gradient(135deg, #e6f0ff 0%, #eaf2ff 100%);
            border: 2px solid #d0e2ff;
            border-radius: 12px;
            padding: 20px 16px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 140px;
        }

        .facility-card:hover {
            background: linear-gradient(135deg, #d0e2ff 0%, #c4deff 100%);
            border-color: #1565d8;
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(21, 101, 216, 0.2);
        }

        .facility-icon {
            font-size: 36px;
            margin-bottom: 12px;
        }

        .facility-name {
            font-size: 13px;
            font-weight: 600;
            color: #051d41;
        }

        /* SmarthCost Title Styling */
        .smarthcost-title-login {
            display: flex;
            gap: 0.2rem;
            font-size: 1.1rem;
            font-weight: 600;
            font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
            letter-spacing: 0.08em;
            padding: 0.5rem 1rem;
            border-radius: 0.6rem;
            background: transparent;
            border: none;
            box-shadow: none;
        }

        .smarthcost-title-login span {
            display: inline-block;
            font-weight: 600;
            color: white;
            animation: simpleBlink 1s ease-in-out infinite;
        }

        .letter-s-login {
            animation-delay: 0s;
        }

        .letter-m-login {
            animation-delay: 0.1s;
        }

        .letter-a-login {
            animation-delay: 0.2s;
        }

        .letter-r-login {
            animation-delay: 0.3s;
        }

        .letter-t-login {
            animation-delay: 0.4s;
        }

        .letter-h-login {
            animation-delay: 0.5s;
        }

        .letter-c-login {
            animation-delay: 0.6s;
        }

        .letter-o-login {
            animation-delay: 0.7s;
        }

        .letter-s2-login {
            animation-delay: 0.8s;
        }

        .letter-t2-login {
            animation-delay: 0.9s;
        }

        @keyframes simpleBlink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 100%;
                height: auto;
                padding: 20px;
                max-height: none;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .content-area {
                min-height: auto;
                padding: 40px 20px;
                max-height: none;
            }

            .heading-title {
                font-size: 28px;
            }

            .cards-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .heading-title {
                font-size: 24px;
            }

            .card-login {
                padding: 24px 16px;
            }

            .icon-wrapper {
                width: 72px;
                height: 72px;
            }

            .theme-btn {
                font-size: 12px;
                padding: 6px 12px;
            }

            .form-container {
                padding: 24px 16px;
            }

            .form-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .demo-buttons {
                grid-template-columns: 1fr;
            }

            .form-fields {
                grid-template-columns: 1fr;
            }

            .form-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-submit {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="flex min-h-screen flex-col lg:flex-row">
        <!-- SIDEBAR KIRI -->
        <aside class="sidebar w-full lg:w-64 p-6 lg:p-8 flex flex-col justify-between">
            <div>
                <div class="sidebar-header flex items-center gap-3">
                    <div class="logo-box">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="smarthcost-title-login">
                        <span class="letter-s-login">S</span>
                        <span class="letter-m-login">m</span>
                        <span class="letter-a-login">a</span>
                        <span class="letter-r-login">r</span>
                        <span class="letter-t-login">t</span>
                        <span class="letter-h-login">h</span>
                        <span class="letter-c-login">C</span>
                        <span class="letter-o-login">o</span>
                        <span class="letter-s2-login">s</span>
                        <span class="letter-t2-login">t</span>
                    </div>
                    <div style="margin-left:8px; position:relative;">
                        <button id="langBtn" class="lang-btn" onclick="toggleLangMenu()"
                            style="padding:10px 14px; font-size:13px; display:inline-flex; align-items:center; gap:8px;"><span>🌐</span>
                            ID</button>
                        <div id="langMenu" class="lang-menu" style="right:0; top:48px;">
                            <button class="lang-option active" data-lang="id"
                                onclick="setLanguage('id')"><span>🇮🇩</span> <span>Indonesia</span></button>
                            <button class="lang-option" data-lang="en" onclick="setLanguage('en')"><span>🇬🇧</span>
                                <span>English</span></button>
                        </div>
                    </div>
                </div>

                <nav class="space-y-1">
                    <a href="javascript:void(0)" onclick="showHome()" class="nav-link active">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        <span data-i18n="nav.beranda">Beranda</span>
                    </a>
                    <a href="javascript:void(0)" onclick="showAbout()" class="nav-link">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 8a1 1 0 000 2h4a1 1 0 000-2H8zm4 4H8a1 1 0 000 2h4a1 1 0 000-2z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span data-i18n="nav.tentang">Tentang</span>
                    </a>
                    <a href="javascript:void(0)" onclick="showContact()" class="nav-link">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.727 1.285 2.298 2.756 3.771 1.471 1.47 3.044 2.41 3.771 2.756l.773-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2.57C6.852 18 2 13.148 2 5.43V3z">
                            </path>
                        </svg>
                        <span data-i18n="nav.kontak">Kontak</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="content-area flex-1 p-8 lg:p-12 flex flex-col relative z-0">
            <div class="relative z-10 max-w-4xl mx-auto w-full">
                <!-- Header dengan Tombol Tema -->
                <div class="flex justify-between items-start mb-12">
                    <div>
                        <h2 class="heading-title" data-i18n="heading.title">Selamat datang di SmarthCost</h2>
                        <div class="heading-divider"></div>
                        <p class="heading-subtitle" data-i18n="heading.subtitle">Silakan pilih jenis akun untuk login ke
                            sistem.</p>
                    </div>
                    <div class="relative">
                        <div class="spark-container">
                            <button class="theme-btn" onclick="createSparkEffect(event); showThemeMenu();">
                                <svg class="house-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                <span data-i18n="theme">Menu</span>
                            </button>
                        </div>
                        <div id="themeMenu" class="theme-menu">
                            <button class="theme-mode-option active" onclick="setTheme('light')">
                                <span>☀️</span>
                                <span data-i18n="theme.light">Mode Terang</span>
                            </button>
                            <button class="theme-mode-option" onclick="setTheme('dark')">
                                <span>🌙</span>
                                <span data-i18n="theme.dark">Mode Gelap</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Grid Kartu Login -->
                <div class="cards-grid grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- KARTU ADMIN -->
                    <div class="card-login" onclick="showLoginForm('admin')">
                        <div class="icon-wrapper admin">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width: 60px; height: 60px; stroke-width: 1.5;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="card-title" data-i18n="card.admin.title">Login Admin</h3>
                        <p class="card-desc" data-i18n="card.admin.desc">Kelola sistem dan data kos</p>
                        <button class="btn-login btn-admin">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            <span data-i18n="card.admin.login">Login sebagai Admin</span>
                        </button>
                    </div>

                    <!-- KARTU USER -->
                    <div class="card-login" onclick="showLoginForm('user')">
                        <div class="icon-wrapper user">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width: 60px; height: 60px; stroke-width: 1.5;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="card-title" data-i18n="card.user.title">Login User</h3>
                        <p class="card-desc" data-i18n="card.user.desc">Akses info dan layanan kos</p>
                        <button class="btn-login btn-user">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            <span data-i18n="card.user.login">Login sebagai User</span>
                        </button>
                    </div>
                </div>

                <!-- INFO BANNER -->
                <div class="info-banner">
                    <div class="info-icon">i</div>
                    <p class="info-text"><strong data-i18n="info.title">Informasi</strong> <span
                            data-i18n="info.desc">Pastikan Anda memiliki akun yang terdaftar untuk dapat login ke
                            sistem.</span></p>
                </div>

                <!-- CONTACT DISPLAY -->
                <div id="contactDisplay" class="contact-container">
                    <div class="contact-header">
                        <h2 data-i18n="contact.header">Hubungi Admin</h2>
                        <button class="undo-btn" onclick="hideContact()">↶ <span
                                data-i18n="undo">Undo</span></button>
                    </div>

                    <div class="contact-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width: 60px; height: 60px; stroke-width: 1.5;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>

                    <div class="contact-info">
                        <div class="contact-label" data-i18n="contact.label">Nomor Telepon Admin</div>
                        <div class="contact-phone">081249471258</div>
                        <p class="contact-desc" data-i18n="contact.desc">Hubungi admin untuk mendapatkan bantuan
                            teknis atau informasi lebih lanjut tentang sistem kami.</p>
                    </div>

                    <div class="contact-actions">
                        <button class="contact-action-btn whatsapp" onclick="openWhatsApp('081249471258')"
                            data-i18n="contact.whatsapp">WhatsApp</button>
                        <button class="contact-action-btn copy" onclick="copyPhone('081249471258')"
                            data-i18n="contact.copy">Salin Nomor</button>
                    </div>
                </div>

                <!-- ABOUT DISPLAY -->
                <div id="aboutDisplay" class="about-container">
                    <div class="about-header">
                        <h2 data-i18n="about.header">Tentang SmarthCost</h2>
                        <button class="undo-btn" onclick="hideAbout()">↶ Undo</button>
                    </div>

                    <div class="about-title-section">
                        <h3 class="about-title" data-i18n="about.title">Kos Modern Dengan Monitoring Listrik Berbasis
                            IoT</h3>
                        <p class="about-subtitle" data-i18n="about.subtitle">
                            SmarthCost adalah platform manajemen kos modern yang mengintegrasikan teknologi IoT untuk
                            monitoring listrik real-time.
                            Kami menyediakan solusi terpadu untuk mengelola kos dengan sistem yang transparan, efisien,
                            dan terpercaya.
                        </p>
                    </div>

                    <div class="about-info-grid">
                        <div class="about-info-card">
                            <div class="about-info-label" data-i18n="about.owner.label">Pemilik Kos</div>
                            <div class="about-info-value" data-i18n="about.owner.value">Rizky ilhami</div>
                        </div>
                        <div class="about-info-card">
                            <div class="about-info-label" data-i18n="about.rooms.label">Kamar Tersedia</div>
                            <div class="about-info-value" data-i18n="about.rooms.value">4 Kamar</div>
                        </div>
                        <div class="about-info-card" style="grid-column: 1 / -1;">
                            <div class="about-info-label" data-i18n="about.address.label">Alamat Kos</div>
                            <div class="about-info-value" data-i18n="about.address.value">Jl.Pahlawan gg 3. Sampang
                            </div>
                        </div>
                    </div>

                    <div class="facilities-section">
                        <h3 class="facilities-title" data-i18n="facilities.title">Fasilitas Kamar</h3>
                        <div class="facilities-grid">
                            <div class="facility-card">
                                <svg class="facility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    style="width:32px;height:32px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 2v4M12 18v4M4.2 4.2l2.8 2.8M17 17l2.8 2.8M2 12h4M18 12h4M4.2 19.8l2.8-2.8M17 7l2.8-2.8" />
                                </svg>
                                <div class="facility-name" data-i18n="facility.ac">AC</div>
                            </div>
                            <div class="facility-card">
                                <svg class="facility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    style="width:32px;height:32px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;">
                                    <rect x="2" y="4" width="20" height="12" rx="2"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></rect>
                                    <path d="M8 20h8" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                                <div class="facility-name" data-i18n="facility.tv">TV</div>
                            </div>
                            <div class="facility-card">
                                <svg class="facility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    style="width:32px;height:32px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;">
                                    <rect x="3" y="2" width="7" height="20" rx="1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></rect>
                                    <rect x="14" y="5" width="6" height="12" rx="1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></rect>
                                    <path d="M10 7h3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="17" cy="8.5" r="0.6" stroke-width="1.5"/>
                                </svg>
                                <div class="facility-name">Kulkas</div>
                            </div>
                            <div class="facility-card">
                                <svg class="facility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    style="width:32px;height:32px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;">
                                    <path d="M3 12v5a1 1 0 001 1h16a1 1 0 001-1v-5" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <rect x="3" y="7" width="6" height="5" rx="1"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></rect>
                                </svg>
                                <div class="facility-name" data-i18n="facility.bed">Kasur</div>
                            </div>
                            <div class="facility-card">
                                <svg class="facility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    style="width:32px;height:32px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;">
                                    <path d="M7 10c0-2 1-3 5-3s5 1 5 3v3a2 2 0 01-2 2H9a2 2 0 01-2-2v-3z"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9 17v3" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <div class="facility-name" data-i18n="facility.toilet">Toilet Dalam</div>
                            </div>
                            <div class="facility-card">
                                <svg class="facility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    style="width:32px;height:32px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;">
                                    <path d="M3 12h6v4H3z" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 7v5" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <circle cx="12" cy="14" r="1" stroke-width="1.5" />
                                </svg>
                                <div class="facility-name" data-i18n="facility.sink">Wastafel</div>
                            </div>
                            <div class="facility-card">
                                <svg class="facility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    style="width:32px;height:32px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;">
                                    <path d="M2 12c5-5 11-5 16 0" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6 16c3-3 7-3 10 0" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <circle cx="12" cy="19" r="1" stroke-width="1.5" />
                                </svg>
                                <div class="facility-name" data-i18n="facility.wifi">WiFi</div>
                            </div>
                            <div class="facility-card">
                                <svg class="facility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    style="width:32px;height:32px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;">
                                    <path d="M3 13h18v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3z" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5 13V9a3 3 0 013-3h8a3 3 0 013 3v4" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <circle cx="7.5" cy="17.5" r="1" stroke-width="1.5" />
                                    <circle cx="16.5" cy="17.5" r="1" stroke-width="1.5" />
                                </svg>
                                <div class="facility-name" data-i18n="facility.parking">Parkiran</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FORM LOGIN -->
                <div id="loginForm" class="form-container">
                    <div class="form-header">
                        <h2 data-i18n="form.header">Masuk ke Akun Anda</h2>
                        <button class="close-btn" onclick="closeLoginForm()">×</button>
                    </div>

                    @if ($errors->any())
                        <div
                            style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 13px;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Demo Account Buttons -->
                    <div class="demo-buttons">
                        <button type="button" class="demo-btn" onclick="fillDemo('admin@gmail.com', 'admin123')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width: 24px; height: 24px; stroke-width: 2; margin-bottom: 8px; display: block; margin-left: auto; margin-right: auto; color: #1565d8;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                            <div class="demo-btn-admin" data-i18n="demo.admin">Admin Demo</div>
                            <div class="demo-btn-desc">admin@gmail.com</div>
                        </button>
                        <button type="button" class="demo-btn" onclick="toggleRoomSelect()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width: 24px; height: 24px; stroke-width: 2; margin-bottom: 8px; display: block; margin-left: auto; margin-right: auto; color: #1565d8;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4l4 2m-2-2l-4-2">
                                </path>
                            </svg>
                            <div class="demo-btn-admin" data-i18n="demo.select">Pilih Akun Kamar</div>
                            <div class="demo-btn-desc" data-i18n="demo.select.desc">Pilih akun kamar demo</div>
                        </button>
                    </div>

                    <!-- Room Select -->
                    <select id="demoRoom" class="demo-select" style="display: none;" onchange="fillRoomDemo()">
                        <option value="">Pilih kamar...</option>
                        <option value="kamar1@gmail.com|user123">Kamar 1 - kamar1@gmail.com</option>
                        <option value="kamar2@gmail.com|user123">Kamar 2 - kamar2@gmail.com</option>
                        <option value="kamar3@gmail.com|user123">Kamar 3 - kamar3@gmail.com</option>
                        <option value="kamar4@gmail.com|user123">Kamar 4 - kamar4@gmail.com</option>
                    </select>

                    <!-- Form -->
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        <div class="form-fields">
                            <div class="form-field">
                                <label for="email" data-i18n="form.email.label">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    required placeholder="Masukkan email Anda"
                                    data-i18n-placeholder="form.email.placeholder">
                            </div>
                            <div class="form-field">
                                <label for="password" data-i18n="form.password.label">Password</label>
                                <div class="password-wrapper">
                                    <input type="password" id="password" name="password" required
                                        placeholder="Masukkan password Anda"
                                        data-i18n-placeholder="form.password.placeholder">
                                    <button type="button" class="password-toggle-btn"
                                        onclick="togglePasswordVisibility()">
                                        <svg id="eyeIcon" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-footer">
                            <p class="form-desc" data-i18n="form.desc">Masukkan email dan password untuk masuk ke
                                sistem.</p>
                            <button type="submit" class="btn-submit" data-i18n="form.submit">Masuk Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function showThemeMenu() {
            const menu = document.getElementById('themeMenu');
            menu.classList.toggle('show');
        }

        function createSparkEffect(event) {
            const button = event.currentTarget;
            const container = button.closest('.spark-container');
            const sparkChars = ['✨', '⭐', '💫', '🌟', '✦'];
            
            // Add pulse animation to button
            button.classList.remove('spark-active');
            // Trigger reflow to restart animation
            void button.offsetWidth;
            button.classList.add('spark-active');
            
            // Create sparks
            for (let i = 0; i < 8; i++) {
                const spark = document.createElement('div');
                spark.className = 'spark';
                spark.textContent = sparkChars[Math.floor(Math.random() * sparkChars.length)];
                
                // Random angle and distance
                const angle = (i / 8) * Math.PI * 2;
                const distance = 60 + Math.random() * 40;
                const tx = Math.cos(angle) * distance;
                const ty = Math.sin(angle) * distance;
                
                spark.style.setProperty('--tx', `${tx}px`);
                spark.style.setProperty('--ty', `${ty}px`);
                
                container.appendChild(spark);
                spark.classList.add('active');
                
                // Remove spark after animation
                setTimeout(() => spark.remove(), 800);
            }
        }

        function toggleLangMenu() {
            const menu = document.getElementById('langMenu');
            menu.classList.toggle('show');
        }

        function setTheme(mode) {
            const html = document.documentElement;
            const themeMenu = document.getElementById('themeMenu');
            const themeOptions = document.querySelectorAll('#themeMenu .theme-mode-option');

            if (mode === 'light') {
                html.classList.remove('dark-mode');
            } else if (mode === 'dark') {
                html.classList.add('dark-mode');
            }

            // Update active button
            themeOptions.forEach(option => option.classList.remove('active'));
            if (mode === 'light') {
                themeOptions[0].classList.add('active');
            } else {
                themeOptions[1].classList.add('active');
            }

            // Save to localStorage
            localStorage.setItem('theme', mode);

            // Close menu
            themeMenu.classList.remove('show');
        }

        function showLoginForm(type) {
            const form = document.getElementById('loginForm');
            form.classList.add('show');
            document.getElementById('demoRoom').style.display = 'none';
            form.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function closeLoginForm() {
            const form = document.getElementById('loginForm');
            form.classList.remove('show');
            document.getElementById('demoRoom').style.display = 'none';
        }

        function toggleRoomSelect() {
            const select = document.getElementById('demoRoom');
            select.style.display = select.style.display === 'none' ? 'block' : 'none';
            if (select.style.display === 'block') {
                select.focus();
            }
        }

        function fillDemo(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            document.getElementById('demoRoom').style.display = 'none';
        }

        function fillRoomDemo() {
            const select = document.getElementById('demoRoom');
            const value = select.value;
            if (!value) return;

            const [email, password] = value.split('|');
            fillDemo(email, password);
        }

        function showContact() {
            const contactDisplay = document.getElementById('contactDisplay');
            const aboutDisplay = document.getElementById('aboutDisplay');
            const loginForm = document.getElementById('loginForm');
            const infoBox = document.querySelector('.info-banner');
            const cardsGrid = document.querySelector('.cards-grid');
            const headerContent = document.querySelector('.heading-title').parentElement.parentElement;
            const navLinks = document.querySelectorAll('.nav-link');

            // Hide other elements
            if (loginForm) loginForm.classList.remove('show');
            if (aboutDisplay) aboutDisplay.classList.remove('show');
            if (infoBox) infoBox.style.display = 'none';
            if (cardsGrid) cardsGrid.style.display = 'none';
            if (headerContent) {
                const titleDiv = headerContent.querySelector('div');
                if (titleDiv) titleDiv.style.display = 'none';
            }

            // Show contact
            contactDisplay.classList.add('show');

            // Update active nav link
            navLinks.forEach(link => link.classList.remove('active'));
            navLinks[2].classList.add('active');

            contactDisplay.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function hideContact() {
            const contactDisplay = document.getElementById('contactDisplay');
            const infoBox = document.querySelector('.info-banner');
            const cardsGrid = document.querySelector('.cards-grid');
            const headerContent = document.querySelector('.heading-title').parentElement.parentElement;
            const navLinks = document.querySelectorAll('.nav-link');

            // Hide contact
            contactDisplay.classList.remove('show');

            // Show other elements
            if (infoBox) infoBox.style.display = 'flex';
            if (cardsGrid) cardsGrid.style.display = 'grid';
            if (headerContent) {
                const titleDiv = headerContent.querySelector('div');
                if (titleDiv) titleDiv.style.display = 'block';
            }

            // Update active nav link to home
            navLinks.forEach(link => link.classList.remove('active'));
            navLinks[0].classList.add('active');

            // Scroll back to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function showAbout() {
            const aboutDisplay = document.getElementById('aboutDisplay');
            const loginForm = document.getElementById('loginForm');
            const contactDisplay = document.getElementById('contactDisplay');
            const infoBox = document.querySelector('.info-banner');
            const cardsGrid = document.querySelector('.cards-grid');
            const headerContent = document.querySelector('.heading-title').parentElement.parentElement;
            const navLinks = document.querySelectorAll('.nav-link');

            // Hide other elements
            if (loginForm) loginForm.classList.remove('show');
            if (contactDisplay) contactDisplay.classList.remove('show');
            if (infoBox) infoBox.style.display = 'none';
            if (cardsGrid) cardsGrid.style.display = 'none';
            if (headerContent) {
                const titleDiv = headerContent.querySelector('div');
                if (titleDiv) titleDiv.style.display = 'none';
            }

            // Show about
            aboutDisplay.classList.add('show');

            // Update active nav link
            navLinks.forEach(link => link.classList.remove('active'));
            navLinks[1].classList.add('active');

            aboutDisplay.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function hideAbout() {
            const aboutDisplay = document.getElementById('aboutDisplay');
            const infoBox = document.querySelector('.info-banner');
            const cardsGrid = document.querySelector('.cards-grid');
            const headerContent = document.querySelector('.heading-title').parentElement.parentElement;
            const navLinks = document.querySelectorAll('.nav-link');

            // Hide about
            aboutDisplay.classList.remove('show');

            // Show other elements
            if (infoBox) infoBox.style.display = 'flex';
            if (cardsGrid) cardsGrid.style.display = 'grid';
            if (headerContent) {
                const titleDiv = headerContent.querySelector('div');
                if (titleDiv) titleDiv.style.display = 'block';
            }

            // Update active nav link to home
            navLinks.forEach(link => link.classList.remove('active'));
            navLinks[0].classList.add('active');

            // Scroll back to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function showHome() {
            const aboutDisplay = document.getElementById('aboutDisplay');
            const contactDisplay = document.getElementById('contactDisplay');
            const loginForm = document.getElementById('loginForm');
            const infoBox = document.querySelector('.info-banner');
            const cardsGrid = document.querySelector('.cards-grid');
            const headerContent = document.querySelector('.heading-title').parentElement.parentElement;
            const navLinks = document.querySelectorAll('.nav-link');

            // Hide other sections
            if (aboutDisplay) aboutDisplay.classList.remove('show');
            if (contactDisplay) contactDisplay.classList.remove('show');
            if (loginForm) loginForm.classList.remove('show');

            // Show home elements
            if (infoBox) infoBox.style.display = 'flex';
            if (cardsGrid) cardsGrid.style.display = 'grid';
            if (headerContent) {
                const titleDiv = headerContent.querySelector('div');
                if (titleDiv) titleDiv.style.display = 'block';
            }

            // Update active nav link
            navLinks.forEach(link => link.classList.remove('active'));
            navLinks[0].classList.add('active');

            // Scroll back to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function openWhatsApp(phone) {
            const message = 'Halo Admin, saya ingin menghubungi untuk bantuan.';
            const phoneNumber = phone.replace(/\D/g, '');
            const whatsappUrl = `https://wa.me/62${phoneNumber.substring(1)}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }

        function copyPhone(phone) {
            navigator.clipboard.writeText(phone).then(() => {
                alert('Nomor telepon berhasil disalin: ' + phone);
            }).catch(err => {
                console.error('Gagal menyalin:', err);
            });
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Change to eye-off icon
                eyeIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"></path>';
            } else {
                passwordInput.type = 'password';
                // Change back to eye icon
                eyeIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const html = document.documentElement;
            const themeOptions = document.querySelectorAll('#themeMenu .theme-mode-option');

            // Apply saved theme
            if (savedTheme === 'dark') {
                html.classList.add('dark-mode');
                themeOptions[1].classList.add('active');
                themeOptions[0].classList.remove('active');
            } else {
                html.classList.remove('dark-mode');
                themeOptions[0].classList.add('active');
                themeOptions[1].classList.remove('active');
            }

            // Close theme menu when clicking outside
            document.addEventListener('click', function(event) {
                const themeBtn = document.getElementById('themeMenu').previousElementSibling;
                const themeMenu = document.getElementById('themeMenu');

                if (themeBtn && themeMenu) {
                    if (!themeBtn.contains(event.target) && !themeMenu.contains(event.target)) {
                        themeMenu.classList.remove('show');
                    }
                }
            });
        });
    </script>
    <script>
        // Simple client-side translations
        const translations = {
            id: {
                'nav.beranda': 'Beranda',
                'nav.tentang': 'Tentang',
                'nav.kontak': 'Kontak',
                'theme': 'Tema',
                'theme.light': 'Mode Terang',
                'theme.dark': 'Mode Gelap',
                'heading.title': 'Selamat datang di SmarthCost',
                'heading.subtitle': 'Silakan pilih jenis akun untuk login ke sistem.',
                'card.admin.title': 'Login Admin',
                'card.admin.desc': 'Kelola sistem dan data kos',
                'card.admin.login': 'Login sebagai Admin',
                'card.user.title': 'Login User',
                'card.user.desc': 'Akses info dan layanan kos',
                'card.user.login': 'Login sebagai User',
                'info.title': 'Informasi',
                'info.desc': 'Pastikan Anda memiliki akun yang terdaftar untuk dapat login ke sistem.',
                'contact.header': 'Hubungi Admin',
                'undo': 'Undo',
                'contact.label': 'Nomor Telepon Admin',
                'contact.desc': 'Hubungi admin untuk mendapatkan bantuan teknis atau informasi lebih lanjut tentang sistem kami.',
                'contact.whatsapp': 'WhatsApp',
                'contact.copy': 'Salin Nomor',
                'facilities.title': 'Fasilitas Kamar',
                'facility.ac': 'AC',
                'facility.tv': 'TV',
                'facility.bed': 'Kasur',
                'facility.toilet': 'Toilet Dalam',
                'facility.sink': 'Wastafel',
                'facility.wifi': 'WiFi',
                'facility.parking': 'Parkiran',
                'about.header': 'Tentang SmarthCost',
                'about.title': 'Kos Modern Dengan Monitoring Listrik Berbasis IoT',
                'about.subtitle': 'SmarthCost adalah platform manajemen kos modern yang mengintegrasikan teknologi IoT untuk monitoring listrik real-time. Kami menyediakan solusi terpadu untuk mengelola kos dengan sistem yang transparan, efisien, dan terpercaya.',
                'about.owner.label': 'Pemilik Kos',
                'about.owner.value': 'Rizky ilhami',
                'about.rooms.label': 'Kamar Tersedia',
                'about.rooms.value': '4 Kamar',
                'about.address.label': 'Alamat Kos',
                'about.address.value': 'Jl.Pahlawan gg 3. Sampang',
                'form.header': 'Masuk ke Akun Anda',
                'demo.admin': 'Admin Demo',
                'demo.select': 'Pilih Akun Kamar',
                'demo.select.desc': 'Pilih akun kamar demo',
                'form.email.label': 'Email',
                'form.email.placeholder': 'Masukkan email Anda',
                'form.password.label': 'Password',
                'form.password.placeholder': 'Masukkan password Anda',
                'form.desc': 'Masukkan email dan password untuk masuk ke sistem.',
                'form.submit': 'Masuk Sekarang'
            },
            en: {
                'nav.beranda': 'Home',
                'nav.tentang': 'About',
                'nav.kontak': 'Contact',
                'theme': 'Theme',
                'theme.light': 'Light Mode',
                'theme.dark': 'Dark Mode',
                'heading.title': 'Welcome to SmarthCost',
                'heading.subtitle': 'Choose an account type to log in.',
                'card.admin.title': 'Admin Login',
                'card.admin.desc': 'Manage the system and boarding data',
                'card.admin.login': 'Login as Admin',
                'card.user.title': 'User Login',
                'card.user.desc': 'Access boarding info and services',
                'card.user.login': 'Login as User',
                'info.title': 'Information',
                'info.desc': 'Make sure you have a registered account to log in.',
                'contact.header': 'Contact Admin',
                'undo': 'Undo',
                'contact.label': 'Admin Phone Number',
                'contact.desc': 'Contact the admin for technical assistance or more information about our system.',
                'contact.whatsapp': 'WhatsApp',
                'contact.copy': 'Copy Number',
                'facilities.title': 'Room Facilities',
                'facility.ac': 'AC',
                'facility.tv': 'TV',
                'facility.bed': 'Bed',
                'facility.toilet': 'Private Toilet',
                'facility.sink': 'Sink',
                'facility.wifi': 'WiFi',
                'facility.parking': 'Parking',
                'about.header': 'About SmarthCost',
                'about.title': 'Modern Boarding House with IoT-Based Electricity Monitoring',
                'about.subtitle': 'SmarthCost is a modern boarding house management platform that integrates IoT technology for real-time electricity monitoring. We provide integrated solutions for managing boarding houses with transparent, efficient, and reliable systems.',
                'about.owner.label': 'Owner',
                'about.owner.value': 'Rizky ilhami',
                'about.rooms.label': 'Available Rooms',
                'about.rooms.value': '4 Rooms',
                'about.address.label': 'Address',
                'about.address.value': 'Jl.Pahlawan gg 3. Sampang',
                'form.header': 'Sign in to your account',
                'demo.admin': 'Admin Demo',
                'demo.select': 'Select Room Account',
                'demo.select.desc': 'Choose a demo room account',
                'form.email.label': 'Email',
                'form.email.placeholder': 'Enter your email',
                'form.password.label': 'Password',
                'form.password.placeholder': 'Enter your password',
                'form.desc': 'Enter your email and password to sign in.',
                'form.submit': 'Sign In'
            }
        };

        function applyTranslations(lang) {
            const map = translations[lang] || {};
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (map[key]) el.textContent = map[key];
            });
            // placeholders
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (map[key]) el.setAttribute('placeholder', map[key]);
            });
            // update lang button and active state
            const btn = document.getElementById('langBtn');
            if (btn) btn.innerHTML = (lang === 'en' ? '🌍' : '🌏') + ' <span>' + (lang === 'en' ? 'EN' : 'ID') + '</span>';

            // update active state in menu
            document.querySelectorAll('.lang-option').forEach(opt => {
                if (opt.getAttribute('data-lang') === lang) {
                    opt.classList.add('active');
                } else {
                    opt.classList.remove('active');
                }
            });

            localStorage.setItem('lang', lang);
        }

        function setLanguage(lang) {
            applyTranslations(lang);
            const langMenu = document.getElementById('langMenu');
            if (langMenu) {
                langMenu.classList.remove('show');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize language
            const saved = localStorage.getItem('lang') || 'id';
            applyTranslations(saved);

            // Close menus when clicking outside
            document.addEventListener('click', (e) => {
                const langBtn = document.getElementById('langBtn');
                const langMenu = document.getElementById('langMenu');
                if (langBtn && langMenu) {
                    if (!langBtn.contains(e.target) && !langMenu.contains(e.target)) {
                        langMenu.classList.remove('show');
                    }
                }
            });
        });
    </script>
</body>

</html>
