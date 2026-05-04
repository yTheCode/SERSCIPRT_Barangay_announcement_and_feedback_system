<?php
/**
 * public/index.php
 * ────────────────────────────────────────────
 * Main entry point — the Home page.
 * This is the FIRST screen visitors see when they open the site.
 * No login, no registration.  Fully public.
 */

$pageTitle  = 'Home';
$activePage = 'home';

require_once __DIR__ . '/../includes/header.php';
?>

<!-- ══════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════ -->
<div class="hero-section">
    <div class="hero-inner">
        <h1 class="hero-title">Welcome to<br><em>Barangay Pasonanca</em></h1>
        <p class="hero-desc">
            A connected community delivering transparent governance and accessible
            public services — stay informed, stay engaged.
        </p>
        <div class="hero-actions">
            <button class="btn-hero btn-hero-gold"
                    onclick="document.getElementById('ann-section').scrollIntoView({behavior:'smooth'})">
                View Announcements
            </button>
            <a href="../feedback/feedback_index.php" class="btn-hero btn-hero-outline">
                Submit Feedback
            </a>
        </div>

        <!-- Facebook social link -->
        <div class="hero-social">
            <a  href="https://www.facebook.com/BarangayPasonancaOfficial"
                target="_blank" rel="noopener"
                class="fb-link"
                aria-label="Follow us on Facebook">
                <i class="fa-brands fa-facebook"></i>
                <span>Barangay Pasonanca Official</span>
            </a>
        </div>
    </div>
</div>

<!-- ── STATS ROW ── -->
<div class="stats-row">
    <div class="stat-card"><div class="stat-num">3</div><div class="stat-label">Upcoming</div></div>
    <div class="stat-card"><div class="stat-num">12</div><div class="stat-label">This Month</div></div>
    <div class="stat-card"><div class="stat-num">47</div><div class="stat-label">Feedback</div></div>
</div>

<!-- ══════════════════════════════════════════
     DASHBOARD / MAIN CONTENT
══════════════════════════════════════════ -->
<div class="dashboard-content">

    <!-- Quick Actions -->
    <div class="section-head" style="margin-top:28px;">
        <div class="section-title">Quick Actions</div>
    </div>
    <div class="quick-actions">
        <div class="qa-card"
             onclick="document.getElementById('ann-section').scrollIntoView({behavior:'smooth'})">
            <div class="qa-icon green">📢</div>
            <div>
                <div class="qa-title">Announcements</div>
                <div class="qa-desc">View latest barangay news and events</div>
            </div>
        </div>
        <a href="../feedback/feedback_index.php" class="qa-card" style="text-decoration:none;color:inherit;">
            <div class="qa-icon gold">💬</div>
            <div>
                <div class="qa-title">Submit Feedback</div>
                <div class="qa-desc">Share concerns, ideas, or suggestions</div>
            </div>
        </a>
    </div>

    <!-- Announcements -->
    <div class="section-head" id="ann-section">
        <div class="section-title">All Announcements</div>
        <span class="section-link">3 Upcoming · 0 Past</span>
    </div>

    <div class="ann-card">
        <div class="ann-dot upcoming"></div>
        <div style="flex:1;">
            <div class="ann-title">Community Clean-up Drive</div>
            <div class="ann-date">⏱ Posted March 2, 2026 · Event: March 6, 2026</div>
            <div class="ann-body">
                Join us this Saturday at 7:00 AM for our monthly barangay clean-up drive.
                Meeting point: Barangay Hall. Please bring gloves and garbage bags.
            </div>
        </div>
        <div class="ann-badge upcoming">Upcoming</div>
    </div>

    <div class="ann-card">
        <div class="ann-dot upcoming"></div>
        <div style="flex:1;">
            <div class="ann-title">Free Medical Mission</div>
            <div class="ann-date">⏱ Posted March 5, 2026 · Event: April 10, 2026</div>
            <div class="ann-body">
                DOH together with our health center will conduct free medical check-ups
                and medicine distribution for all residents.
            </div>
        </div>
        <div class="ann-badge upcoming">Upcoming</div>
    </div>

    <div class="ann-card">
        <div class="ann-dot upcoming"></div>
        <div style="flex:1;">
            <div class="ann-title">Barangay Assembly Meeting</div>
            <div class="ann-date">⏱ Posted March 10, 2026 · Event: April 15, 2026</div>
            <div class="ann-body">
                All registered residents are encouraged to attend the quarterly assembly.
                Agenda includes budget review and community projects update.
            </div>
        </div>
        <div class="ann-badge upcoming">Upcoming</div>
    </div>

</div><!-- /dashboard-content -->

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
