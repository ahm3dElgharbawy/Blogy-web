// ============================================================
//  Blogy — Homepage Logic  (js/app.js)
// ============================================================


function renderPosts(list) {
    const grid = document.getElementById('posts-grid');
    grid.innerHTML = '';
    if (!list.length) {
        grid.innerHTML = '<p style="color:var(--muted);font-size:14px;grid-column:span 2;padding:40px 0">No articles found.</p>';
        return;
    }
    list.forEach((p, i) => {
        const catColor = IW.CAT_COLORS[p.category] || 'var(--primary)';
        const card = document.createElement('a');
        card.className = 'post-card fade-up';
        card.href = `post.html?id=${p.id}`;
        card.style.animationDelay = `${i * 0.07}s`;
        card.innerHTML = `
      <div class="post-card-img" style="background:linear-gradient(${p.color})">${p.letter}</div>
      <div class="post-card-body">
        <div class="post-cat" style="color:${catColor}">✦ ${p.category}</div>
        <h4>${p.title}</h4>
        <p>${p.excerpt}</p>
        <div class="card-meta">
          <span>${p.author}</span>
          <span>· ${p.readTime} read</span>
          <span>· ${IW.fmtViews(p.views)} views</span>
        </div>
      </div>`;
        grid.appendChild(card);
    });
}

function filterPosts(cat) {
    const label = document.getElementById('section-label');
    if (label) label.textContent = cat;
    renderPosts(IW.getPosts().filter(p => p.category === cat || (p.tags || []).includes(cat.toLowerCase())));
    document.getElementById('posts-section')?.scrollIntoView({ behavior: 'smooth' });
}

function clearFilter() {
    const label = document.getElementById('section-label');
    if (label) label.textContent = 'Latest Articles';
    renderPosts(IW.getPosts());
}

function subscribe() {
    const input = document.getElementById('newsletter-email');
    if (!input.value || !input.value.includes('@')) {
        Auth.showToast('⚠ Please enter a valid email address.');
        return;
    }
    input.value = '';
    Auth.showToast('✓ Subscribed! Welcome to Inkwell.', 'success');
}

function showToast(msg, type = 'default') {
    let el = document.getElementById('toast');
    if (!el) {
        el = document.createElement('div');
        el.id = 'toast'; el.className = 'toast';
        document.body.appendChild(el);
    }
    el.textContent = msg;
    el.style.borderLeftColor = type === 'success' ? 'var(--sage)' : 'var(--primary)';
    el.classList.add('show');
    clearTimeout(el._t);
    el._t = setTimeout(() => el.classList.remove('show'), 3200);
}

window.clearFilter = clearFilter;
window.subscribe = subscribe;
window.showToast = showToast;
