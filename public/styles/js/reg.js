let currentStep = 1;
const totalSteps = 3;

function updateSteps() {
    document.querySelectorAll('.step').forEach(step => {
        const stepNum = parseInt(step.dataset.step);
        step.classList.remove('active', 'completed');

        if (stepNum < currentStep) {
            step.classList.add('completed');
        } else if (stepNum === currentStep) {
            step.classList.add('active');
        }
    });
}

function showSection(sectionNumber) {
    document.querySelectorAll('.form-section').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(`section${sectionNumber}`)?.classList.add('active');
}

function validateStep(step) {
    const errorMessage = document.getElementById('errorMessage');
    if (!errorMessage) return true;
    errorMessage.classList.remove('show');

    if (step === 1) {
        const firstName = document.getElementById('firstName').value.trim();
        const lastName = document.getElementById('lastName').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();

        if (!firstName || !lastName || !email || !phone) {
            errorMessage.textContent = 'Пожалуйста, заполните все обязательные поля';
            errorMessage.classList.add('show');
            return false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errorMessage.textContent = 'Пожалуйста, введите корректный email адрес';
            errorMessage.classList.add('show');
            document.getElementById('email').classList.add('error');
            return false;
        }

        const phoneRegex = /^\+7\s?\(?\d{3}\)?\s?\d{3}[\s-]?\d{2}[\s-]?\d{2}$/;
        if (!phoneRegex.test(phone)) {
            errorMessage.textContent = 'Пожалуйста, введите корректный номер телефона';
            errorMessage.classList.add('show');
            document.getElementById('phone').classList.add('error');
            return false;
        }
    }

    if (step === 2) {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (!username || !password || !confirmPassword) {
            errorMessage.textContent = 'Пожалуйста, заполните все обязательные поля';
            errorMessage.classList.add('show');
            return false;
        }

        if (username.length < 4) {
            errorMessage.textContent = 'Логин должен содержать минимум 4 символа';
            errorMessage.classList.add('show');
            document.getElementById('username').classList.add('error');
            return false;
        }

        const usernameRegex = /^[a-zA-Z0-9]+$/;
        if (!usernameRegex.test(username)) {
            errorMessage.textContent = 'Логин может содержать только латинские буквы и цифры';
            errorMessage.classList.add('show');
            document.getElementById('username').classList.add('error');
            return false;
        }

        if (password !== confirmPassword) {
            errorMessage.textContent = 'Пароли не совпадают';
            errorMessage.classList.add('show');
            document.getElementById('confirmPassword').classList.add('error');
            return false;
        }

        const passwordStrength = checkPasswordStrength(password);
        if (passwordStrength === 'weak') {
            errorMessage.textContent = 'Пароль слишком слабый. Усильте его согласно требованиям';
            errorMessage.classList.add('show');
            return false;
        }
    }

    if (step === 3) {
        const terms = document.getElementById('terms').checked;
        if (!terms) {
            errorMessage.textContent = 'Необходимо согласиться с условиями регистрации';
            errorMessage.classList.add('show');
            return false;
        }
    }

    return true;
}

function nextStep(next) {
    if (validateStep(currentStep)) {
        currentStep = next;
        updateSteps();
        showSection(currentStep);
    }
}

function prevStep(prev) {
    currentStep = prev;
    updateSteps();
    showSection(currentStep);
}

function checkPasswordStrength(password) {
    let strength = 0;
    const tips = document.querySelectorAll('.password-tips li');

    if (password.length >= 8) {
        strength++;
        tips[0] && (tips[0].style.color = '#00C6A7');
    } else {
        tips[0] && (tips[0].style.color = '#FF4757');
    }

    if (/[A-Z]/.test(password)) {
        strength++;
        tips[1] && (tips[1].style.color = '#00C6A7');
    } else {
        tips[1] && (tips[1].style.color = '#FF4757');
    }

    if (/[0-9]/.test(password)) {
        strength++;
        tips[2] && (tips[2].style.color = '#00C6A7');
    } else {
        tips[2] && (tips[2].style.color = '#FF4757');
    }

    if (/[^A-Za-z0-9]/.test(password)) {
        strength++;
        tips[3] && (tips[3].style.color = '#00C6A7');
    } else {
        tips[3] && (tips[3].style.color = '#FF4757');
    }

    const strengthBar = document.getElementById('passwordStrength');
    let strengthClass = 'weak';

    if (strength === 1) strengthClass = 'weak';
    else if (strength === 2) strengthClass = 'fair';
    else if (strength === 3) strengthClass = 'good';
    else if (strength >= 4) strengthClass = 'strong';

    if (strengthBar) strengthBar.className = 'password-strength-bar ' + strengthClass;

    return strengthClass;
}

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const matchHint = document.getElementById('passwordMatch');

    if (!matchHint) return;

    if (confirmPassword === '') {
        matchHint.textContent = 'Повторите введенный пароль';
        matchHint.className = 'form-hint';
    } else if (password === confirmPassword) {
        matchHint.textContent = 'Пароли совпадают';
        matchHint.className = 'form-hint';
    } else {
        matchHint.textContent = 'Пароли не совпадают';
        matchHint.className = 'form-hint error';
    }
}

async function postRegister(form) {
    const formData = new FormData(form);

    const res = await fetch(form.getAttribute('action') || '/register', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': window.__CSRF_TOKEN__ || ''
        },
        body: formData
    });

    const data = await res.json().catch(() => ({}));
    if (!res.ok) {
        const msg = data?.message || 'Не удалось зарегистрироваться. Проверьте данные.';
        throw new Error(msg);
    }
    return data;
}

document.addEventListener('DOMContentLoaded', function() {
    updateSteps();

    document.getElementById('password')?.addEventListener('input', function() {
        checkPasswordStrength(this.value);
        checkPasswordMatch();
    });

    document.getElementById('confirmPassword')?.addEventListener('input', checkPasswordMatch);

    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('error');
        });
    });

    const form = document.getElementById('registrationForm');
    if (!form) return;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!validateStep(3)) return;

        try {
            const data = await postRegister(form);

            // Показ успеха (как в исходнике)
            document.querySelector('.form-section.active')?.classList.remove('active');
            const success = document.getElementById('sectionSuccess');
            if (success) {
                success.classList.remove('hidden');
                success.classList.add('active');
            }

            setTimeout(() => {
                window.location.href = data.redirect || '/dashboard';
            }, 700);
        } catch (err) {
            const errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                errorMessage.textContent = err.message || 'Ошибка регистрации.';
                errorMessage.classList.add('show');
            }
        }
    });
});
