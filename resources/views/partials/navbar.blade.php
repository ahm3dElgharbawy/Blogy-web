<nav>
    <a href="/" class="nav-logo">B<span>LOGY</span></a>
    <div class="nav-links">
        <a href="/" class="nav-btn active">Home</a>
        @foreach ($categories->take(3) as $category)
            <button class="nav-btn" onclick="window.location.href = '{{ route('home', ['category' => $category->name]) }}#posts-section'">{{ strtoupper($category->name) }}</button>
        @endforeach
        @if (($user = auth()->user()) && !auth()->user()->isAdmin())
            <div id="nav-auth-area" style="display:flex;align-items:center;gap:8px">
                <a href="{{ route('user.profile') }}">
                    <div class="nav-user-chip">
                        <div class="nav-avatar">{{ $user->name[0] }}</div>
                        <span class="nav-username">{{ $user->name }}</span>
                    </div>
                </a>
                <a class="nav-btn" href="{{ route('logout') }}">Sign Out</a>
            </div>
        @else
            <div id="nav-auth-area" style="display:flex;align-items:center;gap:8px">
                <a href="{{ route('login') }}" class="nav-btn">Sign In</a>
                <a href="{{ route('register') }}" class="nav-action">Get Started</a>
            </div>
        @endisset


</div>
</nav>
