// ============================================================
//  Blogy  — Dashboard Logic  (js/dashboard.js)
// ============================================================

let currentUser;

document.addEventListener('DOMContentLoaded', () => {
  currentUser = Auth.requireAuth();
  if (!currentUser) return;

  // Fill user info
  document.getElementById('dash-user-name').textContent = currentUser.name;
  document.getElementById('dash-user-role').textContent = currentUser.role || 'Author';
  document.getElementById('dash-avatar-letter').textContent = currentUser.name[0].toUpperCase();

  Auth.renderNavAuth();
  renderAll();
  showPanel('overview');
});

function renderAll() {
  renderChart();
  renderOverviewTable();
  renderAllPostsTable();
  renderActivityFeed();
  renderComments();
  renderTopPosts();
  renderTrafficSources();
  renderSubscribers();
  updateStats();
}

// ── Panel navigation ─────────────────────────────────────────

function showPanel(name) {
  document.querySelectorAll('.dash-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('panel-' + name)?.classList.add('active');
  document.querySelectorAll('.dash-nav-item').forEach(i => {
    i.classList.toggle('active', i.dataset.panel === name);
  });
}
window.showPanel = showPanel;

// ── Stats ────────────────────────────────────────────────────

function updateStats() {
  const posts = IW.getPosts();
  document.getElementById('stat-posts').textContent = posts.length;
  const totalViews = posts.reduce((s, p) => s + (p.views || 0), 0);
  document.getElementById('stat-views').textContent = IW.fmtViews(totalViews);
}

// ── Chart ────────────────────────────────────────────────────

function renderChart() {
  const data = [62, 45, 78, 90, 55, 40, 70];
  const max = Math.max(...data);
  const el = document.getElementById('chart-bars');
  if (!el) return;
  el.innerHTML = data.map(v => `
    <div class="chart-bar" title="${v * 100} views">
      <div class="bar-fill" style="height:${(v/max*100)}%"></div>
    </div>`).join('');
}

// ── Overview table ───────────────────────────────────────────

function renderOverviewTable() {
  const tbody = document.getElementById('overview-tbody');
  if (!tbody) return;
  tbody.innerHTML = IW.getPosts().slice(0, 5).map(p => `
    <tr>
      <td style="font-weight:500;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${p.title}</td>
      <td><span style="font-family:'DM Mono',monospace;font-size:11px;color:${IW.CAT_COLORS[p.category]}">${p.category}</span></td>
      <td><span class="status-badge ${p.status}">${p.status}</span></td>
      <td style="font-family:'DM Mono',monospace;font-size:12px">${IW.fmtViews(p.views)}</td>
      <td><div class="action-btns">
        <a class="tbl-btn" href="post.html?id=${p.id}" target="_blank">View</a>
        <button class="tbl-btn" onclick="editPost(${p.id})">Edit</button>
      </div></td>
    </tr>`).join('');
}

// ── All posts table ──────────────────────────────────────────

function renderAllPostsTable() {
  const tbody = document.getElementById('all-posts-tbody');
  if (!tbody) return;
  tbody.innerHTML = IW.getPosts().map(p => `
    <tr>
      <td style="font-weight:500;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${p.title}</td>
      <td><span style="font-family:'DM Mono',monospace;font-size:11px;color:${IW.CAT_COLORS[p.category]}">${p.category}</span></td>
      <td style="font-size:12px;color:var(--muted)">${p.author}</td>
      <td><span class="status-badge ${p.status}">${p.status}</span></td>
      <td style="font-family:'DM Mono',monospace;font-size:12px">${IW.fmtViews(p.views)}</td>
      <td style="font-family:'DM Mono',monospace;font-size:11px;color:var(--muted)">${p.date}</td>
      <td><div class="action-btns">
        <a class="tbl-btn" href="post.html?id=${p.id}" target="_blank">View</a>
        <button class="tbl-btn" onclick="editPost(${p.id})">Edit</button>
        <button class="tbl-btn" onclick="deletePost(${p.id})">Del</button>
      </div></td>
    </tr>`).join('');
}

function deletePost(id) {
  if (!confirm('Delete this post? This cannot be undone.')) return;
  IW.savePosts(IW.getPosts().filter(p => p.id !== id));
  renderAll();
  Auth.showToast('🗑 Post deleted.');
}
window.deletePost = deletePost;

function editPost(id) {
  const p = IW.getPostById(id);
  if (!p) return;
  showPanel('new-post');
  document.getElementById('np-id').value = p.id;
  document.getElementById('np-title').value = p.title;
  document.getElementById('np-excerpt').value = p.excerpt;
  document.getElementById('np-content').value = p.content;
  document.getElementById('np-cat').value = p.category;
  document.getElementById('np-author').value = p.author;
  document.getElementById('np-read').value = parseInt(p.readTime);
  document.getElementById('np-tags').value = (p.tags || []).join(', ');
  document.getElementById('np-status').value = p.status;
  document.getElementById('np-panel-title').textContent = 'Edit Post';
}
window.editPost = editPost;

// ── Publish / Save Post ──────────────────────────────────────

function publishPost() {
  Auth.clearFieldErrors();
  const title   = document.getElementById('np-title').value.trim();
  const excerpt = document.getElementById('np-excerpt').value.trim();
  const content = document.getElementById('np-content').value.trim();
  const cat     = document.getElementById('np-cat').value;
  const author  = document.getElementById('np-author').value.trim() || currentUser.name;
  const read    = document.getElementById('np-read').value || '5';
  const tags    = document.getElementById('np-tags').value.split(',').map(t => t.trim()).filter(Boolean);
  const status  = document.getElementById('np-status').value;
  const editId  = document.getElementById('np-id').value;

  let valid = true;
  if (!title)   { Auth.setFieldError('np-title',   'Title is required.'); valid = false; }
  if (!content) { Auth.setFieldError('np-content', 'Content is required.'); valid = false; }
  if (!valid) return;

  const posts = IW.getPosts();

  if (editId) {
    const idx = posts.findIndex(p => p.id === Number(editId));
    if (idx > -1) {
      posts[idx] = { ...posts[idx], title, excerpt: excerpt || title, content, category: cat, author, readTime: read + ' min', tags, status, letter: title[0].toUpperCase() };
      IW.savePosts(posts);
      Auth.showToast('✓ Post updated!', 'success');
    }
  } else {
    const newPost = {
      id: Date.now(), title, excerpt: excerpt || title, content,
      category: cat, author, date: new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }),
      readTime: read + ' min', views: 0, status,
      color: IW.COLORS[Math.floor(Math.random() * IW.COLORS.length)],
      letter: title[0].toUpperCase(), tags,
    };
    posts.unshift(newPost);
    IW.savePosts(posts);
    Auth.showToast('✓ Post published!', 'success');
  }

  clearNewPost();
  renderAll();
  showPanel('posts');
}
window.publishPost = publishPost;

