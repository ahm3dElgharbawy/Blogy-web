<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Sign In — {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="auth-page">
        <!-- LEFT -->
        <div class="auth-panel-left">
            <div class="auth-left-content">
                <a href="/" class="auth-brand">B<span>logy</span></a>
                <div class="auth-tagline">Welcome<br>back,<br><em>Writer.</em></div>
                <p class="auth-desc">Sign in to access your dashboard, manage your posts, and keep crafting stories that
                    matter.</p>
                <div class="auth-features">
                    <div class="auth-feature">
                        <div class="auth-feature-dot"></div><span>Full dashboard with analytics</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-dot"></div><span>Publish and manage articles</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-dot"></div><span>Comment moderation tools</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-dot"></div><span>Subscriber management</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- RIGHT -->
        <div class="auth-panel-right">
            <div class="auth-form-box">
                <div class="auth-form-title">Sign In</div>
                <div class="auth-form-sub">Don't have an account? <a href="{{ route('register') }}">Create one free
                        →</a></div>
                @include('components.errors')
                <form method="post" action="{{ route('login.submit') }}" class="auth-form" id="login-form">
                    @csrf
                    <div class="form-field" id="field-email">
                        <label>Email Address</label>
                        <input type="email" id="login-email" name="email" placeholder="you@example.com"
                            autocomplete="email">
                        <div class="field-error">Please enter a valid email.</div>
                    </div>
                    <div class="form-field" id="field-password">
                        <label>Password</label>
                        <div class="password-field">
                            <input type="password" id="login-password" name="password" placeholder="Your password"
                                autocomplete="current-password">
                            <button type="button" class="toggle-pwd"
                                onclick="togglePwd('login-password',this)">👁</button>
                        </div>

                        @error('password')
                            <div class="field-error">
                                {{ $message }}
                            </div>
                        @else
                            <div class="field-error">Password is required.</div>
                        @enderror



                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <label
                            style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted);cursor:pointer">
                            <input type="checkbox" id="remember-me" name="remember"
                                style="accent-color:var(--primary);width:auto">
                            Remember me
                        </label>
                        <a href="#"
                            style="font-size:12px;color:var(--primary);font-family:'DM Mono',monospace">Forgot
                            password?</a>
                    </div>
                    <button type="submit" class="auth-submit" id="login-btn">
                        Sign In →
                    </button>
                    {{-- <div class="auth-divider"><span>or try demo</span></div>
                    <button class="auth-submit" onclick="demoLogin()" style="background:var(--slate)">
                        Sign in as Demo User
                    </button> --}}
                </form>
            </div>
        </div>
    </div>
    <div class="toast" id="toast"></div>
    <script src="{{ asset('js/data.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script>
        //   Auth.redirectIfLoggedIn();
        const form = document.getElementById("login-form");
        const successMessage = @json(session('success'));
        if (successMessage) {
            showToast(successMessage, "success");
        }
        form.addEventListener("submit", function(e) {
            if (!handleLogin()) {
                e.preventDefault();
            }
        })

        function togglePwd(id, btn) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
            btn.textContent = input.type === 'password' ? '👁' : '🙈';
        }


        function handleLogin() {
            FormHelper.clearFieldErrors();
            FormHelper.hideGlobalError();
            const email = document.getElementById('login-email').value.trim();
            const password = document.getElementById('login-password').value;
            const remember = document.getElementById('remember-me').checked;

            let valid = true;
            if (!email || !email.includes('@')) {
                FormHelper.setFieldError('login-email', 'Valid email required.');
                valid = false;
            }
            if (!password) {
                FormHelper.setFieldError('login-password', 'Password is required.');
                valid = false;
            }
            if (!valid) {
                return false;
            };

            const btn = document.getElementById('login-btn');
            btn.disabled = true;
            btn.innerHTML = '<span class="btn-spinner"></span> Signing in…';
            // Source - https://stackoverflow.com/a/4738619
            // Posted by BrunoLM, modified by community. See post 'Timeline' for change history
            // Retrieved 2026-03-28, License - CC BY-SA 3.0

            setTimeout(function() {
                btn.disabled = false;
                btn.innerHTML = 'Sign In →';
            }, 1000);

            return true;
        }
    </script>
</body>

</html>
