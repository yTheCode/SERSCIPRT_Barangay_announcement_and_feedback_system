<?php
/**
 * feedback/index.php
 * ────────────────────────────────────────────
 * Standalone Feedback submission page.
 * Extracted from the original monolithic HTML.
 * Fully public — no login required.
 */

$pageTitle  = 'Submit Feedback';
$activePage = 'feedback';

$feedbackMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $purok = isset($_POST['purok']) ? trim($_POST['purok']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;

    $conn = mysqli_connect('127.0.0.1', 'root', '', 'barangay_system');
    if ($conn) {
        mysqli_set_charset($conn, 'utf8mb4');
        if ($purok !== '' && $category !== '' && $subject !== '' && $message !== '') {
            $stmt = mysqli_prepare($conn, 'INSERT INTO feedback (ResidentName, Purok, Feedback_Category, Message_Subject, Message_content, Rating, Is_read, DateSubmitted) VALUES (?, ?, ?, ?, ?, ?, 0, CURDATE())');
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'sssssi', $name, $purok, $category, $subject, $message, $rating);
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    header('Location: feedback_index.php?submitted=1');
                    exit;
                }
                mysqli_stmt_close($stmt);
            }
        }
        mysqli_close($conn);
    }
    $feedbackMessage = 'Could not save feedback.';
}

if (isset($_GET['submitted'])) {
    $feedbackMessage = 'Feedback submitted successfully.';
}

require_once __DIR__ . '/../includes/header.php';
?>

<!-- ══════════════════════════════════════════
     FEEDBACK PAGE HERO BANNER
══════════════════════════════════════════ -->
<div class="form-page-hero">
    <h1>Submit Feedback</h1>
    <p>We value your feedback! Share your concerns, suggestions, or inquiries
       with barangay officials.</p>
</div>

<!-- ══════════════════════════════════════════
     FEEDBACK FORM CARD
══════════════════════════════════════════ -->
<div class="form-container">
    <div class="form-card">

        <!-- Card Header -->
        <div class="form-card-header">
            <div>
                <h2>Feedback Form</h2>
                <p>Your voice matters to us</p>
            </div>
        </div>
        <div class="form-gold-strip"></div>

        <form class="form-body" id="feedback-form" method="post" action="">

            <?php if ($feedbackMessage !== ''): ?>
                <div class="alert alert-success" style="margin-bottom:16px;">
                    <?= htmlspecialchars($feedbackMessage) ?>
                </div>
            <?php endif; ?>

            <!-- ── YOUR INFORMATION ── -->
            <div class="form-section-label">Your Information</div>

            <div class="form-group">
                <label class="form-label" for="fb-name">
                    Full Name <span style="color:var(--gray-400);font-weight:400;">(Optional)</span>
                </label>
                  <input class="form-input" type="text" id="fb-name" name="name"
                      placeholder="Juan Dela Cruz" autocomplete="name">
            </div>

            <div class="form-group">
                <label class="form-label" for="fb-purok">Purok / Zone</label>
                <select class="form-select" id="fb-purok" name="purok">
                    <option value="" disabled selected>Select your purok</option>
                    <option>Purok 1 – Sampaguita</option>
                    <option>Purok 2 – Narra</option>
                    <option>Purok 3 – Maharlika</option>
                    <option>Purok 4 – Bagong Pag-asa</option>
                    <option>Purok 5 – Mapayapa</option>
                    <option>Other / Not Sure</option>
                </select>
            </div>

            <!-- ── YOUR CONCERN ── -->
            <div class="form-section-label">Your Concern</div>

            <div class="form-group">
                <label class="form-label" for="fb-category">Category <span>*</span></label>
                <select class="form-select" id="fb-category" name="category">
                    <option value="" disabled selected>Select a category</option>
                    <option>Announcement / Information</option>
                    <option>Health &amp; Sanitation</option>
                    <option>Infrastructure &amp; Roads</option>
                    <option>Peace &amp; Order</option>
                    <option>Livelihood &amp; Programs</option>
                    <option>General Suggestion</option>
                    <option>Emergency / Urgent Concern</option>
                    <option>Others</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="fb-subject">Subject / Title <span>*</span></label>
                  <input class="form-input" type="text" id="fb-subject" name="subject"
                      placeholder="e.g. Request for road repair on Calle X">
            </div>

            <div class="form-group">
                <label class="form-label" for="fb-message">Your Message <span>*</span></label>
                <textarea class="form-textarea" id="fb-message" name="message"
                          placeholder="Please describe your concern or suggestion in detail..."
                          maxlength="500"
                          oninput="updateChar(this)"></textarea>
                <div class="char-count" id="char-count">0 / 500 characters</div>
            </div>

            <!-- ── SERVICE RATING ── -->
            <div class="form-section-label">Service Rating</div>

            <div class="form-group">
                <label class="form-label">How do you rate our barangay services?</label>
                <div class="rating-row">
                    <button type="button" class="rating-btn" onclick="selectRating(this)" title="Very Dissatisfied">😞</button>
                    <button type="button" class="rating-btn" onclick="selectRating(this)" title="Dissatisfied">😕</button>
                    <button type="button" class="rating-btn" onclick="selectRating(this)" title="Neutral">😐</button>
                    <button type="button" class="rating-btn" onclick="selectRating(this)" title="Satisfied">🙂</button>
                    <button type="button" class="rating-btn" onclick="selectRating(this)" title="Very Satisfied">😄</button>
                </div>
            </div>

            <!-- Note -->
            <div class="form-note">
                <strong>Note:</strong> Your feedback will be reviewed by barangay officials.
                For urgent matters, please visit the Barangay Hall during office hours.
            </div>

            <input type="hidden" id="fb-rating" name="rating" value="0">

            <!-- Submit -->
            <button type="button" class="btn-submit-card" onclick="submitFeedback()">
                Submit My Feedback
            </button>

        </form><!-- /form-body -->
    </div><!-- /form-card -->
