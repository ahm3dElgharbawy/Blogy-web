@extends('layouts.dashboard')
@section('title', 'Create Post')
@section('content')
    {{-- @include('components.errors') --}}
    <!-- NEW POST -->
    <div class="dash-panel" id="panel-new-post">
        <div class="dash-page-title" id="np-panel-title">
            {{ isset($post) ? 'Update Post' : 'Write New Post' }}
        </div>
        <div class="dash-subtitle">
            {{ isset($post) ? 'Update current article in the blog.' : 'Create and publish a new article to the blog.' }}
        </div>
        <div class="dash-card">
            @include('partials.create-post-form', [
                'action' => isset($post) ? route('admin.posts.update', $post->id) : route('admin.posts.store'),
                'post' => $post ?? null,
            ])
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            license_key: 'gpl'
        });
    </script>
    <script>
        // file upload
        const fileInput = document.getElementById('file');
        const fileName = document.getElementById('file-name');

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
            } else {
                fileName.textContent = "No file selected";
            }
        });
    </script>
@endpush
