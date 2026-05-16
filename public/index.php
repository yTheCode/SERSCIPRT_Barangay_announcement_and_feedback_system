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
require_once __DIR__ . '/../config/db.php';

// Fetch announcements from the database
$announcements = [];
$sql = "SELECT Title, Description, `Date Posted` FROM announcements ORDER BY `Date Posted` DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
}

// Live homepage stats
$upcoming_count = 0;
$this_month_count = 0;
$feedback_count = 0;

$result = $conn->query("SELECT COUNT(*) AS total FROM announcements WHERE `Date Posted` >= CURDATE()");
if ($result && ($row = $result->fetch_assoc())) {
    $upcoming_count = (int) $row['total'];
}

$result = $conn->query("SELECT COUNT(*) AS total FROM announcements WHERE YEAR(`Date Posted`) = YEAR(CURDATE()) AND MONTH(`Date Posted`) = MONTH(CURDATE())");
if ($result && ($row = $result->fetch_assoc())) {
    $this_month_count = (int) $row['total'];
}

$result = $conn->query("SELECT COUNT(*) AS total FROM feedback");
if ($result && ($row = $result->fetch_assoc())) {
    $feedback_count = (int) $row['total'];
}
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
    <div class="stat-card"><div class="stat-num"><?= (int) $upcoming_count ?></div><div class="stat-label">Upcoming</div></div>
    <div class="stat-card"><div class="stat-num"><?= (int) $this_month_count ?></div><div class="stat-label">This Month</div></div>
    <div class="stat-card"><div class="stat-num"><?= (int) $feedback_count ?></div><div class="stat-label">Feedback</div></div>
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
        <span class="section-link"><?php echo count($announcements); ?> Announcement(s)</span>
    </div>

    <?php if (count($announcements) === 0): ?>
        <div class="ann-card">
            <div style="flex:1;">
                <div class="ann-title">No announcements yet.</div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($announcements as $ann): ?>
            <div class="ann-card">
                <div class="ann-dot upcoming"></div>
                <div style="flex:1;">
                    <div class="ann-title"><?php echo htmlspecialchars($ann['Title']); ?></div>
                    <div class="ann-date">⏱ Posted <?php echo date('F j, Y', strtotime($ann['Date Posted'])); ?></div>
                    <div class="ann-body"><?php echo nl2br(htmlspecialchars($ann['Description'])); ?></div>
                </div>
                <div class="ann-badge upcoming">Upcoming</div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div><!-- /dashboard-content -->

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
