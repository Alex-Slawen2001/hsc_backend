document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('consultModal');

    if (!modal) {
        console.warn('consultModal not found');
        return;
    }

    const form = document.getElementById('consultForm');
    const submitBtn = form?.querySelector('.consult-submit');

    document.querySelectorAll('.js-open-consult').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
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
        });
    }

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Отправка...';
            }

            try {
                const formData = new FormData(form);

                const res = await fetch(form.getAttribute('action') || '/ajax/message/send', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': window.__CSRF_TOKEN__ || ''
                    },
                    body: formData
                });

                if (res.ok) {
                    showSuccessMessage();
                    setTimeout(() => {
                        closeModal();
                        form.reset();
                        if (captchaImg) {
                            captchaImg.src = '/ajax/captcha/image/' + Date.now();
                        }
                    }, 1200);
                } else {
                    const data = await res.json().catch(() => ({}));
                    showErrorMessage(data?.message || 'Ошибка при отправке');
                }
            } catch (error) {
                console.error('Ошибка:', error);
                showErrorMessage('Произошла ошибка при отправке');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Отправить запрос';
                }
            }
        });
    }

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        if (form) form.reset();
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
        msg.innerHTML = 'Заявка отправлена!';
        document.body.appendChild(msg);
        setTimeout(() => msg.remove(), 3000);
    }

    function showErrorMessage(text) {
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
        msg.innerHTML = text;
        document.body.appendChild(msg);
        setTimeout(() => msg.remove(), 3000);
    }

    // Добавляем стили для анимации
    if (!document.querySelector('#consult-form-styles')) {
        const style = document.createElement('style');
        style.id = 'consult-form-styles';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
});
