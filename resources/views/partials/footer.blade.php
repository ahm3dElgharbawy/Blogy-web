<footer>
    <div class="footer-inner">
        <div class="footer-top">
            <div class="footer-brand">
                <div style="font-size:24px;font-weight:900;color:var(--paper);letter-spacing:4px">
                    B<span style="color:var(--primary)">LOGY</span></div>
                <p>A curated publishing platform for writers who believe ideas matter.</p>
            </div>
            <div class="footer-col">
                <h4>Explore</h4>
                <ul>
                    <li><a href="#posts-section">All Articles</a></li>
                    @foreach ($categories as $category)
                        <li><a href="?category={{ $category->name }}#posts-section">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-col">
                <h4>Platform</h4>
                <ul>
                    @if (auth()->check() && auth()->user()->isAdmin())
                        <li><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                    @endif
                    <li><a href="{{ route('blog.posts.create') }}">Write Article</a></li>
                    <li><a href="{{ route('login') }}">Sign In</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Terms</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>©
                <script>
                    document.write(new Date().getFullYear())
                </script> BLOGY. ALL RIGHTS RESERVED.
            </span>
            <span>MADE WITH ♥️ FOR WRITERS</span>
        </div>
    </div>
</footer>
