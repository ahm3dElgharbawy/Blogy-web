@extends('layouts.dashboard')
@section('content')
    <!-- SETTINGS -->
    <div class="dash-panel" id="panel-settings">
        <div class="dash-page-title">Settings</div>
        <div class="dash-subtitle">Configure your blog and account preferences.</div>
        <div class="dash-grid">
            <div class="dash-card">
                <div class="dash-card-title">Blog Settings</div>
                <form action='{{ route('admin.settings.blog.update') }}' method="POST" class="quick-form">
                    @csrf
                    @method('PUT')
                    <div class="form-field">
                        <label>Blog Title</label>
                        <input type="text" name="blog_title" value="{{ $blogTitle?->value }}">
                    </div>

                    <div class="form-field">
                        <label>Tagline</label>
                        <input type="text" name="tagline" value= "{{ $tagline?->value }}">
                    </div>

                    <div class="form-field">
                        <label>Posts Per Page</label>
                        <select name="posts_per_page">
                            <option value="4" @if ($postsPerPage?->value == '4') selected @endif>6</option>
                            <option value="6" @if ($postsPerPage?->value == '6') selected @endif>6</option>
                            <option value="9" @if ($postsPerPage?->value == '9') selected @endif>9</option>
                            <option value="12" @if ($postsPerPage?->value == '12') selected @endif>12</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button class="btn-save">Save Settings</button>
                    </div>
                </form>
            </div>
            <div class="dash-card">
                <div class="dash-card-title">Profile</div>
                <form action="{{ route('admin.settings.profile.update') }}" method="POST" class="quick-form">
                    @csrf
                    @method('PUT')
                    <div class="form-field">
                        <label>Display Name</label>
                        <input type="text" name="name" id="set-name" value="{{ $user->name }}">
                    </div>

                    <div class="form-field">
                        <label>Email</label>
                        <input type="email" name="email" id="set-email" value="{{ $user->email }}">
                    </div>

                    <div class="form-field">
                        <label>Bio</label>
                        <textarea name="bio" id="set-bio" style="min-height:80px" value="{{ $user->profile?->bio }}">{{ $user->profile?->bio }}</textarea>
                    </div>

                    <div class="form-actions">
                        <button class="btn-save">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
