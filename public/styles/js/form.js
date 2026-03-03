document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('consultModal');

    if (!modal) {
        console.warn('consultModal not found');
        return;
    }

    const form = document.getElementById('consultForm');
    const submitBtn = form?.querySelector('.consult-submit');
    const fields = {
        message: {
            input: form?.querySelector('textarea[name="Message"]'),
            error: document.getElementById('messageError')
        },
        name: {
            input: form?.querySelector('input[name="Name"]'),
            error: document.getElementById('nameError')
        },
        email: {
            input: form?.querySelector('input[name="Email"]'),
            error: document.getElementById('emailError')
        },
        phone: {
            input: form?.querySelector('input[name="Phone"]'),
            error: document.getElementById('phoneError')
        },
        company: {
            input: form?.querySelector('input[name="Company"]'),
            error: document.getElementById('companyError')
        },
        captcha: {
            input: form?.querySelector('input[name="CaptchaCode"]'),
            error: document.getElementById('captchaError')
        }
    };

    document.querySelectorAll('.js-open-consult').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            clearAllErrors();
            // Обновляем капчу при открытии модалки
            const captchaImg = document.getElementById('captchaImage');
            if (captchaImg) {
                captchaImg.src = '/ajax/captcha/image/' + Date.now();
            }
        });
    });

    document.querySelectorAll('.js-close-consult').forEach(btn => {
        btn.addEventListener('click', () => {
            closeModal();
        });
    });

    const refreshBtn = document.getElementById('refreshCaptcha');
    const captchaImg = document.getElementById('captchaImage');

    if (refreshBtn && captchaImg) {
        refreshBtn.addEventListener('click', () => {
            captchaImg.src = '/ajax/captcha/image/' + Date.now();
            // Очищаем поле капчи при обновлении
            if (fields.captcha.input) {
                fields.captcha.input.value = '';
            }
        });
    }

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Валидация перед отправкой
            if (!validateForm()) return;

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Отправка...';
            }

            try {
                const formData = new FormData(form);

                // Для отладки - посмотрим что отправляется
                console.log('Sending data:');
                for (let [key, value] of formData.entries()) {
                    console.log(key + ': ' + value);
                }

                const success = await sendToServer(formData);

                if (success) {
                    showSuccessMessage();
                    setTimeout(() => {
                        closeModal();
                        resetForm();
                        // Обновляем капчу после успешной отправки
                        if (captchaImg) {
                            captchaImg.src = '/ajax/captcha/image/' + Date.now();
                        }
                    }, 1200);
                }
            } catch (error) {
                console.error('Ошибка отправки формы:', error);
                // Не показываем ошибку если это ошибка валидации (уже показана под полями)
                if (!error.message.includes('field is required')) {
                    showErrorMessage(error.message || 'Произошла ошибка. Пожалуйста, попробуйте позже.');
                }
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Отправить запрос';
                }
            }
        });

        Object.values(fields).forEach(field => {
            if (!field.input) return;
            field.input.addEventListener('blur', () => validateField(field));
            field.input.addEventListener('input', () => clearFieldError(field));
        });
    }

    function validateForm() {
        let isValid = true;

        // Проверяем все обязательные поля
        if (fields.message.input && !fields.message.input.value.trim()) {
            showFieldError(fields.message, 'Введите ваше сообщение');
            isValid = false;
        }

        if (fields.name.input && !fields.name.input.value.trim()) {
            showFieldError(fields.name, 'Введите ваше имя');
            isValid = false;
        }

        // Email не обязательный, но если заполнен - проверяем формат
        if (fields.email.input && fields.email.input.value.trim()) {
            if (!isValidEmail(fields.email.input.value.trim())) {
                showFieldError(fields.email, 'Введите корректный email адрес');
                isValid = false;
            }
        }

        // Phone не обязательный, но если заполнен - проверяем формат
        if (fields.phone.input && fields.phone.input.value.trim()) {
            if (!isValidPhone(fields.phone.input.value.trim())) {
                showFieldError(fields.phone, 'Введите корректный номер телефона');
                isValid = false;
            }
        }

        // Проверяем капчу если она есть
        if (fields.captcha.input && !fields.captcha.input.value.trim()) {
            showFieldError(fields.captcha, 'Введите код с картинки');
            isValid = false;
        }

        return isValid;
    }

    function validateField(field) {
        if (!field.input) return true;

        const value = field.input.value.trim();

        if (field.input.name === 'Message' && !value) {
            return showFieldError(field, 'Введите ваше сообщение');
        }

        if (field.input.name === 'Name' && !value) {
            return showFieldError(field, 'Введите ваше имя');
        }

        if (field.input.name === 'Email' && value && !isValidEmail(value)) {
            return showFieldError(field, 'Введите корректный email адрес');
        }

        if (field.input.name === 'Phone' && value && !isValidPhone(value)) {
            return showFieldError(field, 'Введите корректный номер телефона');
        }

        if (field.input.name === 'CaptchaCode' && !value) {
            return showFieldError(field, 'Введите код с картинки');
        }

        clearFieldError(field);
        return true;
    }

    function showFieldError(field, message) {
        if (field.error) {
            field.error.textContent = message;
            field.error.style.display = 'block';
        }
        if (field.input) {
            field.input.style.borderColor = '#ff4757';
            field.input.style.borderWidth = '2px';
        }
        return false;
    }

    function clearFieldError(field) {
        if (field.error) {
            field.error.textContent = '';
            field.error.style.display = 'none';
        }

        if (field.input) {
            field.input.style.borderColor = '';
            field.input.style.borderWidth = '';
        }
    }

    function clearAllErrors() {
        Object.values(fields).forEach(clearFieldError);
    }

    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function isValidPhone(phone) {
        const re = /^[\d\s\-\+\(\)]{10,}$/;
        return re.test(phone.replace(/\s/g, ''));
    }

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        resetForm();
    }

    function resetForm() {
        if (form) {
            form.reset();
            clearAllErrors();
        }
    }

    function showSuccessMessage() {
        const successMsg = document.createElement('div');
        successMsg.className = 'success-message';
        successMsg.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #00C6A7;
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;

        if (!document.querySelector('#consult-form-styles')) {
            const style = document.createElement('style');
            style.id = 'consult-form-styles';
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
                .success-message,
                .error-message {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 15px 25px;
                    border-radius: 12px;
                    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
                    z-index: 10000;
                    animation: slideIn 0.3s ease;
                }
                .success-message { background: #00C6A7; color: white; }
                .error-message { background: #ff4757; color: white; }
                #messageError, #nameError, #emailError, #phoneError, #captchaError {
                    color: #ff4757;
                    font-size: 13px;
                    margin-top: 5px;
                    padding-left: 5px;
                    min-height: 20px;
                    display: none;
                }
            `;
            document.head.appendChild(style);
        }

        successMsg.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 20px;">✓</span>
                <div>
                    <div style="font-weight: 600;">Заявка отправлена!</div>
                    <div style="font-size: 13px; opacity: 0.9;">Мы свяжемся с вами в ближайшее время</div>
                </div>
            </div>
        `;

        document.body.appendChild(successMsg);

        setTimeout(() => {
            successMsg.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => successMsg.remove(), 300);
        }, 5000);
    }

    function showErrorMessage(message) {
        const errorMsg = document.createElement('div');
        errorMsg.className = 'error-message';
        errorMsg.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ff4757;
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;

        errorMsg.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 20px;">⚠</span>
                <div>
                    <div style="font-weight: 600;">Ошибка отправки</div>
                    <div style="font-size: 13px; opacity: 0.9;">${message}</div>
                </div>
            </div>
        `;

        document.body.appendChild(errorMsg);
        setTimeout(() => {
            errorMsg.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => errorMsg.remove(), 300);
        }, 5000);
    }

    async function sendToServer(formData) {
        try {
            const res = await fetch(form.getAttribute('action') || '/ajax/message/send', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': window.__CSRF_TOKEN__ || '',
                    'Accept': 'application/json'
                },
                body: formData
            });

            let data;
            const contentType = res.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                data = await res.json();
            } else {
                data = { message: await res.text() };
            }

            if (!res.ok) {
                // Обработка ошибок валидации
                if (res.status === 422) {
                    if (data.errors) {
                        // Показываем ошибки валидации под соответствующими полями
                        Object.keys(data.errors).forEach(key => {
                            // Пробуем разные варианты имен полей
                            const fieldKey = key.toLowerCase();
                            let field = fields[fieldKey];

                            // Если не нашли по точному совпадению, пробуем другие варианты
                            if (!field) {
                                if (fieldKey === 'message' || fieldKey.includes('message')) {
                                    field = fields.message;
                                } else if (fieldKey === 'name' || fieldKey.includes('name')) {
                                    field = fields.name;
                                } else if (fieldKey === 'email' || fieldKey.includes('email')) {
                                    field = fields.email;
                                } else if (fieldKey === 'phone' || fieldKey.includes('phone')) {
                                    field = fields.phone;
                                } else if (fieldKey === 'company' || fieldKey.includes('company')) {
                                    field = fields.company;
                                } else if (fieldKey === 'captcha' || fieldKey.includes('captcha')) {
                                    field = fields.captcha;
                                }
                            }

                            if (field) {
                                showFieldError(field, data.errors[key][0]);
                            }
                        });

                        // Формируем сообщение об ошибке
                        const errorMessages = Object.values(data.errors).flat();
                        throw new Error(errorMessages.join(' '));
                    } else if (data.message) {
                        throw new Error(data.message);
                    }
                }

                throw new Error(data?.message || `Ошибка сервера: ${res.status}`);
            }

            return data.ok === true || data.success === true || res.ok;
        } catch (error) {
            console.error('Send to server error:', error);
            throw error;
        }
    }

    clearAllErrors();
});
