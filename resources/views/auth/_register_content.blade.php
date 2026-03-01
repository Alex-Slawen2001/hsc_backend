<div style="margin-top: -20px;" class="container">
    <div class="page-header">
        <div class="breadcrumbs">
            <a href="/">Главная</a><span class="crumb-sep">→</span>
            <span>Регистрация</span>
        </div>
    </div>
</div>

    <div style="margin-top: -50px;" class="container">

        <div class="page-header">
            <h1>Регистрация</h1>
            <p>Создайте учетную запись для доступа ко всем услугам Вертолетной сервисной компании</p>
        </div>

        <div class="registration-container">
            <div class="registration-card">

                <div class="registration-steps">
                    <div class="step active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-label">Личные данные</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-label">Учетные данные</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-label">Подтверждение</div>
                    </div>
                </div>

                <div class="error-message" id="errorMessage">
                    Пожалуйста, исправьте ошибки в форме
                </div>

                <form id="registrationForm" method="POST" action="/register">
                    @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-section active" id="section1">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label required">Имя</label>
                                <input type="text" class="form-input" id="firstName" name="firstName" required>
                                <span class="form-hint">Введите ваше имя</span>
                            </div>
                            <div class="form-group">
                                <label class="form-label required">Фамилия</label>
                                <input type="text" class="form-input" id="lastName" name="lastName" required>
                                <span class="form-hint">Введите вашу фамилию</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Email</label>
                            <input type="email" class="form-input" id="email" name="email" required>
                            <span class="form-hint">На этот адрес будут отправляться уведомления</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Телефон</label>
                            <input type="tel" class="form-input" id="phone" name="phone" placeholder="+7 (999) 999-99-99" required>
                            <span class="form-hint">В формате +7 XXX XXX-XX-XX</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Компания</label>
                            <input type="text" class="form-input" id="company" name="company">
                            <span class="form-hint">Название вашей организации (если есть)</span>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" disabled>
                                <i>←</i> Назад
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                                Далее <i>→</i>
                            </button>
                        </div>
                    </div>

                    <div class="form-section" id="section2">
                        <div class="form-group">
                            <label class="form-label required">Логин</label>
                            <input type="text" class="form-input" id="username" name="username" required>
                            <span class="form-hint">Минимум 4 символа, только латинские буквы и цифры</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Пароль</label>
                            <input type="password" class="form-input" id="password" name="password" required>
                            <div class="password-strength">
                                <div class="password-strength-bar" id="passwordStrength"></div>
                            </div>
                            <div class="password-tips">
                                <p>Пароль должен содержать:</p>
                                <ul>
                                    <li id="lengthCheck">Минимум 8 символов</li>
                                    <li id="uppercaseCheck">Заглавную букву</li>
                                    <li id="numberCheck">Цифру</li>
                                    <li id="specialCheck">Специальный символ</li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Подтверждение пароля</label>
                            <input type="password" class="form-input" id="confirmPassword" name="confirmPassword" required>
                            <span class="form-hint" id="passwordMatch">Повторите введенный пароль</span>
                        </div>

                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox" id="newsletter" name="newsletter" checked>
                            <label class="checkbox-label">
                                Получать новости и обновления от Вертолетной сервисной компании
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="prevStep(1)">
                                <i>←</i> Назад
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                                Далее <i>→</i>
                            </button>
                        </div>
                    </div>

                    <div class="form-section" id="section3">
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox" id="terms" name="terms" required>
                            <label class="checkbox-label required">
                                Я соглашаюсь с <a href="https://www.hsc-copter.com/useragreement" target="_blank">Пользовательским соглашением</a> и даю согласие на обработку моих персональных данных в соответствии с <a href="/content/document/personal_data_ru.pdf" target="_blank">Политикой конфиденциальности</a>
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="prevStep(2)">
                                <i>←</i> Назад
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Завершить <i>✓</i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="form-section hidden" id="sectionSuccess">
                    <div class="success-message">
                        <div class="success-icon">
                            <i>✓</i>
                        </div>
                        <div class="success-title">Регистрация завершена!</div>
                        <div class="success-text">
                            На вашу электронную почту отправлено письмо с подтверждением регистрации.
                            Пожалуйста, проверьте почту и следуйте инструкциям для активации учетной записи.
                        </div>
                        <button type="button" class="btn btn-primary" onclick="location.href='/pages/login.html'">
                            Перейти к входу <i>→</i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="login-link">
                Уже есть аккаунт? <a href="/pages/login.html">Войдите в систему</a>
            </div>
        </div>

    </div>
