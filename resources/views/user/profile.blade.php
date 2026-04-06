<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            background: var(--bg);
            padding: 30px;
        }

        /* Layout */
        .section-title::after {
            display: none;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 20px;
        }

        /* Cards */
        .card {
            background: var(--card);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid var(--border);
        }

        /* Profile Sidebar */
        .profile-card {
            text-align: center;
        }

        .profile-card img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .upload-btn {
            font-size: 14px;
            color: var(--primary);
            cursor: pointer;
        }

        /* Form */
        .section-title {
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
            color: var(--text);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: span 2;
        }

        label {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 5px;
        }

        input,
        textarea {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid var(--border);
            outline: none;
            transition: 0.2s;
        }

        input:focus,
        textarea:focus {
            border-color: var(--primary);
        }

        textarea {
            resize: none;
            height: 100px;
        }

        /* Sticky Save Button */
        .actions {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 15px 0;
            margin-top: 20px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            font-size: 15px;
            cursor: pointer;
        }

        small {
            color: red;
            margin-top: 5px;
        }

        /* Responsive */
        @media(max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')

        <div class="container">
            <div class="grid">

                <!-- Sidebar -->
                <div class="card profile-card">
                    <img id="profilePreview"
                        src="{{ auth()->user()->profile?->avatar
                            ? asset('storage/' . auth()->user()->profile->avatar)
                            : asset('images/user-avatar.png') }}"
                        alt="Profile">

                    <p><strong>{{ explode('@', auth()->user()->email)[0] }}</strong></p>
                    <p style="color: gray;">{{ '@' . explode('@', auth()->user()->email)[1] }}</p>

                    <br>

                    <label class="upload-btn">
                        Change Photo
                        <input id="imageInput" type="file" name="avatar" accept="image/*" hidden>
                    </label>

                    @error('avatar')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <!-- Main Form -->
                <div class="card">

                    <div class="section-title">Profile Info</div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label>Full Name</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}">
                            @error('name')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group full">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                            @error('email')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label>Bio</label>
                            <textarea name="bio">{{ old('bio', auth()->user()->profile?->bio) }}</textarea>
                            @error('bio')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="section-title" style="margin-top:20px;">Social Links</div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label>Website</label>
                            <input type="text" name="website"
                                value="{{ old('website', auth()->user()->profile?->website) }}">
                        </div>

                        <div class="form-group">
                            <label>Twitter</label>
                            <input type="text" name="twitter"
                                value="{{ old('twitter', auth()->user()->profile?->twitter) }}">
                        </div>

                        <div class="form-group">
                            <label>LinkedIn</label>
                            <input type="text" name="linkedin"
                                value="{{ old('linkedin', auth()->user()->profile?->linkedin) }}">
                        </div>
                    </div> --}}

                    <div class="section-title" style="margin-top:20px;">Password</div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="password">
                            @error('password')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation">
                            @error('password_confirmation')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="actions">
                        <button type="submit">Save Changes</button>
                    </div>

                </div>

            </div>
        </div>
    </form>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        const successMessage = @json(session('success'));
        if (successMessage) {
            showToast(successMessage, "success");
        }
    </script>
    <script>
        const input = document.getElementById('imageInput');
        const preview = document.getElementById('profilePreview');

        input.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    preview.src = this.result;
                });

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
