<form class="quick-form" method="POST"
    action={{ $action }}
    enctype="multipart/form-data">
    @isset($post)
        @method('PUT')
    @endisset
    @csrf
    <div class="form-field  {{ errorClass('title') }}">
        <label for="title">Post Title *</label>
        <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}"
            placeholder="Write a captivating title…">

        @error('title')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-field {{ errorClass('category_id') }}">
        <label for="category_id">Category *</label>
        <select name="category_id" id="category_id">
            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select a category
            </option>

            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    {{-- <div class="form-field  @error('author') has-error @enderror">
        <label>Author</label>
        <input type="text" name="author" value="{{ old('author', $post->author ?? '') }}"
            placeholder="ex: Ahmed">
        @error('author')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div> --}}

    <div class="form-field {{ errorClass('read_time') }}">
        <label>Read Time (min)</label>
        <input type="number" name="read_time" value="{{ old('read_time', $post->read_time ?? 5) }}" min="1">
        @error('read_time')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-field {{ errorClass('summary') }}">
        <label>Excerpt / Summary</label>
        <input type="text" name="summary" value="{{ old('summary', $post->summary ?? '') }}"
            placeholder="Brief summary…">
        @error('summary')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-field {{ errorClass('content') }}">
        <label>Full Content *</label>
        <textarea name="content" id="content" style="min-height:220px" placeholder="Write your article here...">{{ old('content', $post->content ?? '') }}</textarea>

        @error('content')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-field {{ errorClass('tags') }}">
        <label>Tags (comma-separated)</label>
        <input type="text" name="tags"
            value="{{ old('tags', isset($post->tags) ? implode(', ', $post->tags) : '') }}"
            placeholder="ai, technology, future">
        @error('tags')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-field {{ errorClass('status') }}">
        <label>Status</label>
        <select name="status">
            <option value="" disabled {{ old('status', $post->status ?? null) ? '' : 'selected' }}>
                Select status
            </option>
            @foreach ($postStatuses as $status)
                <option value="{{ $status }}"
                    {{ @old('status', $post->status ?? null) == $status ? 'selected' : '' }}>
                    {{ Str::ucfirst($status) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-field {{ errorClass('image') }}">
        <label>Post Image</label>
        <div class="file-upload">
            <input type="file" id="file" class="file-input" name="image" accept="image/*">
            <label for="file" class="file-label {{ $errors->has('image') ? 'input-error' : '' }}">
                <span class="file-text">Choose an image</span>
                <span class="file-button">Browse</span>
            </label>
            <p class="{{ $errors->has('image') ? 'field-error' : 'file-name' }}" id="file-name">
                @error('image')
                    {{ $message }}
                @else
                    No file selected
                @enderror
            </p>
        </div>
    </div>
    <div class="form-actions">
        @if (!isset($post))
            <button type="reset" class="btn-cancel">Clear</button>
        @endif
        <button type="submit" class="btn-save">{{ isset($post) ? 'Save Post →' : 'Publish Post →' }}</button>
    </div>
</form>
