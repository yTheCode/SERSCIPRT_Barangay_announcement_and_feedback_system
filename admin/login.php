<?php
/**
 * admin/login.php
 * ────────────────────────────────────────────
 * ADMIN-ONLY login interface.
 *
 * Security through obscurity:
 *   • No link to this page exists anywhere in the public site.
 *   • Access only by typing the URL directly:  /admin/login.php
 *   • Branding deliberately identifies it as an admin panel.
 *
 * This file is intentionally self-contained (no shared header/footer)
 * so it remains completely isolated from public pages.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login · Barangay Pasonanca</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Shared stylesheet (admin uses the same design tokens) -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        /* ── Admin-specific overrides ── */
        body {
            background: var(--green-900);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px 16px;
        }

        /* Subtle noise-pattern overlay for depth */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        .admin-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg), 0 0 0 1px rgba(245, 203, 92, .15);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            animation: cardRise .45s ease both;
        }

        .admin-header {
            background: var(--green-900);
            padding: 28px 32px 22px;
            text-align: center;
            border-bottom: 3px solid var(--gold);
        }

        .admin-badge {
            display: inline-block;
            background: rgba(245, 203, 92, .15);
            border: 1px solid rgba(245, 203, 92, .4);
            color: var(--gold);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 12px;
        }

        .admin-title {
            font-family: var(--font-head);
            font-size: 20px;
            color: var(--white);
            line-height: 1.2;
        }

        .admin-sub {
            font-size: 11.5px;
            color: rgba(255, 255, 255, .5);
            margin-top: 4px;
            letter-spacing: .04em;
        }

        .admin-body {
            padding: 28px 32px 32px;
        }

        /* Lock icon centered above form */
        .lock-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            background: var(--green-100);
            border-radius: 50%;
            font-size: 22px;
            margin: 0 auto 24px;
        }

        .admin-divider {
            border: none;
            border-top: 1px solid var(--gray-200);
            margin: 24px 0 20px;
        }

        .admin-back-link {
            display: block;
            text-align: center;
            font-size: 12.5px;
            color: var(--gray-600);
            margin-top: 18px;
        }

        .admin-back-link a {
            color: var(--green-700);
            font-weight: 600;
            text-decoration: none;
        }

        .admin-back-link a:hover { text-decoration: underline; }

        @media (max-width: 440px) {
            .admin-body   { padding: 22px 20px 26px; }
            .admin-header { padding: 22px 20px 18px; }
        }
    </style>
</head>
<body>

<div class="admin-card">

    <!-- Header -->
    <div class="admin-header">
        <div class="admin-badge">🔒 Restricted Access</div>
        <div class="admin-title">Barangay Pasonanca</div>
        <div class="admin-sub">Administrator Panel</div>
    </div>

    <!-- Body -->
    <div class="admin-body">

        <div class="lock-icon" aria-hidden="true">🔑</div>

        <div class="form-group">
            <label class="form-label" for="admin-user">Admin Username <span>*</span></label>
            <div class="input-row">
                <input  class="form-input has-icon"
                        type="text"
                        id="admin-user"
                        placeholder="admin@pasonanca.gov.ph"
                        autocomplete="username">
                <span class="input-icon" aria-hidden="true">👤</span>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="admin-pass">Password <span>*</span></label>
            <div class="input-row">
                <input  class="form-input has-icon"
                        type="password"
                        id="admin-pass"
                        placeholder="Enter your password"
                        autocomplete="current-password">
                <span   class="input-icon"
                        onclick="togglePw('admin-pass', this)"
                        title="Show / hide password"
                        role="button"
                        tabindex="0"
                        aria-label="Toggle password visibility">👁</span>
            </div>
        </div>

        <!-- TODO: wire up to your backend auth endpoint -->
        <button class="btn-primary" onclick="handleAdminLogin()">
            Sign In to Admin Panel
        </button>

        <hr class="admin-divider">

        <div class="admin-back-link">
            Not an admin? <a href="/public/index.php">Return to Home</a>
        </div>

    </div><!-- /admin-body -->
</div><!-- /admin-card -->

<script src="/assets/js/script.js"></script>
<script>
    /**
     * handleAdminLogin()
     * Placeholder — replace with a real fetch() POST to your auth endpoint.
     */
    function handleAdminLogin() {
        const user = document.getElementById('admin-user').value.trim();
        const pass = document.getElementById('admin-pass').value;

        if (!user || !pass) {
            alert('Please enter your username and password.');
            return;
        }

        // Example: POST to /admin/auth.php
        // fetch('/admin/auth.php', { method: 'POST', ... })
        alert('Admin login submitted. Connect to your backend to complete authentication.');
    }
</script>
</body>
</html>
