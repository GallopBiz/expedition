
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Portal – Expedition Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #dde3ec;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        /* ── Card wrapper ── */
        .card {
            display: flex;
            width: 100%;
            max-width: 860px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.18);
        }
        
            /* ── Main navigation link hover (remove background, keep text white) ── */
            .main-nav-link:hover,
            .main-nav-link:focus {
                background: none !important;
                color: #fff !important;
            }
        
            /* ── Submenu hover: background #01426a, text white ── */
            .main-nav-dropdown a:hover,
            .main-nav-dropdown a:focus {
                background: #01426a !important;
                color: #fff !important;
            }

        /* ── Left panel ── */
        .panel-left {
            flex: 0 0 320px;
            background-color: #1a3660;
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            color: #ffffff;
        }

        .logo-wrap {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        /* Mountain / chevron logo built purely in CSS */
        .logo-icon {
            width: 52px;
            height: 38px;
            position: relative;
            margin-right: 0;
        }

        .logo-icon svg {
            width: 100%;
            height: 100%;
        }

        .panel-left h1 {
            font-size: 1.35rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 0.35rem;
            color: #ffffff;
        }

        .panel-left .subtitle {
            font-size: 0.875rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.75);
            margin-bottom: 1.75rem;
        }

        .divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 1.75rem;
        }

        .feature-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .feature-list li::before {
            content: '';
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #5b9bd5;
            flex-shrink: 0;
        }

        /* ── Right panel ── */
        .panel-right {
            flex: 1;
            background-color: #ffffff;
            padding: 3rem 2.75rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .panel-right h2 {
            font-size: 1.6rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 2rem;
        }

        /* ── Form elements ── */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 0.4rem;
        }

        .input-wrap {
            position: relative;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid #d1d9e0;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #2d3748;
            background: #fff;
            outline: none;
            transition: border-color 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .form-group input:focus {
            border-color: #2d6fcf;
            box-shadow: 0 0 0 3px rgba(45, 111, 207, 0.12);
        }

        .form-group input::placeholder {
            color: #b0bac4;
        }

        /* Password toggle */
        .toggle-password {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #8a9ab0;
            display: flex;
            align-items: center;
            padding: 0;
            transition: color 0.15s;
        }

        .toggle-password:hover {
            color: #2d6fcf;
        }

        /* Error messages from Laravel */
        .error-msg {
            color: #e53e3e;
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }

        /* ── Remember me ── */
        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            margin-bottom: 1.5rem;
        }

        .remember-wrap input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #2d6fcf;
            border-radius: 4px;
            background: #fff;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            transition: background 0.15s;
        }

        .remember-wrap input[type="checkbox"]:checked {
            background: #2d6fcf;
            border-color: #2d6fcf;
        }

        .remember-wrap input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 3px;
            top: 1px;
            width: 9px;
            height: 6px;
            border-left: 2px solid #fff;
            border-bottom: 2px solid #fff;
            transform: rotate(-45deg);
        }

        .remember-wrap label {
            font-size: 0.875rem;
            color: #4a5568;
            cursor: pointer;
            user-select: none;
        }

        /* ── Sign In button ── */
        .btn-signin {
            width: 100%;
            padding: 0.85rem;
            background: #2d6fcf;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            letter-spacing: 0.02em;
            font-family: 'Inter', sans-serif;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-signin:hover {
            background: #2560b8;
        }

        .btn-signin:active {
            transform: scale(0.99);
        }

        /* ── Footer note ── */
        .hr-thin {
            border: none;
            border-top: 1px solid #e8ecf0;
            margin: 1.5rem 0 1rem;
        }

        .footer-note {
            font-size: 0.8rem;
            color: #8a9ab0;
            line-height: 1.7;
        }

        /* ── Session / validation alerts ── */
        .alert {
            padding: 0.7rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }

        .alert-error {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            color: #c53030;
        }

        .alert-success {
            background: #f0fff4;
            border: 1px solid #c6f6d5;
            color: #276749;
        }

        /* ── Responsive ── */
        @media (max-width: 640px) {
            .card {
                flex-direction: column;
                max-width: 420px;
            }

            .panel-left {
                flex: none;
                padding: 1.75rem 1.5rem;
            }

            .panel-right {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="card">

    {{-- ── Left branding panel ── --}}
    <div class="panel-left">

        {{-- Mountain logo SVG --}}
        <div class="logo-wrap">
            <div class="logo-icon">
                <img src="/images/1exyte-logo.png" alt="Expedition Logo" style="width: 140px; height: 50px; object-fit: contain;">
            </div>
        </div>

        <h1>Expedition Management System</h1>
        <p class="subtitle">Admin Portal</p>

        <hr class="divider">

        <ul class="feature-list">
            @if(isset($isSupplierLogin) && $isSupplierLogin)
                <li>Work Package <span class="ml-1 inline-block align-middle px-2 py-0.5 text-xs font-bold rounded-full bg-orange-500 text-white animate-pulse" style="vertical-align: middle;">New</span></li>
            @else
                <li>Supplier &amp; Delivery Tracking</li>
                <li>Reporting &amp; Analytics</li>
                <li>User Management</li>
            @endif
        </ul>

    </div>

    {{-- ── Right login panel ── --}}
    <div class="panel-right">

        <h2>Sign In to Admin Portal</h2>

        {{-- Session status (e.g. password reset link sent) --}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- Auth error (wrong credentials) --}}
        @if ($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email / Username --}}
            <div class="form-group">
                <label for="email">Username or Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your username or email"
                    required
                    autofocus
                    autocomplete="username"
                >
                @error('email')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >
                    <button
                        type="button"
                        class="toggle-password"
                        aria-label="Toggle password visibility"
                        onclick="togglePassword()"
                    >
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="remember-wrap">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                    checked
                >
                <label for="remember_me">Remember Me</label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-signin">Sign In</button>

        </form>



    </div>
</div>

<script>
    function togglePassword() {
        const input   = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const isHidden = input.type === 'password';

        input.type = isHidden ? 'text' : 'password';

        eyeIcon.innerHTML = isHidden
            ? `<!-- eye-off -->
               <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/>
               <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/>
               <line x1="1" y1="1" x2="23" y2="23"/>`
            : `<!-- eye -->
               <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
               <circle cx="12" cy="12" r="3"/>`;
    }
</script>

</body>
</html>