function clearNewPost() {
  ['np-title','np-excerpt','np-content','np-tags','np-id'].forEach(id => {
    const el = document.getElementById(id); if (el) el.value = '';
  });
  const el = document.getElementById('np-read'); if (el) el.value = 5;
  const el2 = document.getElementById('np-author'); if (el2) el2.value = currentUser?.name || '';
  const title = document.getElementById('np-panel-title'); if (title) title.textContent = 'Write New Post';
}
window.clearNewPost = clearNewPost;

// ── Activity feed ────────────────────────────────────────────

const ACTIVITIES = [
  { type: 'publish', text: '<strong>The Future of AI</strong> was published.', time: '2h ago' },
  { type: 'comment', text: '<strong>Sarah K.</strong> commented on "Bauhaus Design".', time: '4h ago' },
  { type: 'view',    text: 'Your CRISPR post reached <strong>2,700 views</strong>.', time: '6h ago' },
  { type: 'comment', text: '<strong>Tom R.</strong> commented on "Attention Economy".', time: '8h ago' },
  { type: 'publish', text: 'Dark Mode Typography saved as <strong>draft</strong>.', time: '1d ago' },
];

function renderActivityFeed() {
  const el = document.getElementById('activity-list');
  if (!el) return;
  el.innerHTML = ACTIVITIES.map(a => `
    <div class="activity-item">
      <div class="act-dot ${a.type}"></div>
      <div class="act-text">${a.text}</div>
      <div class="act-time">${a.time}</div>
    </div>`).join('');
}

// ── Comments ─────────────────────────────────────────────────

let comments = [
  { author: 'Sarah Kim', initials: 'SK', color: '#3a6a8c', date: 'Dec 14', postRef: 'Bauhaus Design', text: 'This is exactly the kind of analysis I come here for. The connection to modern interface design is perfectly articulated.' },
  { author: 'Tom Reynolds', initials: 'TR', color: '#4a7c59', date: 'Dec 13', postRef: 'Attention Economy', text: "Strong piece, though I'd push back on the idea that depth and engagement are necessarily in opposition." },
  { author: 'Amara Liu', initials: 'AL', color: '#8c4a3a', date: 'Dec 12', postRef: 'CRISPR Article', text: 'As a molecular biologist, I appreciate the accuracy. The Cas9 explanation is accessible without being dumbed down.' },
];

