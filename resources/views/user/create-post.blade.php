<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @isset($post)
            Edit
        @else
            Create
        @endisset Post
    </title>
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .post-form-container {
            padding: 100px 5%;
        }

        .quick-form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .post-card {
            background: var(--card);
            border-radius: 4px;
            padding: 28px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
        }
    </style>
</head>

<body>
    @include('partials.navbar')
    <div class="post-form-container">
        <div class="post-card">
            @include('partials.create-post-form', [
                'action' => isset($post) ? route('blog.posts.update', $post->id) : route('blog.posts.store'),
                'post' => $post ?? null,
            ])
        </div>

    </div>
    @include('partials.footer')

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
</body>

</html>
