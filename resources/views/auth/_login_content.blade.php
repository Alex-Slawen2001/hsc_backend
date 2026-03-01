<div style="margin-top: -20px;" class="container">
    <div class="page-header">
        <div class="breadcrumbs">
            <a href="/">Главная</a><span class="crumb-sep">→</span>
            <span>Вход</span>
        </div>
    </div>
</div>

<div style="margin-top: -50px;" class="container">

    <div class="page-header">
        <h1>Вход в систему</h1>
        <p>Войдите в свой личный кабинет для доступа ко всем услугам Вертолетной сервисной компании</p>
    </div>

    <div class="login-container">
        <div class="login-card" style="position:relative;">

            <div class="login-header">
                <h2>Вход в аккаунт</h2>
                <p>Используйте ваш логин и пароль</p>
            </div>

            {{-- Ошибка (Laravel или JS) --}}
            <div class="error-message" id="errorMessage"
                 style="display: {{ (session('error') || $errors->any()) ? 'block' : 'none' }};">
                {{ session('error') ?? ($errors->first() ?: 'Неверный логин или пароль') }}
            </div>

            <form id="loginForm" method="POST" action="{{ url('/login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label required" for="username">Логин или Email</label>
                    <input type="text"
                           class="form-input"
                           id="username"
                           name="username"
                           value="{{ old('username') }}"
                           placeholder="Введите ваш логин или email"
                           required
                           autocomplete="username">
                    <span class="form-hint" id="usernameHint">Введите логин или email, указанный при регистрации</span>
                    <div class="field-error" id="usernameErr" style="display:none;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="password">Пароль</label>
                    <div class="password-field">
                        <input type="password"
                               class="form-input"
                               id="password"
                               name="password"
                               placeholder="Введите ваш пароль"
                               required
                               autocomplete="current-password">
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Показать пароль">
                            👁
                        </button>
                    </div>
                    <span class="form-hint" id="passwordHint">Введите пароль, указанный при регистрации</span>
                    <div class="field-error" id="passwordErr" style="display:none;"></div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox" id="remember" name="remember">
                    <label class="checkbox-label" for="remember">Запомнить меня на этом устройстве</label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        Войти в систему <i>→</i>
                    </button>
                </div>
            </form>

            <div class="login-links">
                <div class="login-link">
                    <a href="/pages/password-recovery.html">Забыли пароль?</a>
                </div>
                <div class="login-link">
                    Нет аккаунта? <a href="/pages/reg.html">Зарегистрируйтесь</a>
                </div>
            </div>

            <div class="divider">или войдите через</div>

            <div class="social-login">
                <button type="button" class="social-btn" id="googleLogin">
                    <span class="social-icon">G</span>
                    <span>Google</span>
                </button>
                <button type="button" class="social-btn" id="yandexLogin">
                    <span class="social-icon">Я</span>
                    <span>Яндекс</span>
                </button>
            </div>

            {{-- Success: показываем только если реально ушли на другой URL --}}
            <div class="success-message" id="successMessage" style="display:none;">
                <div class="success-icon"><i>✓</i></div>
                <div class="success-title">Вход выполнен успешно!</div>
                <div class="success-text">Вы будете перенаправлены в личный кабинет через несколько секунд.</div>
            </div>

        </div>
    </div>
</div>

