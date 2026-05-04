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

        <div class="form-body">

            <!-- ── YOUR INFORMATION ── -->
            <div class="form-section-label">Your Information</div>

            <div class="form-group">
                <label class="form-label" for="fb-name">
                    Full Name <span style="color:var(--gray-400);font-weight:400;">(Optional)</span>
                </label>
                <input class="form-input" type="text" id="fb-name"
                       placeholder="Juan Dela Cruz" autocomplete="name">
            </div>

            <div class="form-group">
                <label class="form-label" for="fb-purok">Purok / Zone</label>
                <select class="form-select" id="fb-purok">
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
                <select class="form-select" id="fb-category">
                    <option value="" disabled selected>Select a category</option>
                    <option>Announcement / Information</option>
                    <option>Health &amp; Sanitation</option>
                    <option>Infrastructure &amp; Roads</option>
                    <option>Peace &amp; Order</option>
                    <option>Livelihood &amp; Programs</option>
                    <option>General Suggestion</option>
                    <option>Emergency / Urgent Concern</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="fb-subject">Subject / Title <span>*</span></label>
                <input class="form-input" type="text" id="fb-subject"
                       placeholder="e.g. Request for road repair on Calle X">
            </div>

            <div class="form-group">
                <label class="form-label" for="fb-message">Your Message <span>*</span></label>
                <textarea class="form-textarea" id="fb-message"
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
                    <button class="rating-btn" onclick="selectRating(this)" title="Very Dissatisfied">😞</button>
                    <button class="rating-btn" onclick="selectRating(this)" title="Dissatisfied">😕</button>
                    <button class="rating-btn" onclick="selectRating(this)" title="Neutral">😐</button>
                    <button class="rating-btn" onclick="selectRating(this)" title="Satisfied">🙂</button>
                    <button class="rating-btn" onclick="selectRating(this)" title="Very Satisfied">😄</button>
                </div>
            </div>

            <!-- Note -->
            <div class="form-note">
                <strong>Note:</strong> Your feedback will be reviewed by barangay officials.
                For urgent matters, please visit the Barangay Hall during office hours.
            </div>

            <!-- Submit -->
            <button class="btn-submit-card" onclick="submitFeedback()">
                Submit My Feedback
            </button>

        </div><!-- /form-body -->
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
