@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <section class="hero">
        <div class="hero-inner">
            <div>
                <div class="hero-tag">Est.
                    <script>
                        document.write(new Date().getFullYear())
                    </script> — The Modern Writer's Platform
                </div>
                <h1>Where <em>Ideas</em> Find Their Voice</h1>
                <p>Blogy is a curated space for writers, thinkers, and creators. Discover stories that challenge,
                    inspire, and
                    illuminate.</p>
                <div class="hero-btns">
                    <button class="btn-primary"
                        onclick="document.getElementById('posts-section').scrollIntoView({behavior:'smooth'})">Explore
                        Articles</button>
                    <a href="{{ route('blog.posts.create') }}" class="btn-outline">Start Writing</a>
                </div>
            </div>
            <div class="hero-card fade-up" onclick="window.location.href = '{{ route('posts.show', $featuredPost->id) }}'">
                <div class="hero-card-img" style="background: linear-gradient(135deg,#1a2a3a 0%,#3a4a5c 100%)">
                    <div class="big-letter">T</div>
                    <div class="badge">Featured</div>
                </div>
                <div class="hero-card-body">
                    <h3>{{ $featuredPost->title }}</h3>
                    <p>{{ Str::limit(strip_tags($featuredPost->content), 150) }}</p>
                    <div class="card-meta">
                        <span>✦ {{ $featuredPost->category->name }}</span>
                        <span>· {{ $featuredPost->read_time }} min read</span>
                        <span>· {{ formatViews($featuredPost->views) }} views</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="main-layout" id="posts-section">
        <div>
            <div class="section-header">
                <div class="section-title" id="section-label">
                    @if ($query = request()->input('query'))
                        Results for "{{ $query }}"
                    @else
                        Latest Articles
                    @endif
                </div>
                <button class="see-all" onclick="window.location.href = '{{ route('home') }}#posts-section'">All Posts
                    →</button>
            </div>
            <div class="posts-grid" id="posts-grid">
                @foreach ($posts as $post)
                    <x-blog-card :post="$post" />
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $posts->fragment('posts-section')->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <aside class="sidebar">
            <div class="sidebar-widget">
                <div class="widget-title">Search</div>
                <div class="search-box">
                    <input type="text" id="search-input" placeholder="Search articles…">
                    <button onclick="onSearch()">⌕</button>
                </div>
            </div>
            <div class="sidebar-widget">
                <div class="widget-title">Categories</div>
                <div class="cat-list">
                    @foreach ($categories as $category)
                        <a href="{{ route('home', ['category' => $category->name]) }}#posts-section"
                            class="cat-item">{{ $category->name }} <span
                                class="cat-count">{{ $category->post_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="sidebar-widget">
                <div class="widget-title">Popular Tags</div>
                <div class="tag-cloud">
                    @foreach ($popularTags as $tag => $count)
                        <button class="tag"
                            onclick="window.location.href='{{ route('home', ['tag' => $tag]) }}#posts-section'">#{{ $tag }}</button>
                    @endforeach
                </div>
            </div>
            <div class="sidebar-widget newsletter-widget">
                <div class="widget-title">Newsletter</div>
                <p>The best articles delivered to your inbox every week.</p>
                <input class="newsletter-input" type="email" id="newsletter-email" placeholder="your@email.com">
                <button class="newsletter-btn">Subscribe →</button>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
    <script>
        function onSearch() {
            const query = document.getElementById('search-input').value.trim();

            if (query) {
                // استخدم base URL من Blade
                const url = "{{ route('home') }}?query=" + query + "#posts-section";
                window.location.href = url;
            }
        }
    </script>
@endpush
