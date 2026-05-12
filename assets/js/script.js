// ══════════════════════════════════════════
//  BARANGAY PASONANCA PORTAL — assets/js/script.js
//  Shared front-end interactivity for all pages.
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
    const subject = document.getElementById('fb-subject')?.value.trim();
    const msg     = document.getElementById('fb-message')?.value.trim();
    const cat     = document.getElementById('fb-category')?.value;

    if (!subject || !msg || !cat) {
        showFormError('Please fill in all required fields marked with *');
        return;
    }

    const overlay = document.getElementById('success-overlay');
    if (overlay) overlay.classList.add('show');
}

// ── Success Modal: Close ──
function closeSuccess() {
    const overlay = document.getElementById('success-overlay');
    if (overlay) overlay.classList.remove('show');

    ['fb-subject', 'fb-message'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    const counter = document.getElementById('char-count');
    if (counter) counter.textContent = '0 / 500 characters';

    window.location.href = '/public/index.php';
}

// ── Inline error helper ──
function showFormError(msg) {
    let el = document.getElementById('inline-form-error');
    if (!el) {
        el = document.createElement('div');
        el.id = 'inline-form-error';
        el.className = 'alert alert-error';
        const body = document.querySelector('.form-body') || document.querySelector('.admin-form-body');
        if (body) body.prepend(el);
    }
    el.textContent = '⚠ ' + msg;
    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => el.remove(), 5000);
}

// ── Admin login validation ──
function handleAdminLogin() {
    const user = document.getElementById('admin-user')?.value.trim();
    const pass = document.getElementById('admin-pass')?.value;
    if (!user || !pass) {
        showFormError('Please enter your username and password.');
        return false;
    }
    return true;
}

// ── Admin: Confirm Delete ──
function confirmDelete(id, title) {
    const msg = `Are you sure you want to delete:\n"${title}"?\n\nThis action cannot be undone.`;
    if (confirm(msg)) {
        window.location.href = `delete_announcement.php?id=${id}`;
    }
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

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeMenu();
});

window.addEventListener('resize', () => {
    if (window.innerWidth > 768) closeMenu();
});

// ── Auto-dismiss flash messages ──
document.addEventListener('DOMContentLoaded', () => {
    const flash = document.querySelector('.flash-msg');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity .4s ease';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 400);
        }, 4000);
    }
});
