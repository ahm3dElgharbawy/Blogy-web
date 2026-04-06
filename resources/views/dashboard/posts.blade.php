@extends('layouts.dashboard')
@section('content')
    <!-- ALL POSTS -->
    <div class="dash-panel" id="panel-posts">
        <div class="dash-page-title">All Posts</div>
        <div class="dash-subtitle">Manage and edit all your published and draft content.</div>
        <div class="dash-card">
            <div class="dash-card-title">Posts Library <a href="{{ route('admin.posts.create') }}" class="btn-save">+
                    New Post</a></div>
            <table class="posts-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="all-posts-tbody">
                    @foreach ($posts as $post)
                        <tr>
                            <td
                                style="font-weight:500;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                {{ $post->title }}</td>
                            <td><span
                                    style="font-family:'DM Mono',monospace;font-size:11px;color:#c94a2c">{{ $post->category->name }}</span>
                            </td>
                            <td style="font-size:12px;color:var(--muted)">{{ $post->user->name }}</td>
                            <td><span class="status-badge published">{{ $post->status }}</span></td>
                            <td style="font-family:'DM Mono',monospace;font-size:12px">{{ $post->views }}</td>
                            <td style="font-family:'DM Mono',monospace;font-size:11px;color:var(--muted)">
                                {{ $post->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="action-btns">
                                    <a class="tbl-btn" href="{{ route('admin.posts.show', $post->id) }}"
                                        target="_blank">View</a>
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="tbl-btn">Edit</a>

                                    <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="tbl-btn">Del</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <div class="mt-4 d-flex justify-content-center">
                {{ $posts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
