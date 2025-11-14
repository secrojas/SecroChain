<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SecroChain – Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-main: #05070A;
            --bg-elevated: #151820;
            --bg-elevated-soft: #10131a;
            --primary-red: #E53935;
            --accent-orange: #FFB74D;
            --text-main: #F5F5F5;
            --text-muted: #9E9E9E;
            --border-subtle: rgba(255, 255, 255, 0.06);
            --success: #66BB6A;
            --warning: #FFA726;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg-main);
            color: var(--text-main);
        }

        .layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        @media (max-width: 880px) {
            .layout {
                grid-template-columns: 1fr;
            }
        }

        /* SIDEBAR */
        .sidebar {
            background: var(--bg-elevated-soft);
            border-right: 1px solid var(--border-subtle);
            padding: 20px 18px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
        }

        .sidebar-title {
            font-family: 'Orbitron', sans-serif;
            margin: 0;
            font-size: 1.1rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--primary-red);
        }

        .sidebar-subtitle {
            margin: 2px 0 0;
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .nav {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.9rem;
            cursor: pointer;
            border: 1px solid transparent;
            transition: background 0.14s ease, color 0.14s ease, border 0.14s ease;
        }

        .nav-link span.icon {
            font-size: 1.1rem;
        }

        .nav-link:hover {
            background: #1f222b;
            color: var(--text-main);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-red), #ff7043);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-footer {
            margin-top: auto;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .sidebar-footer a {
            color: var(--accent-orange);
            text-decoration: none;
        }

        .sidebar-footer a:hover {
            text-decoration: underline;
        }

        /* MAIN AREA */
        .main {
            padding: 18px 20px 26px;
            display: flex;
            flex-direction: column;
            gap: 18px;
            background: radial-gradient(circle at top, #111521 0, #05070A 55%);
        }

        .topbar {
            display: flex;
            align-items: center;
            gap: 14px;
            justify-content: space-between;
        }

        .topbar-left h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .topbar-left p {
            margin: 4px 0 0;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-search {
            position: relative;
        }

        .topbar-search input {
            background: var(--bg-elevated-soft);
            border-radius: 999px;
            border: 1px solid var(--border-subtle);
            padding: 7px 10px;
            padding-left: 28px;
            color: var(--text-main);
            font-size: 0.85rem;
            outline: none;
        }

        .topbar-search span {
            position: absolute;
            left: 9px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid var(--border-subtle);
            font-size: 0.85rem;
        }

        .user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-red), var(--accent-orange));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        /* CARDS */
        .cards-grid {
            display: grid;
            gap: 14px;
        }

        @media (min-width: 880px) {
            .cards-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        .card {
            background: var(--bg-elevated);
            border-radius: 16px;
            border: 1px solid var(--border-subtle);
            padding: 14px 14px 12px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5);
        }

        .card-label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .card-value {
            margin-top: 6px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .card-pill {
            margin-top: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-muted);
        }

        .card-pill.positive {
            color: var(--success);
        }

        .card-pill.negative {
            color: var(--warning);
        }

        /* CONTENT GRID */
        .content-grid {
            display: grid;
            gap: 16px;
        }

        @media (min-width: 1024px) {
            .content-grid {
                grid-template-columns: 2fr 1.3fr;
            }
        }

        .panel {
            background: var(--bg-elevated);
            border-radius: 16px;
            border: 1px solid var(--border-subtle);
            padding: 14px 14px 10px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.55);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .panel-header h2 {
            margin: 0;
            font-size: 1rem;
        }

        .panel-header small {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .panel-actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            border-radius: 999px;
            border: 1px solid var(--border-subtle);
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-main);
            font-size: 0.78rem;
            padding: 5px 9px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
        }

        .btn-primary {
            border-color: transparent;
            background: linear-gradient(135deg, var(--primary-red), #ff7043);
        }

        .btn span.icon {
            font-size: 0.9rem;
        }

        /* TRANSACTION TABLE (simple list) */
        .tx-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .tx-item {
            display: grid;
            grid-template-columns: minmax(0, 1.6fr) 0.9fr 0.8fr 0.7fr;
            gap: 8px;
            font-size: 0.83rem;
            padding: 8px 4px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .tx-item.header {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
        }

        .tx-type {
            font-weight: 500;
        }

        .tx-amount-pos {
            color: var(--success);
        }

        .tx-amount-neg {
            color: var(--warning);
        }

        .tx-account {
            color: var(--text-muted);
        }

        .tx-hash {
            font-family: "SFMono-Regular", ui-monospace, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.78rem;
            color: var(--text-muted);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* RIGHT PANEL CONTENT */
        .chain-status {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .status-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .status-label {
            color: var(--text-muted);
        }

        .status-value {
            color: var(--text-main);
        }

        .block-list {
            margin-top: 10px;
            padding: 0;
            list-style: none;
            max-height: 220px;
            overflow-y: auto;
        }

        .block-item {
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            font-size: 0.8rem;
        }

        .block-item strong {
            color: var(--accent-orange);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 7px;
            border-radius: 999px;
            font-size: 0.7rem;
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .badge.green {
            color: var(--success);
        }
    </style>
</head>
<body>
<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <!-- Same logo as landing/auth -->
            <svg class="sidebar-logo" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
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
            <div>
                <h2 class="sidebar-title">SecroChain</h2>
                <p class="sidebar-subtitle">Red wallet dashboard</p>
            </div>
        </div>

        <nav class="nav">
            <a class="nav-link active">
                <span class="icon">📊</span>
                <span>Overview</span>
            </a>
            <a class="nav-link">
                <span class="icon">👤</span>
                <span>Clients</span>
            </a>
            <a class="nav-link">
                <span class="icon">💳</span>
                <span>Accounts</span>
            </a>
            <a class="nav-link">
                <span class="icon">🔁</span>
                <span>Transactions</span>
            </a>
            <a class="nav-link">
                <span class="icon">⛓️</span>
                <span>Chain</span>
            </a>
            <a class="nav-link">
                <span class="icon">⚙️</span>
                <span>Settings</span>
            </a>
            <a class="nav-link">
                <span class="icon">↩</span>
                <span>Logout</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            Built by <strong>secrojas</strong> ·
            <a href="https://srojasweb.dev" target="_blank" rel="noopener noreferrer">srojasweb.dev</a>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <h1>Overview</h1>
                <p>Monitor balances, latest transactions and chain status at a glance.</p>
            </div>

            <div class="topbar-right">
                <div class="topbar-search">
                    <span>🔍</span>
                    <input type="text" placeholder="Search client, account or transaction…" />
                </div>
                <div class="user-pill">
                    <div class="user-avatar">SR</div>
                    <span>secrojas</span>
                </div>
            </div>
        </div>

        <!-- Cards row -->
        <section class="cards-grid">
            <article class="card">
                <div class="card-label">Total balance</div>
                <div class="card-value" id="total-balance">$ 24,350.00</div>
                <div class="card-pill positive">
                    <span>▲</span> +4.2% vs last week
                </div>
            </article>

            <article class="card">
                <div class="card-label">Active clients</div>
                <div class="card-value" id="active-clients">18</div>
                <div class="card-pill">
                    <span>👤</span> +2 new signups
                </div>
            </article>

            <article class="card">
                <div class="card-label">Open accounts</div>
                <div class="card-value" id="open-accounts">27</div>
                <div class="card-pill">
                    <span>💳</span> 1 account pending
                </div>
            </article>

            <article class="card">
                <div class="card-label">Chain height</div>
                <div class="card-value" id="chain-height">64 blocks</div>
                <div class="card-pill">
                    <span>⛓️</span> Last block ~2 min ago
                </div>
            </article>
        </section>

        <!-- Content grid -->
        <section class="content-grid">
            <!-- Transactions panel -->
            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Recent transactions</h2>
                        <small>Last 10 movements across all accounts</small>
                    </div>
                    <div class="panel-actions">
                        <button class="btn">
                            <span class="icon">⏱</span>
                            Today
                        </button>
                        <button class="btn btn-primary">
                            <span class="icon">＋</span>
                            New movement
                        </button>
                    </div>
                </div>

                <ul class="tx-list" id="transaction-list">
                    <li class="tx-item header">
                        <span>Type / Description</span>
                        <span>Amount</span>
                        <span>Account</span>
                        <span>Date</span>
                    </li>

                    <!-- Sample items (replace with JS-generated content later) -->
                    <li class="tx-item">
                        <span class="tx-type">Deposit · Salary</span>
                        <span class="tx-amount-pos">+ $ 1,200.00</span>
                        <span class="tx-account">ACC-001</span>
                        <span>2025-11-14</span>
                    </li>
                    <li class="tx-item">
                        <span class="tx-type">Withdrawal · ATM</span>
                        <span class="tx-amount-neg">- $ 120.00</span>
                        <span class="tx-account">ACC-001</span>
                        <span>2025-11-13</span>
                    </li>
                    <li class="tx-item">
                        <span class="tx-type">Deposit · Transfer from ACC-003</span>
                        <span class="tx-amount-pos">+ $ 250.00</span>
                        <span class="tx-account">ACC-002</span>
                        <span>2025-11-13</span>
                    </li>
                    <li class="tx-item">
                        <span class="tx-type">Withdrawal · Online payment</span>
                        <span class="tx-amount-neg">- $ 49.99</span>
                        <span class="tx-account">ACC-002</span>
                        <span>2025-11-12</span>
                    </li>
                </ul>
            </section>

            <!-- Chain / account status panel -->
            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Chain & account status</h2>
                        <small>Latest block and integrity checks</small>
                    </div>
                    <div class="panel-actions">
                        <span class="badge green">OK · Verified</span>
                    </div>
                </div>

                <div class="chain-status">
                    <div class="status-row">
                        <span class="status-label">Current height</span>
                        <span class="status-value" id="status-chain-height">64 blocks</span>
                    </div>
                    <div class="status-row">
                        <span class="status-label">Last hash</span>
                        <span class="status-value tx-hash" id="status-last-hash">
                            0x8f2b…a93c
                        </span>
                    </div>
                    <div class="status-row">
                        <span class="status-label">Last verification</span>
                        <span class="status-value" id="status-last-verify">
                            2 minutes ago
                        </span>
                    </div>
                    <div class="status-row">
                        <span class="status-label">Integrity</span>
                        <span class="status-value" id="status-integrity">No broken links detected</span>
                    </div>
                </div>

                <ul class="block-list" id="block-list">
                    <li class="block-item">
                        <strong>#64</strong> · Deposit $1200 ·
                        <span class="tx-hash">0x8f2b0de47ac91f3a9b2c…</span>
                    </li>
                    <li class="block-item">
                        <strong>#63</strong> · Withdrawal $120 ·
                        <span class="tx-hash">0x7a1c99eaae201cdab031…</span>
                    </li>
                    <li class="block-item">
                        <strong>#62</strong> · Transfer $250 ·
                        <span class="tx-hash">0x6b54af3bca0284d91e77…</span>
                    </li>
                </ul>
            </section>
        </section>
    </main>
</div>

<script>
    // Here you can later inject real data from your JS/API.
    // Example placeholders for future hooks:

    // document.getElementById('total-balance').textContent = '$ ' + totalBalance.toFixed(2);
    // document.getElementById('transaction-list').appendChild(...);
    // document.getElementById('block-list').appendChild(...);

    // Optional: make sidebar collapsible on small screens later if needed.
</script>
</body>
</html>
