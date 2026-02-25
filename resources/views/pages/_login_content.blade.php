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
        <div class="login-card">
            <div class="login-header">
                <h2>Вход в аккаунт</h2>
                <p>Используйте ваш логин и пароль</p>
            </div>

            <div class="error-message" id="errorMessage">
                Неверный логин или пароль
            </div>

            <form id="loginForm">
                <div class="form-group">
                    <label class="form-label required" for="username">Логин или Email</label>
                    <input type="text" class="form-input" id="username" name="username" placeholder="Введите ваш логин или email" required>
                    <span class="form-hint" id="usernameHint">Введите логин или email, указанный при регистрации</span>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="password">Пароль</label>
                    <div class="password-field">
                        <input type="password" class="form-input" id="password" name="password" placeholder="Введите ваш пароль" required>
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Показать пароль">
                            👁
                        </button>
                    </div>
                    <span class="form-hint" id="passwordHint">Введите пароль, указанный при регистрации</span>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox" id="remember" name="remember">
                    <label class="checkbox-label" for="remember">
                        Запомнить меня на этом устройстве
                    </label>
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

            <div class="divider">
                или войдите через
            </div>

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

            <div class="success-message" id="successMessage">
                <div class="success-icon">
                    <i>✓</i>
                </div>
                <div class="success-title">Вход выполнен успешно!</div>
                <div class="success-text">
                    Вы будете перенаправлены в личный кабинет через несколько секунд.
                </div>
            </div>
        </div>
    </div>
</div>