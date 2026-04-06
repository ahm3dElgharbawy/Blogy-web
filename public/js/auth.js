// ── Password Strength ────────────────────────────────────────

function passwordStrength(pwd) {
    let score = 0;
    if (pwd.length >= 8) score++;
    if (pwd.length >= 12) score++;
    if (/[A-Z]/.test(pwd)) score++;
    if (/[0-9]/.test(pwd)) score++;
    if (/[^A-Za-z0-9]/.test(pwd)) score++;
    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong', 'Very Strong'];
    const colors = ['', '#ff4d4f', '#ff7a45', '#faad14', '#52c41a', '#237804'];
    return { score, label: labels[score] || '', color: colors[score] || '' };
}

// ── Nav helpers ──────────────────────────────────────────────

// function renderNavAuth() {
//   const session = getSession();
//   const linksEl = document.getElementById('nav-auth-area');
//   if (!linksEl) return;
//   if (session) {
//     linksEl.innerHTML = `
//       <div class="nav-user-chip">
//         <div class="nav-avatar">${session.name[0].toUpperCase()}</div>
//         <span class="nav-username">${session.name.split(' ')[0]}</span>
//       </div>
//       <a href="dashboard.html" class="nav-btn">Dashboard</a>
//       <button class="nav-btn" onclick="Auth.logout()">Sign Out</button>`;
//   } else {
//     linksEl.innerHTML = `
//       <a href="login.html" class="nav-btn">Sign In</a>
//       <a href="register.html" class="nav-action">Get Started</a>`;
//   }
// }


// ── Form validation helpers ──────────────────────────────────

function setFieldError(fieldId, msg) {
    const wrap = document.getElementById(fieldId)?.closest('.form-field');
    if (!wrap) return;
    wrap.classList.add('has-error');
    const err = wrap.querySelector('.field-error');
    if (err) err.textContent = msg;
}
function clearFieldErrors() {
    document.querySelectorAll('.form-field').forEach(f => f.classList.remove('has-error'));
}
function showGlobalError(msg) {
    const el = document.getElementById('global-error');
    if (el) { el.textContent = msg; el.classList.add('show'); }
}
function hideGlobalError() {
    document.getElementById('global-error')?.classList.remove('show');
}

// Expose
window.FormHelper = { passwordStrength, setFieldError, clearFieldErrors, showGlobalError, hideGlobalError };
