document.addEventListener('DOMContentLoaded', function() {

    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const usernameInput = document.getElementById('username');

    if (!loginForm) return;

    togglePassword?.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁' : '👁️‍🗨️';
    });

    function validateForm() {
        const username = usernameInput.value.trim();
        const password = passwordInput.value;

        errorMessage.classList.remove('show');

        if (!username) {
            showError('Пожалуйста, введите логин или email');
            usernameInput.classList.add('error');
            return false;
        }

        if (!password) {
            showError('Пожалуйста, введите пароль');
            passwordInput.classList.add('error');
            return false;
        }

        return true;
    }

    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.classList.add('show');
    }

    function clearErrors() {
        errorMessage.classList.remove('show');
        usernameInput.classList.remove('error');
        passwordInput.classList.remove('error');
    }

    usernameInput.addEventListener('input', clearErrors);
    passwordInput.addEventListener('input', clearErrors);

    async function postLogin() {
        const formData = new FormData(loginForm);
        const res = await fetch(loginForm.getAttribute('action') || '/login', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': window.__CSRF_TOKEN__ || ''
            },
            body: formData
        });

        const data = await res.json().catch(() => ({}));
        if (!res.ok) {
            const msg = data?.message || 'Неверный логин или пароль. Проверьте введенные данные.';
            throw new Error(msg);
        }
        return data;
    }

    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!validateForm()) return;

        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Вход... <div class="loading-spinner"></div>';

        try {
            const data = await postLogin();

            loginForm.style.display = 'none';
            document.querySelector('.login-links')?.style?.setProperty('display','none');
            document.querySelector('.social-login')?.style?.setProperty('display','none');
            document.querySelector('.divider')?.style?.setProperty('display','none');
            successMessage.classList.add('show');

            setTimeout(() => {
                window.location.href = data.redirect || '/dashboard';
            }, 700);
        } catch (error) {
            console.error('Ошибка входа:', error);
            showError(error.message || 'Произошла ошибка при входе. Пожалуйста, попробуйте позже.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Войти в систему <i>→</i>';
        }
    });

    document.getElementById('googleLogin')?.addEventListener('click', function() {
        alert('OAuth не подключён (демо)');
    });

    document.getElementById('yandexLogin')?.addEventListener('click', function() {
        alert('OAuth не подключён (демо)');
    });

    const style = document.createElement('style');
    style.textContent = `
            .loading-spinner {
                display: inline-block;
                width: 20px;
                height: 20px;
                border: 2px solid rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                border-top-color: white;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        `;
    document.head.appendChild(style);
});
