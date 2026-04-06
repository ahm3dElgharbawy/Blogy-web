// ============================================================
//  Blogy — Shared Data Store  (js/data.js)
// ============================================================

const COLORS = [
  '135deg,#1a2a3a 0%,#3a4a5c 100%',
  '135deg,#2d4a35 0%,#4a7c59 100%',
  '135deg,#4a2a1a 0%,#c94a2c 100%',
  '135deg,#2a2a1a 0%,#c9972c 100%',
  '135deg,#1a1a4a 0%,#3a3a8c 100%',
  '135deg,#3a1a3a 0%,#7c4a8c 100%',
];

const CAT_COLORS = {
  Technology: '#c94a2c', Design: '#c9972c',
  Culture: '#4a7c59', Science: '#3a4a5c', Business: '#8c5a3a',
};

const DEFAULT_POSTS = [
  {
    id: 1, title: 'The Future of Artificial Intelligence in Creative Industries',
    excerpt: 'How machine learning reshapes the boundaries of human creativity and what it means for the next decade.',
    category: 'Technology', author: 'Alex Morgan', date: 'Dec 14, 2024',
    readTime: '8 min', views: 4200, status: 'published', color: COLORS[0], letter: 'A',
    tags: ['ai', 'technology', 'creativity'],
    content: `<p>The intersection of artificial intelligence and creative endeavors has long been a topic of fascination. As we stand at the threshold of a new era in machine learning, the implications for writers, designers, musicians, and visual artists have never been more immediate.</p>
<h2>The Collaboration Paradigm</h2>
<p>Rather than framing AI as a replacement for human creativity, the most productive lens is one of collaboration. Tools like large language models and generative image systems are being used not to replace creative work but to augment it — helping artists break through blocks and produce work at scales previously impossible.</p>
<blockquote>The question is not whether machines can create, but how human and machine creativity can combine to produce work neither could achieve alone.</blockquote>
<h2>What Changes, What Doesn't</h2>
<p>What remains distinctly human is intentionality — the reason a piece of work exists, the emotion it seeks to convey. AI systems, for all their sophistication, are pattern-completion engines operating without lived experience or genuine stake in the outcome.</p>
<p>What changes is the economics and accessibility of creative production. The gap between having an idea and executing it is shrinking dramatically.</p>`
  },
  {
    id: 2, title: 'Principles of Timeless Design: Lessons from the Bauhaus Movement',
    excerpt: 'How a 100-year-old design school still defines the principles driving modern visual communication.',
    category: 'Design', author: 'Priya Nair', date: 'Dec 11, 2024',
    readTime: '6 min', views: 3100, status: 'published', color: COLORS[1], letter: 'B',
    tags: ['design', 'bauhaus', 'aesthetics'],
    content: `<p>Founded in Weimar, Germany in 1919, the Bauhaus school operated for just 14 years. Yet its influence on how we think about design — the relationship between form and function, the unity of art and craft — remains as potent as ever.</p>
<h2>Form Follows Function</h2>
<p>The Bauhaus credo that form should follow function wasn't merely an aesthetic preference; it was a philosophical stance about the purpose of design in human life. Objects should serve people, not merely impress them.</p>
<blockquote>Design is not just what it looks like and feels like. Design is how it works.</blockquote>
<h2>Relevance in the Digital Age</h2>
<p>The principles that drove Herbert Bayer to design his universal typeface are the same ones guiding the best interface designers today. Clarity, purpose, the elimination of the unnecessary, and the elevation of the essential.</p>`
  },
  {
    id: 3, title: 'The New Economics of Attention: How Content Became the Currency',
    excerpt: 'Understanding the forces that transformed information from a scarce resource to an abundant one.',
    category: 'Culture', author: 'James Obi', date: 'Dec 9, 2024',
    readTime: '10 min', views: 5800, status: 'published', color: COLORS[2], letter: 'C',
    tags: ['culture', 'media', 'economics'],
    content: `<p>There is a particular irony at the heart of the modern information economy: we have more access to knowledge than at any point in human history, and yet the currency of that abundance is not knowledge itself but attention.</p>
<h2>The Inversion of Scarcity</h2>
<p>For most of human history, information was scarce and attention was abundant. The internet inverted this dynamic completely. The bottleneck shifted from the supply side to the demand side.</p>
<blockquote>We have created a world in which there is too much information for any individual mind to process.</blockquote>
<h2>What We Lost in the Transition</h2>
<p>The casualty of this transition is depth. In an attention economy, the incentive is not to produce the most valuable content but the most attention-capturing content.</p>`
  },
  {
    id: 4, title: 'CRISPR and the Next Decade: What Gene Editing Really Promises',
    excerpt: 'Separating the revolutionary potential from the hype in the most consequential biotechnology of our era.',
    category: 'Science', author: 'Dr. Lena Zhao', date: 'Dec 7, 2024',
    readTime: '9 min', views: 2700, status: 'published', color: COLORS[3], letter: 'G',
    tags: ['science', 'genetics', 'biology'],
    content: `<p>CRISPR-Cas9, the gene-editing technology that earned its discoverers the 2020 Nobel Prize in Chemistry, has generated a level of excitement rarely seen outside the development of the internet.</p>
<h2>The Mechanics of Molecular Scissors</h2>
<p>At its core, CRISPR functions as a search-and-cut system adapted from a bacterial immune mechanism. The Cas9 protein acts as molecular scissors, guided by synthetic RNA to a specific DNA sequence.</p>
<blockquote>We are in the early chapters of a story whose arc bends toward the elimination of inherited disease.</blockquote>`
  },
  {
    id: 5, title: 'Building Sustainable Businesses in the Post-Growth Economy',
    excerpt: 'A new generation of entrepreneurs proving purpose and profitability are not mutually exclusive.',
    category: 'Business', author: 'Marcus Chen', date: 'Dec 5, 2024',
    readTime: '7 min', views: 1900, status: 'published', color: COLORS[4], letter: 'S',
    tags: ['business', 'sustainability', 'entrepreneurship'],
    content: `<p>The most interesting businesses being built today are not the ones chasing maximum growth at any cost. They are the ones asking a different question: what is the company for, and who does it serve?</p>
<h2>The Limits of Hypergrowth</h2>
<p>The venture-backed hypergrowth model that dominated the 2010s produced companies optimized for user acquisition above all else. Many found themselves, after burning through hundreds of millions in capital, unable to articulate a sustainable path to profitability.</p>
<h2>Purpose as Competitive Advantage</h2>
<p>Companies built around a clear and genuine purpose tend to attract more committed employees, more loyal customers, and more patient capital.</p>`
  },
  {
    id: 6, title: 'Dark Mode, Typography, and the Craft of Reading on Screens',
    excerpt: 'Why screen reading is harder than it should be, and the design principles that make the difference.',
    category: 'Design', author: 'Sofia Reyes', date: 'Dec 3, 2024',
    readTime: '5 min', views: 3400, status: 'draft', color: COLORS[5], letter: 'D',
    tags: ['design', 'typography', 'ux'],
    content: `<p>We read more text on screens today than at any previous moment in human history, and yet screen typography remains stubbornly bad in most contexts.</p>
<h2>The Physiology of Screen Reading</h2>
<p>Reading from a light-emitting surface is physiologically different from reading a printed page. Dark mode can be easier on the eyes in low-light conditions not because dark is inherently better, but because it reduces total luminosity.</p>
<blockquote>The perfect typeface for screen reading is one the reader never notices — only the ideas it carries.</blockquote>`
  },
];

// ── Storage helpers ──────────────────────────────────────────

function getPosts() {
  const raw = localStorage.getItem('iw_posts');
  return raw ? JSON.parse(raw) : DEFAULT_POSTS;
}
function savePosts(posts) {
  localStorage.setItem('iw_posts', JSON.stringify(posts));
}
function getPostById(id) {
  return getPosts().find(p => p.id === Number(id));
}

// ── Utility ──────────────────────────────────────────────────
function fmtViews(n) {
  if (n >= 1000) return (n / 1000).toFixed(1) + 'k';
  return String(n);
}

// Export to window
window.IW = { getPosts, savePosts, getPostById, CAT_COLORS, COLORS, fmtViews };
