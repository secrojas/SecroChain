<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SecroChain | Red wallet. Immutable chain</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-main: #05070A;
            --bg-card: #151820;
            --primary-red: #E53935;
            --accent-orange: #FFB74D;
            --text-main: #F5F5F5;
            --text-muted: #9E9E9E;
            --border-subtle: rgba(255, 255, 255, 0.06);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top, #10131a 0, var(--bg-main) 55%);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 960px;
            display: grid;
            gap: 40px;
        }

        @media (min-width: 880px) {
            .auth-wrapper {
                grid-template-columns: 1.1fr 1fr;
                align-items: center;
            }
        }

        /* Left side: brand / description */
        .brand-panel {
            text-align: left;
        }

        .brand-logo {
            width: 70px;
            margin-bottom: 16px;
            animation: floatLogo 4s ease-in-out infinite;
        }

        .brand-title {
            font-family: 'Orbitron', sans-serif;
            margin: 0;
            font-size: 2.1rem;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: var(--primary-red);
        }

        .brand-subtitle {
            margin-top: 8px;
            font-size: 1rem;
            color: var(--accent-orange);
        }

        .brand-text {
            margin-top: 18px;
            color: var(--text-muted);
            font-size: 0.95rem;
            max-width: 420px;
            line-height: 1.6;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 24px;
            font-size: 0.9rem;
            color: var(--accent-orange);
            text-decoration: none;
        }

        .back-link span {
            font-size: 1.1rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* Right side: auth card */
        .auth-card {
            background: var(--bg-card);
            border-radius: 18px;
            border: 1px solid var(--border-subtle);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.6);
            padding: 22px 22px 26px;
            max-width: 420px;
            margin: 0 auto;
            animation: fadeUp 0.7s ease-out forwards;
        }

        .auth-tabs {
            display: flex;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-subtle);
            padding: 3px;
            margin-bottom: 20px;
        }

        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 8px 0;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-radius: 999px;
            cursor: pointer;
            border: none;
            background: transparent;
            color: var(--text-muted);
            transition: background 0.16s ease, color 0.16s ease;
        }

        .auth-tab.active {
            background: linear-gradient(135deg, var(--primary-red), #ff7043);
            color: #ffffff;
        }

        .auth-title {
            margin: 4px 0 8px;
            font-size: 1.25rem;
        }

        .auth-description {
            margin: 0 0 18px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        form {
            display: none;
        }

        form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 14px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.86rem;
            color: var(--text-main);
        }

        input {
            width: 100%;
            padding: 9px 11px;
            border-radius: 10px;
            border: 1px solid var(--border-subtle);
            background: #0d0f16;
            color: var(--text-main);
            font-size: 0.9rem;
            outline: none;
            transition: border 0.16s ease, box-shadow 0.16s ease;
        }

        input:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 0 1px rgba(229, 57, 53, 0.3);
        }

        .inline-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .inline-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .inline-group input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .link-muted {
            font-size: 0.82rem;
            color: var(--accent-orange);
            text-decoration: none;
        }

        .link-muted:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            margin-top: 4px;
            padding: 10px 16px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            background: linear-gradient(135deg, var(--primary-red), #ff7043);
            color: #ffffff;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
            transition: transform 0.16s ease, box-shadow 0.16s ease, filter 0.16s ease;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.8);
        }

        .helper-text {
            margin-top: 10px;
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        /* Animations */
        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(14px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="brand-panel">
        <!-- Same logo style as landing, smaller -->
        <svg class="brand-logo" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-labelledby="secrochainLogoTitle">
            <title id="secrochainLogoTitle">SecroChain Logo</title>
            <polygon
                points="100,12 178,56 178,144 100,188 22,144 22,56"
                fill="none"
                stroke="#E53935"
                stroke-width="8"
                stroke-linejoin="round"
            />
            <path
                d="M125 55H90C77 55 70 62 70 73C70 84 77 91 90 91H110C123 91 130 98 130 109C130 120 123 127 110 127H75"
                fill="none"
                stroke="#FFB74D"
                stroke-width="9"
                stroke-linecap="round"
            />
            <circle cx="72" cy="74" r="5" fill="#E53935" />
            <circle cx="128" cy="109" r="5" fill="#E53935" />
        </svg>

        <h1 class="brand-title">SecroChain</h1>
        <p class="brand-subtitle">Red wallet. Immutable chain.</p>
        <p class="brand-text">
            Log in to manage your clients, accounts and transactions, or create a new account to start tracking
            your own blockchain-inspired ledger for every movement.
        </p>

        <!-- Back to landing -->
        <a href="{{ route('landing') }}" class="back-link">
            <span>←</span> Back to landing
        </a>
    </div>

    <div class="auth-card">
        <div class="auth-tabs">
            <button class="auth-tab active" data-target="login-form">Login</button>
            <button class="auth-tab" data-target="register-form">Register</button>
        </div>

        <!-- LOGIN FORM -->
        <form id="login-form" class="active">
            <h2 class="auth-title">Welcome back</h2>
            <p class="auth-description">Access your SecroChain dashboard with your email and password.</p>

            <div class="form-group">
                <label for="login-email">Email</label>
                <input id="login-email" name="email" type="email" placeholder="you@example.com" required />
            </div>

            <div class="form-group">
                <label for="login-password">Password</label>
                <input id="login-password" name="password" type="password" placeholder="••••••••" required />
            </div>

            <div class="inline-group">
                <label>
                    <input type="checkbox" name="remember" />
                    Remember me
                </label>
                <a href="#" class="link-muted">Forgot password?</a>
            </div>

            <button class="submit-btn" type="submit">Log in</button>

            <p class="helper-text">
                New to SecroChain? Switch to <strong>Register</strong> above to create your account.
            </p>
        </form>

        <!-- REGISTER FORM -->
        <form id="register-form">
            <h2 class="auth-title">Create your account</h2>
            <p class="auth-description">
                Register as a new client to start creating accounts, performing deposits and withdrawals, and
                storing on-chain style records.
            </p>

            <div class="form-group">
                <label for="register-first-name">First name</label>
                <input id="register-first-name" name="firstName" type="text" placeholder="Sebastian" required />
            </div>

            <div class="form-group">
                <label for="register-last-name">Last name</label>
                <input id="register-last-name" name="lastName" type="text" placeholder="Rojas" required />
            </div>

            <div class="form-group">
                <label for="register-dni">ID / DNI</label>
                <input id="register-dni" name="dni" type="text" placeholder="e.g. 12345678" required />
            </div>

            <div class="form-group">
                <label for="register-email">Email</label>
                <input id="register-email" name="email" type="email" placeholder="you@example.com" required />
            </div>

            <div class="form-group">
                <label for="register-password">Password</label>
                <input id="register-password" name="password" type="password" placeholder="••••••••" required />
            </div>

            <div class="form-group">
                <label for="register-password-confirm">Confirm password</label>
                <input id="register-password-confirm" name="passwordConfirm" type="password" placeholder="••••••••" required />
            </div>

            <button class="submit-btn" type="submit">Register</button>

            <p class="helper-text">
                Already registered? Switch to <strong>Login</strong> above and access your dashboard.
            </p>
        </form>
    </div>
</div>

<script>
    // Simple tab switcher for Login / Register
    const tabs = document.querySelectorAll('.auth-tab');
    const forms = {
        'login-form': document.getElementById('login-form'),
        'register-form': document.getElementById('register-form'),
    };

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Activate tab
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            // Show corresponding form
            Object.values(forms).forEach(f => f.classList.remove('active'));
            const targetId = tab.getAttribute('data-target');
            forms[targetId].classList.add('active');
        });
    });

    // Temporary redirect to dashboard (will be replaced with real auth logic)
    document.getElementById('login-form').addEventListener('submit', (e) => {
        e.preventDefault();
        window.location.href = "{{ route('dashboard') }}";
    });

    document.getElementById('register-form').addEventListener('submit', (e) => {
        e.preventDefault();
        window.location.href = "{{ route('dashboard') }}";
    });
</script>
</body>
</html>
