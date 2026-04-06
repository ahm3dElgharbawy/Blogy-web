<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>View Post</title>
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            padding-top: var(--nav-h);
        }

        .post-hero {
            background: var(--ink);
            padding: 64px 0;
        }

        .post-hero-inner {
            max-width: 760px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .back-btn {
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 0;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: .2s;
            text-decoration: none;
        }

        .back-btn:hover {
            color: var(--paper);
        }

        .post-hero-cat {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .post-hero h1 {
            font-size: clamp(28px, 4vw, 50px);
            font-weight: 900;
            line-height: 1.15;
            color: var(--paper);
            margin-bottom: 20px;
        }

        .post-hero-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            font-size: 11px;
            color: var(--muted);
        }

        .author-chip {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .author-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
        }

        .post-content-wrap {
            max-width: 760px;
            margin: 0 auto;
            padding: 60px 40px;
        }

        .post-featured-img {
            width: 100%;
            height: 380px;
            border-radius: 4px;
            margin-bottom: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 140px;
            font-weight: 900;
            color: rgba(255, 255, 255, .18);
        }

        .post-body {
            line-height: 1.85;
            font-size: 17px;
            color: #2a2a2a;
        }

        .post-body p {
            margin-bottom: 24px;
        }

        .post-body h2 {
            font-size: 26px;
            font-weight: 700;
            color: var(--ink);
            margin: 40px 0 16px;
            padding-left: 20px;
            border-left: 4px solid var(--primary);
        }

        .post-body h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--ink);
            margin: 30px 0 12px;
        }

        .post-body blockquote {
            margin: 32px 0;
            padding: 22px 28px;
            background: var(--cream);
            border-left: 4px solid var(--gold);
            border-radius: 0 4px 4px 0;
            font-style: italic;
            font-size: 19px;
            color: var(--slate);
        }

        .post-body code {
            font-size: 13px;
            background: var(--ink);
            color: var(--gold);
            padding: 2px 6px;
            border-radius: 2px;
        }

        .post-tags-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 40px;
            padding-top: 32px;
            border-top: 1px solid var(--border);
        }

        .related-section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 40px 80px;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        @media(max-width:700px) {
            .related-grid {
                grid-template-columns: 1fr
            }

            .post-content-wrap {
                padding: 40px 24px
            }

            .post-hero-inner {
                padding: 0 24px
            }
        }

        /* .post-featured-img img {
            width: 100%;
            border-radius: 15px;
        } */
    </style>

</head>

<body>
    <nav>
        <a href="{{ route('home') }}" class="nav-logo">B<span>LOGY</span></a>
        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-btn">Home</a>
            <div id="nav-auth-area" style="display:flex;align-items:center;gap:8px"></div>
        </div>
    </nav>

    <section class="post-hero">
        <div class="post-hero-inner">
            <a href="{{ route('admin.posts.index') }}" class="back-btn">← Back to Articles</a>
            <div id="post-cat" class="post-hero-cat" style="color: rgb(201, 151, 44);">✦ {{ $post->category->name }}
            </div>
            <h1 id="post-title">{{ $post->title }}</h1>
            <div class="post-hero-meta">
                <div class="author-chip">
                    <div class="author-avatar" id="post-author-avatar">{{ $post->user->name[0] }}</div>
                    <span id="post-author">{{ $post->user->name }}</span>
                </div>
                <span id="post-date">{{ $post->created_at->format('M d, Y') }}</span>
                <span id="post-read">{{ $post->read_time }} min read</span>
                <span id="post-views">{{ formatViews($post->views) }} views</span>
            </div>
        </div>
    </section>

    <div class="post-content-wrap">
        @if ($post->image != '')
            <img src="{{ asset('storage/' . $post->image) }}" class="post-featured-img" id="post-img"alt="post image">
        @endif

        <div class="post-body" id="post-body">
            {!! $post->content !!}
        </div>
        <div class="post-tags-row" id="post-tags">
            @foreach ($post->tags as $tag)
                <a class="tag" href="{{ url('/') . '?tag=' . $tag }}">#{{ $tag }}</a>
            @endforeach
        </div>
    </div>

    <div class="related-section">
        <div class="section-header">
            <div class="section-title">Related Articles</div>
        </div>
        <div class="related-grid" id="related-grid">
            @foreach ($relatedPosts as $post)
                <x-blog-card :post="$post" />
            @endforeach
        </div>
    </div>

    <footer>
        <div class="footer-inner">
            <div class="footer-bottom" style="border-top:none;padding-top:0">
                <span>&copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script> INKWELL
                </span>
                <a href="{{ route('home') }}"
                    style="color:var(--muted);text-decoration:none;font-family:'DM Mono',monospace;font-size:11px">←
                    Back to Blog</a>
            </div>
        </div>
    </footer>

    <div class="toast" id="toast"></div>
    <script src="{{ asset('js/data.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/post.js') }}"></script>
</body>

</html>
