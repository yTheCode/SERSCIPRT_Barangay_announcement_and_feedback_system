// ══════════════════════════════════════════
//  BARANGAY PASONANCA PORTAL — assets/js/script.js
//  Refactored for multi-page PHP architecture.
//  No more goTo() SPA navigation — pages are real URLs.
// ══════════════════════════════════════════

// ── Password Visibility Toggle ──
function togglePw(id, icon) {
    const input = document.getElementById(id);
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = '🙈';
    } else {
        input.type = 'password';
        icon.textContent = '👁';
    }
}

// ── Feedback: Character Counter ──
function updateChar(el) {
    const count   = el.value.length;
    const counter = document.getElementById('char-count');
    if (!counter) return;
    counter.textContent = `${count} / 500 characters`;
    count > 450 ? counter.classList.add('warn') : counter.classList.remove('warn');
}

// ── Feedback: Star/Emoji Rating ──
function selectRating(btn) {
    document.querySelectorAll('.rating-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
}

// ── Feedback: Submit ──
function submitFeedback() {
    const subject = document.getElementById('fb-subject')?.value;
    const msg     = document.getElementById('fb-message')?.value;
    const cat     = document.getElementById('fb-category')?.value;

    if (!subject || !msg || !cat) {
        alert('Please fill in all required fields marked with *');
        return;
    }

    const overlay = document.getElementById('success-overlay');
    if (overlay) overlay.classList.add('show');
}

// ── Success Modal: Close ──
function closeSuccess() {
    const overlay = document.getElementById('success-overlay');
    if (overlay) overlay.classList.remove('show');

    // Clear form fields
    ['fb-subject', 'fb-message'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    const counter = document.getElementById('char-count');
    if (counter) counter.textContent = '0 / 500 characters';

    // Return to home page
    window.location.href = '/public/index.php';
}

// ══════════════════════════════════════════
//  HAMBURGER / OFF-CANVAS SIDE MENU
// ══════════════════════════════════════════

function toggleMenu() {
    const sideMenu = document.getElementById('side-menu');
    const overlay  = document.getElementById('nav-overlay');
    if (!sideMenu) return;

    if (sideMenu.classList.contains('open')) {
        closeMenu();
    } else {
        sideMenu.classList.add('open');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeMenu() {
    document.querySelectorAll('.side-menu').forEach(m => m.classList.remove('open'));
    const overlay = document.getElementById('nav-overlay');
    if (overlay) overlay.classList.remove('active');
    document.body.style.overflow = '';
}

// Close on Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeMenu();
});

// Close if viewport returns to desktop width
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) closeMenu();
});