</div><!-- /form-container -->

<!-- ── SUCCESS MODAL ── -->
<div class="success-overlay" id="success-overlay">
    <div class="success-box">
        <div class="success-icon">✨</div>
        <h3>Thank You!</h3>
        <p>Your feedback has been received and queued for review.
           We appreciate your contribution to Barangay Pasonanca.</p>
        <button class="btn-ok" onclick="closeSuccess()">Back to Home</button>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<script>
// Local fallbacks for functions referenced inline in the markup.
// These let the page work even if the shared `script.js` fails to load.
function updateChar(el) {
    try {
        var count = el.value.length;
        var counter = document.getElementById('char-count');
        if (!counter) return;
        counter.textContent = count + ' / 500 characters';
        if (count > 450) counter.classList.add('warn'); else counter.classList.remove('warn');
    } catch (e) { console.error(e); }
}

function selectRating(btn) {
    try {
        var buttons = document.querySelectorAll('.rating-btn');
        buttons.forEach(function(b){ b.classList.remove('selected'); });
        btn.classList.add('selected');
        var arr = Array.from(buttons);
        var idx = arr.indexOf(btn);
        var hidden = document.getElementById('fb-rating');
        if (hidden) hidden.value = idx >= 0 ? (idx + 1) : 0;
    } catch (e) { console.error(e); }
}

function submitFeedback() {
    try {
        var form = document.getElementById('feedback-form');
        if (!form) return;
        // basic client-side validation similar to server expectations
        var purok = document.getElementById('fb-purok')?.value;
        var subject = document.getElementById('fb-subject')?.value.trim();
        var msg = document.getElementById('fb-message')?.value.trim();
        var cat = document.getElementById('fb-category')?.value;
        if (!purok || !subject || !msg || !cat) {
            if (typeof showFormError === 'function') {
                showFormError('Please fill in all required fields marked with *');
            } else {
                alert('Please fill in all required fields marked with *');
            }
            return;
        }
        form.submit();
    } catch (e) { console.error(e); }
}
</script>
