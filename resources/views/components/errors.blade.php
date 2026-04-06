<div id="global-error" class="auth-global-error @if ($errors->any()) show @endif">
    <ul>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        @endif
    </ul>
</div>
