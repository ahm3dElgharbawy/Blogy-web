<a class="post-card" href="{{ route(auth()->user()?->isAdmin() ? 'admin.posts.show' : 'posts.show' , $post->id) }}">
    <div class="blog-card-container">
        <div class="blog-image">
            <img src="{{ $post->image == '' ? asset('images/blog-image.jpg') : asset('/storage/'.$post->image) }}" alt="blog-image">
        </div>

        <div class="blog-info">
            <h3>
                {{ $post->category->name ?? 'General' }} •
                {{ $post->read_time }} min read
            </h3>

            <h1 class="blog-title">
                {{ $post->title }}
            </h1>

            <p class="blog-content">
                {{ Str::limit(strip_tags($post->content), 100, '...') }}
            </p>

            <div class="author-row">
                <div class="avatar">
                    {{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}
                </div>

                <p class="author-name">
                    {{ $post->user->name ?? 'Unknown' }} •
                    {{ $post->created_at->format('d M, Y') }}
                </p>
            </div>
        </div>
    </div>
</a>
