<?php
/**
 * includes/header.php
 * Shared site header — included on every public & feedback page.
 *
 * Expects the calling page to define (before the include):
 *   $pageTitle   – <title> suffix,  e.g. "Home" or "Submit Feedback"
 *   $activePage  – highlights the correct nav link: 'home' | 'feedback'
 */
$pageTitle  = $pageTitle  ?? 'Barangay Pasonanca Portal';
$activePage = $activePage ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> · Barangay Pasonanca Portal</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Shared stylesheet -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- ── MOBILE NAV OVERLAY ── -->
<div class="nav-overlay" id="nav-overlay" onclick="closeMenu()"></div>

<!-- ══════════════════════════════════════
     STICKY SITE HEADER
══════════════════════════════════════ -->
<header class="site-header">
    <div class="header-inner">

        <!-- Brand -->
        <a href="/public/index.php" class="header-brand" aria-label="Go to homepage">
            <div>
                <div class="brand-name">Barangay Pasonanca Portal</div>
                <div class="brand-sub">Pasonanca, Zamboanga City</div>
            </div>
        </a>

        <!-- Desktop Navigation  (Admin link intentionally omitted) -->
        <nav class="header-nav" aria-label="Main navigation">
            <a href="../public/index.php"
               class="nav-btn <?= $activePage === 'home'     ? 'active' : '' ?>">Home</a>
            <a href="../feedback/feedback_index.php"
               class="nav-btn <?= $activePage === 'feedback' ? 'active' : '' ?>">Feedback</a>
            <a href="../public/contact.php"
               class="nav-btn">Contact Officials</a>
        </nav>

        <!-- Right: Hamburger -->
        <div class="header-right">
            <button class="hamburger-btn" onclick="toggleMenu()" aria-label="Open menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

<!-- ── MOBILE OFF-CANVAS SIDE MENU ── -->
<aside class="side-menu" id="side-menu" aria-label="Mobile navigation">
    <div class="side-menu-header">
        <span class="side-menu-title">Barangay Pasonanca</span>
        <button class="side-menu-close" onclick="closeMenu()" aria-label="Close menu">&times;</button>
    </div>
    <nav class="side-menu-nav">
        <a href="/public/index.php"
           class="side-nav-btn <?= $activePage === 'home'     ? 'active' : '' ?>">Home</a>
        <a href="/feedback/index.php"
           class="side-nav-btn <?= $activePage === 'feedback' ? 'active' : '' ?>">Feedback</a>
        <a href="/public/contact.php"
           class="side-nav-btn">Contact Officials</a>
        <!-- No Admin link here — access via direct URL only -->
    </nav>
</aside>
