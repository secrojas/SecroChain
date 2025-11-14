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
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top, #10131a 0, var(--bg-main) 55%);
            color: var(--text-main);
        }

        header {
            padding: 40px 20px 10px;
            text-align: center;
        }

        .logo {
            width: 120px;
            margin: 0 auto 20px auto;
            display: block;
            animation: floatLogo 4s ease-in-out infinite;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.8rem;
            margin: 0;
            color: var(--primary-red);
            letter-spacing: 0.14em;
            text-transform: uppercase;
            font-weight: 900;
        }

        h2 {
            font-size: 1.2rem;
            margin-top: 12px;
            color: var(--accent-orange);
            font-weight: 400;
            opacity: 0;
            animation: fadeUp 0.8s ease-out forwards;
            animation-delay: 0.15s;
        }

        .cta-container {
            margin-top: 26px;
            display: flex;
            justify-content: center;
            gap: 12px;
            opacity: 0;
            animation: fadeUp 0.8s ease-out forwards;
            animation-delay: 0.3s;
        }

        .cta-button {
            padding: 10px 22px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            background: linear-gradient(135deg, var(--primary-red), #ff7043);
            color: #ffffff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
            transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            filter: brightness(1.05);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.6);
        }

        .cta-button span {
            font-size: 1.1rem;
        }

        section {
            padding: 30px 20px 10px;
            max-width: 960px;
            margin: auto;
        }

        .subtitle {
            text-align: center;
            max-width: 640px;
            margin: 0 auto 30px;
            color: var(--text-muted);
            font-size: 0.98rem;
            opacity: 0;
            animation: fadeUp 0.8s ease-out forwards;
            animation-delay: 0.45s;
        }

        .feature-grid {
            display: grid;
            gap: 20px;
            margin-top: 10px;
        }

        @media (min-width: 768px) {
            .feature-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .feature-box {
            background: var(--bg-card);
            padding: 22px 20px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.04);
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.45);
            opacity: 0;
            transform: translateY(10px);
            animation: fadeUp 0.7s ease-out forwards;
        }

        .feature-box:nth-child(1) { animation-delay: 0.25s; }
        .feature-box:nth-child(2) { animation-delay: 0.35s; }
        .feature-box:nth-child(3) { animation-delay: 0.45s; }
        .feature-box:nth-child(4) { animation-delay: 0.55s; }

        .feature-box h3 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 1.1rem;
            color: var(--accent-orange);
        }

        .feature-box p {
            margin: 0;
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        footer {
            text-align: center;
            padding: 35px 10px 40px;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        footer a {
            color: var(--accent-orange);
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Animations */
        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(14px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <header>
        <!-- LOGO SVG: stylized "S" + blockchain hexagon -->
        <svg class="logo" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-labelledby="secrochainLogoTitle">
            <title id="secrochainLogoTitle">SecroChain Logo</title>
            <!-- Outer hexagon (blockchain / block) -->
            <polygon
                points="100,12 178,56 178,144 100,188 22,144 22,56"
                fill="none"
                stroke="#E53935"
                stroke-width="8"
                stroke-linejoin="round"
            />
            <!-- Stylized S made of two chain-like segments -->
            <path
                d="M125 55H90C77 55 70 62 70 73C70 84 77 91 90 91H110C123 91 130 98 130 109C130 120 123 127 110 127H75"
                fill="none"
                stroke="#FFB74D"
                stroke-width="9"
                stroke-linecap="round"
            />
            <!-- Small chain-link circles to reinforce blockchain idea -->
            <circle cx="72" cy="74" r="5" fill="#E53935" />
            <circle cx="128" cy="109" r="5" fill="#E53935" />
        </svg>

        <h1>SecroChain</h1>
        <h2>Red wallet. Immutable chain.</h2>

        <div class="cta-container">
            <a class="cta-button" href="{{ route('auth') }}" title="Open SecroChain app">
                <span>↗</span>
                Open SecroChain app
            </a>
        </div>
    </header>

    <section>
        <p class="subtitle">
            SecroChain is a learning-focused fintech project that combines a classic digital wallet with an
            optional blockchain-inspired ledger, ensuring every transaction is traceable, verifiable, and tamper-evident.
        </p>

        <div class="feature-grid">
            <div class="feature-box">
                <h3>Client management</h3>
                <p>Create, update and manage secure client profiles with email and password authentication.</p>
            </div>

            <div class="feature-box">
                <h3>Accounts & balances</h3>
                <p>Open accounts, track balances and keep a clear record of deposits and withdrawals in real time.</p>
            </div>

            <div class="feature-box">
                <h3>On-chain style ledger</h3>
                <p>Each transaction can be stored as a block linked by hashes, emulating a blockchain structure for integrity.</p>
            </div>

            <div class="feature-box">
                <h3>Clean web interface</h3>
                <p>Minimal UI built with HTML, CSS and JavaScript, focused on clarity, readability and usability.</p>
            </div>
        </div>
    </section>

    <footer>
        © 2025 SecroChain — Fintech project • Built by <strong>secrojas</strong> ·
        <a href="https://srojasweb.dev" target="_blank" rel="noopener noreferrer">srojasweb.dev</a>
    </footer>
</body>
</html>
