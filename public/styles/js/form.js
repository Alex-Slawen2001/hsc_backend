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
            input: form?.querySelector('textarea[name="message"]'),
            error: document.getElementById('messageError')
        },
        name: {
            input: form?.querySelector('input[name="name"]'),
            error: document.getElementById('nameError')
        },
        email: {
            input: form?.querySelector('input[name="email"]'),
            error: document.getElementById('emailError')
        },
        phone: {
            input: form?.querySelector('input[name="phone"]'),
            error: document.getElementById('phoneError')
        },
        company: {
            input: form?.querySelector('input[name="company"]'),
            error: document.getElementById('companyError')
        }
    };


    document.querySelectorAll('.js-open-consult').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            clearAllErrors();
        });
    });

    document.querySelectorAll('.js-close-consult').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });


    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!validateForm()) return;

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Отправка...';
            }

            try {

                const formData = new FormData(form);

                const response = await fetch('/ajax/message/send', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Ошибка сервера');
                }

                showSuccessMessage();

                setTimeout(() => {
                    closeModal();
                    resetForm();
                }, 2500);

            } catch (error) {
                console.error(error);
                showErrorMessage('Произошла ошибка при отправке. Попробуйте позже.');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Отправить запрос';
                }
            }

        });


        Object.values(fields).forEach(field => {
            if (field.input) {

                field.input.addEventListener('blur', () => {
                    validateField(field);
                });

                field.input.addEventListener('input', () => {
                    clearFieldError(field);
                });

            }
        });
    }



    function validateForm() {

        let isValid = true;

        if (fields.message.input && !fields.message.input.value.trim()) {
            showFieldError(fields.message, 'Введите ваше сообщение');
            isValid = false;
        }

        if (fields.name.input && !fields.name.input.value.trim()) {
            showFieldError(fields.name, 'Введите ваше имя');
            isValid = false;
        }

        if (fields.email.input && fields.email.input.value.trim() && !isValidEmail(fields.email.input.value.trim())) {
            showFieldError(fields.email, 'Введите корректный email');
            isValid = false;
        }

        if (fields.phone.input && fields.phone.input.value.trim() && !isValidPhone(fields.phone.input.value.trim())) {
            showFieldError(fields.phone, 'Введите корректный номер телефона');
            isValid = false;
        }

        return isValid;
    }


    function validateField(field) {

        if (!field.input) return true;

        const value = field.input.value.trim();
        let isValid = true;

        if (field.input.name === 'message' && !value) {
            showFieldError(field, 'Введите ваше сообщение');
            isValid = false;
        }

        else if (field.input.name === 'name' && !value) {
            showFieldError(field, 'Введите ваше имя');
            isValid = false;
        }

        else if (field.input.name === 'email' && value && !isValidEmail(value)) {
            showFieldError(field, 'Введите корректный email');
            isValid = false;
        }

        else if (field.input.name === 'phone' && value && !isValidPhone(value)) {
            showFieldError(field, 'Введите корректный номер телефона');
            isValid = false;
        }

        else {
            clearFieldError(field);
        }

        return isValid;
    }


    function showFieldError(field, message) {

        clearFieldError(field);

        if (field.error) {
            field.error.textContent = message;
            field.error.style.display = 'block';
        }

        if (field.input) {
            field.input.style.borderColor = '#ff4757';
        }
    }


    function clearFieldError(field) {

        if (field.error) {
            field.error.textContent = '';
            field.error.style.display = 'none';
        }

        if (field.input) {
            field.input.style.borderColor = '';
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
    }


    function resetForm() {
        if (form) {
            form.reset();
            clearAllErrors();
        }
    }


    function showSuccessMessage() {

        const msg = document.createElement('div');

        msg.className = 'success-message';

        msg.style.cssText = `
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

        msg.innerHTML = `
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:20px;">✓</span>
                <div>
                    <div style="font-weight:600;">Заявка отправлена!</div>
                    <div style="font-size:13px;">Мы свяжемся с вами в ближайшее время</div>
                </div>
            </div>
        `;

        document.body.appendChild(msg);

        setTimeout(() => {
            msg.remove();
        }, 5000);
    }


    function showErrorMessage(message) {

        const msg = document.createElement('div');

        msg.className = 'error-message';

        msg.style.cssText = `
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

        msg.innerHTML = `
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:20px;">⚠</span>
                <div>
                    <div style="font-weight:600;">Ошибка отправки</div>
                    <div style="font-size:13px;">${message}</div>
                </div>
            </div>
        `;

        document.body.appendChild(msg);

        setTimeout(() => {
            msg.remove();
        }, 5000);
    }

});