<style>
    .error-message{
        padding:12px;
        border-radius:12px;
        border:1px solid rgba(231,76,60,.9);
        background:rgba(231,76,60,.08);
        color:#ffb3b3;
        margin-bottom:14px;
    }
    .field-error{
        margin-top:6px;
        font-size:12px;
        color:#ffb3b3;
    }
    .input-error{
        border-color: rgba(231,76,60,.9) !important;
        box-shadow: 0 0 0 3px rgba(231,76,60,.12) !important;
    }

    /* success не мешает кликам */
    #successMessage{ pointer-events:none; }
    #successMessage.is-open{ pointer-events:auto; }

    /* центрируем ссылки */
    .login-links{
        margin-top: 18px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    .login-link{ text-align:center; font-size:14px; }
    .login-link a{
        color:#4d8dff;
        text-decoration:none;
        font-weight:500;
        transition: opacity .2s ease;
    }
    .login-link a:hover{ opacity:.8; }
</style>

<script>
    (function(){
        // show/hide password
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        if(togglePassword && passwordInput){
            togglePassword.addEventListener('click', () => {
                passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
            });
        }

        const form = document.getElementById('loginForm');
        if(!form) return;

        const btn  = document.getElementById('submitBtn');
        const errBox = document.getElementById('errorMessage');
        const okBox  = document.getElementById('successMessage');

        const u = document.getElementById('username');
        const p = document.getElementById('password');
        const uErr = document.getElementById('usernameErr');
        const pErr = document.getElementById('passwordErr');

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const clearErrors = () => {
            if(errBox){ errBox.style.display='none'; errBox.textContent=''; }
            if(uErr){ uErr.style.display='none'; uErr.textContent=''; }
            if(pErr){ pErr.style.display='none'; pErr.textContent=''; }
            u?.classList.remove('input-error');
            p?.classList.remove('input-error');
        };

        const showError = (text) => {
            if(errBox){
                errBox.textContent = text || 'Неверный логин или пароль';
                errBox.style.display = 'block';
            }
        };

        const showSuccess = () => {
            if(okBox){
                okBox.style.display = 'block';
                okBox.classList.add('is-open');
            }
        };

        // Достаём ошибку из HTML (если Laravel вернул страницу логина с ошибкой)
        const extractErrorFromHtml = (html) => {
            try{
                const doc = new DOMParser().parseFromString(html, 'text/html');

                // 1) если у тебя есть #errorMessage в шаблоне
                const el = doc.querySelector('#errorMessage');
                if(el){
                    const t = (el.textContent || '').trim();
                    if(t) return t;
                }

                // 2) стандартные ошибки Laravel
                const invalid = doc.querySelector('.invalid-feedback');
                if(invalid){
                    const t = (invalid.textContent || '').trim();
                    if(t) return t;
                }

                // 3) просто fallback
                return 'Неверный логин или пароль';
            }catch(e){
                return 'Неверный логин или пароль';
            }
        };

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearErrors();

            const oldText = btn?.innerHTML;
            if(btn){
                btn.disabled = true;
                btn.innerHTML = 'Проверка…';
            }

            try{
                const res = await fetch(form.action, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html,application/xhtml+xml',
                        ...(csrf ? {'X-CSRF-TOKEN': csrf} : {})
                    },
                    body: new FormData(form),
                    redirect: 'follow'
                });

                // Если токен реально не сошёлся — покажем понятную ошибку
                if(res.status === 419){
                    showError('Сессия/CSRF истекли. Обновите страницу и попробуйте снова.');
                    return;
                }

                // ВАЖНО: если после POST Laravel сделал redirect — res.url будет уже другим
                const finalUrl = res.url || '';
                const currentUrl = window.location.href;

                // Успех: ушли на другую страницу (обычно /dashboard)
                if(finalUrl && finalUrl !== currentUrl && !finalUrl.includes('/login')){
                    showSuccess();
                    setTimeout(() => window.location.href = finalUrl, 600);
                    return;
                }

                // Иначе это, скорее всего, возврат обратно на /login с ошибкой
                const html = await res.text();
                const msg = extractErrorFromHtml(html);

                // подсветка полей (простая)
                u?.classList.add('input-error');
                p?.classList.add('input-error');
                showError(msg);

            }catch(err){
                // fallback на обычную отправку (как в старой версии)
                form.submit();
            }finally{
                if(btn){
                    btn.disabled = false;
                    btn.innerHTML = oldText || 'Войти в систему <i>→</i>';
                }
            }
        });
    })();
</script>
