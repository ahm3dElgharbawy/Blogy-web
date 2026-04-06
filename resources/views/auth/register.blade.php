<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Create Account — {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="auth-page">
        <div class="auth-panel-left">
            <div class="auth-left-content">
                <a href="/" class="auth-brand">B<span>LOGY</span></a>
                <div class="auth-tagline">Join the<br><em>Blogy</em><br>community.</div>
                <p class="auth-desc">Create your free account and start publishing your ideas to a growing audience of
                    curious
                    readers.</p>
                <div class="auth-features">
                    <div class="auth-feature">
                        <div class="auth-feature-dot"></div><span>Publish unlimited articles</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-dot"></div><span>Beautiful editorial tools</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-dot"></div><span>Detailed analytics dashboard</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-dot"></div><span>Newsletter & subscriber tools</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="auth-panel-right">
            <div class="auth-form-box">
                <div class="auth-form-title">Create Account</div>
                <div class="auth-form-sub">Already a member? <a href="{{ route('login') }}">Sign in →</a></div>
                @include('components.errors')
                <div id="global-success" class="auth-global-success"></div>
                <form method="post" action="{{ route('register.submit') }}" class="auth-form" id="register-form">
                    @csrf
                    <div class="form-field" id="field-name">
                        <label for="reg-name">Full Name</label>
                        <input type="text" id="reg-name" name="name" placeholder="Ahmed Elgharbawy"
                            autocomplete="name" value="{{ old('name') }}">
                        <div class="field-error">Full name is required.</div>
                    </div>
                    <div class="form-field" id="field-reg-email">
                        <label for="reg-email">Email Address</label>
                        <input type="email" id="reg-email" name="email" placeholder="you@example.com"
                            autocomplete="email" value="{{ old('email') }}">
                        <div class="field-error">Valid email required.</div>
                    </div>
                    <div class="form-field" id="field-reg-password">
                        <label for="reg-password">Password</label>
                        <div class="password-field">
                            <input type="password" id="reg-password" name="password"
                                placeholder="Create a strong password" oninput="updateStrength(this.value)"
                                autocomplete="new-password" value="{{ old('password') }}">
                            <button type="button" class="toggle-pwd"
                                onclick="togglePwd('reg-password',this)">👁</button>
                        </div>
                        <div class="strength-bar">
                            <div class="strength-track">
                                <div class="strength-fill" id="strength-fill"
                                    style="width: 40%; background: rgb(201, 151, 44);"></div>
                            </div>
                            <div class="strength-label" id="strength-label" style="color: rgb(201, 151, 44);">Fair</div>
                        </div>
                        <div class="field-error">Password must be at least 8 characters.</div>
                    </div>
                    <div class="form-field" id="field-confirm">
                        <label for="reg-confirm">Confirm Password</label>
                        <div class="password-field">
                            <input type="password" id="reg-confirm" name="password_confirmation"
                                placeholder="Repeat your password" autocomplete="new-password"
                                value="{{ old('password_confirmation') }}">
                            <button type="button" class="toggle-pwd"
                                onclick="togglePwd('reg-confirm',this)">👁</button>
                        </div>
                        <div class="field-error">Passwords do not match.</div>
                    </div>
                    <div class="terms-check">
                        <input type="checkbox" id="terms" name="terms">
                        <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a
                                href="#">Privacy
                                Policy</a></label>
                    </div>
                    <button type="submit" class="auth-submit" id="reg-btn">Create Account →</button>
                </form>
            </div>
        </div>
    </div>
    <div class="toast" id="toast"></div>
    <script src="{{ asset('js/data.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script>
        // Auth.redirectIfLoggedIn();
        let form = document.getElementById("register-form");
        form.addEventListener("submit", function(e) {
            if (!handleRegister()) {
                e.preventDefault();
            }
        })

        function togglePwd(id, btn) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
            btn.textContent = input.type === 'password' ? '👁' : '🙈';
        }

        function updateStrength(pwd) {
            const {
                score,
                label,
                color
            } = FormHelper.passwordStrength(pwd);
            const bar = document.querySelector('.strength-bar');
            const fill = document.getElementById('strength-fill');
            const lbl = document.getElementById('strength-label');
            fill.style.width = (score * 20) + '%';
            fill.style.background = color;
            bar.style.display = pwd.length == 0 ? 'none' : 'block';
            lbl.textContent = label;
            lbl.style.color = color;
        }

        function handleRegister() {
            FormHelper.clearFieldErrors();
            FormHelper.hideGlobalError();

            const name = document.getElementById('reg-name').value.trim();
            const email = document.getElementById('reg-email').value.trim();
            const password = document.getElementById('reg-password').value;
            const confirm = document.getElementById('reg-confirm').value;
            const agreed = document.getElementById('terms').checked;

            let valid = true;
            if (!name) {
                FormHelper.setFieldError('reg-name', 'Name is required.');
                valid = false;
            }
            if (!email || !email.includes('@')) {
                FormHelper.setFieldError('reg-email', 'Valid email required.');
                valid = false;
            }
            if (password.length < 8) {
                FormHelper.setFieldError('reg-password', 'Minimum 8 characters.');
                valid = false;
            }
            if (password !== confirm) {
                FormHelper.setFieldError('reg-confirm', 'Passwords do not match.');
                valid = false;
            }
            if (!agreed) {
                FormHelper.showGlobalError('Please accept the terms to continue.');
                valid = false;
            }
            if (!valid) return false;

            const btn = document.getElementById('reg-btn');
            btn.disabled = true;
            btn.innerHTML = '<span class="btn-spinner"></span> Creating account…';

            // showToast('✓ Account created! Welcome.', 'success');
            // setTimeout(() => {}, 700);
            return true;
        }
    </script>
</body>

</html>