function renderComments() {
  const el = document.getElementById('comments-list');
  if (!el) return;
  if (!comments.length) { el.innerHTML = '<p style="color:var(--muted);font-size:13px;padding:20px 0">No pending comments.</p>'; return; }
  el.innerHTML = comments.map((c, i) => `
    <div class="comment-item">
      <div class="comment-header">
        <div class="comment-avatar" style="background:${c.color}">${c.initials}</div>
        <div><div class="comment-author">${c.author}</div><div class="comment-post-ref">on: ${c.postRef}</div></div>
        <div class="comment-date">${c.date}</div>
      </div>
      <div class="comment-text">${c.text}</div>
      <div class="comment-actions">
        <button class="com-btn approve" onclick="moderateComment(${i},'approve')">✓ Approve</button>
        <button class="com-btn reject"  onclick="moderateComment(${i},'reject')">✗ Reject</button>
      </div>
    </div>`).join('');
}

function moderateComment(i, action) {
  comments.splice(i, 1);
  renderComments();
  Auth.showToast(action === 'approve' ? '✓ Comment approved.' : '✗ Comment rejected.');
}
window.moderateComment = moderateComment;

// ── Top posts ────────────────────────────────────────────────

function renderTopPosts() {
  const el = document.getElementById('top-posts-list');
  if (!el) return;
  const sorted = [...IW.getPosts()].sort((a, b) => (b.views || 0) - (a.views || 0)).slice(0, 5);
  el.innerHTML = sorted.map((p, i) => `
    <div class="top-post-item" onclick="window.open('post.html?id=${p.id}','_blank')">
      <div class="top-num">0${i + 1}</div>
      <div class="top-post-info">
        <h5>${p.title.substring(0, 40)}…</h5>
        <span>${p.category} · ${p.readTime}</span>
      </div>
      <div class="top-post-views">${IW.fmtViews(p.views)}</div>
    </div>`).join('');
}

// ── Traffic sources ──────────────────────────────────────────

function renderTrafficSources() {
  const el = document.getElementById('traffic-sources');
  if (!el) return;
  const sources = [
    { source: 'Organic Search', pct: 48, color: 'var(--primary)' },
    { source: 'Direct',         pct: 22, color: 'var(--gold)' },
    { source: 'Social Media',   pct: 18, color: 'var(--sage)' },
    { source: 'Referral',       pct:  9, color: 'var(--slate)' },
    { source: 'Newsletter',     pct:  3, color: '#8c5a8c' },
  ];
  el.innerHTML = sources.map(s => `
    <div>
      <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:13px">
        <span style="font-weight:500">${s.source}</span>
        <span style="font-family:'DM Mono',monospace;font-size:11px;color:var(--muted)">${s.pct}%</span>
      </div>
      <div style="height:6px;background:var(--border);border-radius:3px;overflow:hidden">
        <div style="height:100%;width:${s.pct}%;background:${s.color};border-radius:3px"></div>
      </div>
    </div>`).join('');
}

// ── Subscribers ──────────────────────────────────────────────

function renderSubscribers() {
  const tbody = document.getElementById('subscribers-tbody');
  if (!tbody) return;
  const subs = [
    { email: 'sarah.kim@example.com', joined: 'Dec 10', status: 'active' },
    { email: 'tom.r@design.co', joined: 'Dec 9', status: 'active' },
    { email: 'amara.liu@biotech.io', joined: 'Dec 8', status: 'active' },
    { email: 'marcus.c@ventures.com', joined: 'Dec 7', status: 'active' },
    { email: 'priya.n@studio.in', joined: 'Dec 6', status: 'inactive' },
    { email: 'lena.z@research.edu', joined: 'Dec 5', status: 'active' },
  ];
  tbody.innerHTML = subs.map((s, i) => `
    <tr>
      <td style="font-family:'DM Mono',monospace;font-size:12px;color:var(--muted)">${i + 1}</td>
      <td style="font-weight:500">${s.email}</td>
      <td style="font-family:'DM Mono',monospace;font-size:11px;color:var(--muted)">${s.joined}</td>
      <td><span class="status-badge ${s.status === 'active' ? 'published' : 'draft'}">${s.status}</span></td>
    </tr>`).join('');
}

// ── Quick draft save ─────────────────────────────────────────

function saveDraft() {
  const t = document.getElementById('quick-title').value.trim();
  if (!t) { Auth.showToast('⚠ Enter a title first.'); return; }
  Auth.showToast('✓ Draft saved!', 'success');
  document.getElementById('quick-title').value = '';
  document.getElementById('quick-content').value = '';
}
window.saveDraft = saveDraft;
