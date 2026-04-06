// ============================================================
//  Blogy — Single Post Reader  (js/post.js)
// ============================================================

document.addEventListener('DOMContentLoaded', () => {
  Auth.renderNavAuth();
  const params = new URLSearchParams(window.location.search);
  const id = params.get('id');
  const post = IW.getPostById(id);
  if (!post) { document.body.innerHTML += '<p style="padding:120px 40px;font-size:18px;color:var(--muted)">Post not found.</p>'; return; }

  // Increment views
  const posts = IW.getPosts();
  const idx = posts.findIndex(p => p.id === post.id);
  if (idx > -1) { posts[idx].views = (posts[idx].views || 0) + 1; IW.savePosts(posts); }

  const catColor = IW.CAT_COLORS[post.category] || 'var(--primary)';

  document.title = post.title + ' — Inkwell';
  document.getElementById('post-cat').textContent = '✦ ' + post.category;
  document.getElementById('post-cat').style.color = catColor;
  document.getElementById('post-title').textContent = post.title;
  document.getElementById('post-author').textContent = post.author;
  document.getElementById('post-author-avatar').textContent = post.author[0];
  document.getElementById('post-date').textContent = post.date;
  document.getElementById('post-read').textContent = post.readTime + ' read';
  document.getElementById('post-views').textContent = IW.fmtViews(post.views) + ' views';
  document.getElementById('post-img').style.background = 'linear-gradient(' + post.color + ')';
  document.getElementById('post-img').textContent = post.letter;
  document.getElementById('post-body').innerHTML = post.content;
  document.getElementById('post-tags').innerHTML = (post.tags || []).map(t =>
    `<a class="tag" href="index.html?tag=${t}">#${t}</a>`
  ).join('');

  // Related posts
  const related = IW.getPosts().filter(p => p.id !== post.id && p.category === post.category).slice(0, 3);
  const relGrid = document.getElementById('related-grid');
  if (relGrid) {
    relGrid.innerHTML = related.map(p => `
      <a class="post-card" href="post.html?id=${p.id}">
        <div class="post-card-img" style="background:linear-gradient(${p.color})">${p.letter}</div>
        <div class="post-card-body">
          <div class="post-cat" style="color:${IW.CAT_COLORS[p.category]||'var(--primary)'}">✦ ${p.category}</div>
          <h4>${p.title}</h4>
          <div class="card-meta"><span>${p.author}</span><span>· ${p.readTime}</span></div>
        </div>
      </a>`).join('');
  }
});
