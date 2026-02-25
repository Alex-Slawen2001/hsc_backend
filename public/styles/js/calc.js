document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('promoModal');
    if (!modal) return;

    const form = document.getElementById('promoForm');
    const submitBtn = form?.querySelector('button[type="submit"]');

    const openBtns = document.querySelectorAll('.js-open-promo');
    const closeBtns = document.querySelectorAll('.js-close-promo');

    const fields = {
        name: {
            input: form?.querySelector('input[name="Name"]'),
            error: document.getElementById('promoNameError')
        },
        phone: {
            input: form?.querySelector('input[name="Phone"]'),
            error: document.getElementById('promoPhoneError')
        },
        email: {
            input: form?.querySelector('input[name="Email"]'),
            error: document.getElementById('promoEmailError')
        },
        model: {
            input: form?.querySelector('input[name="Model"]'),
            error: document.getElementById('promoModelError')
        },
        message: {
            input: form?.querySelector('textarea[name="Message"]'),
            error: document.getElementById('promoMessageError')
        }
    };

    function openModal() {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        clearAllErrors();
    }

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        resetForm();
    }

    openBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
    });

    closeBtns.forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });

    const calcBase = document.getElementById('calcBase');
    const calcExtra = document.getElementById('calcExtra');
    const calcDiscount = document.getElementById('calcDiscount');
    const calcTotal = document.getElementById('calcTotal');

    function formatRub(n) {
        return n.toLocaleString('ru-RU') + ' ₽';
    }

    function recalc() {
        const base = parseInt(calcBase?.value || '0', 10) || 0;
        const extra = parseInt(calcExtra?.value || '0', 10) || 0;

        const sum = base + extra;
        const discount = Math.round(sum * 0.15);
        const total = sum - discount;

        if (calcDiscount) calcDiscount.textContent = sum ? ('−' + formatRub(discount)) : '—';
        if (calcTotal) calcTotal.textContent = sum ? formatRub(total) : '—';
    }

    [calcBase, calcExtra].forEach(el => {
        if (!el) return;
        el.addEventListener('input', recalc);
        el.addEventListener('change', recalc);
    });

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function isValidPhone(phone) {
        return /^[\d\s\-\+\(\)]{10,}$/.test(phone.replace(/\s/g, ''));
    }

    function showFieldError(field, message) {
        clearFieldError(field);
        if (field.error) {
            field.error.textContent = message;
            field.error.style.display = 'block';
        }
        if (field.input) {
            field.input.style.borderColor = '#ff4757';
            field.input.style.borderWidth = '2px';
        }
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

    function validateForm() {
        let ok = true;

        if (fields.name.input && !fields.name.input.value.trim()) {
            showFieldError(fields.name, 'Введите ваше имя');
            ok = false;
        }

        if (fields.phone.input && !fields.phone.input.value.trim()) {
            showFieldError(fields.phone, 'Введите телефон');
            ok = false;
        } else if (fields.phone.input && !isValidPhone(fields.phone.input.value.trim())) {
            showFieldError(fields.phone, 'Введите корректный номер телефона');
            ok = false;
        }

        if (fields.email.input && fields.email.input.value.trim() && !isValidEmail(fields.email.input.value.trim())) {
            showFieldError(fields.email, 'Введите корректный email');
            ok = false;
        }

        return ok;
    }

    Object.values(fields).forEach(field => {
        if (!field.input) return;
        field.input.addEventListener('input', () => clearFieldError(field));
        field.input.addEventListener('blur', () => {
            if (field === fields.name && !field.input.value.trim()) showFieldError(field, 'Введите ваше имя');
            else if (field === fields.phone && !field.input.value.trim()) showFieldError(field, 'Введите телефон');
            else if (field === fields.phone && field.input.value.trim() && !isValidPhone(field.input.value.trim())) showFieldError(field, 'Введите корректный номер телефона');
            else if (field === fields.email && field.input.value.trim() && !isValidEmail(field.input.value.trim())) showFieldError(field, 'Введите корректный email');
            else clearFieldError(field);
        });
    });

    function ensureToastStyles() {
        if (document.getElementById('promo-toast-styles')) return;
        const style = document.createElement('style');
        style.id = 'promo-toast-styles';
        style.textContent = `
            @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
            @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
            .promo-toast {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 25px;
                border-radius: 12px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.3);
                z-index: 10001;
                animation: slideIn 0.3s ease;
                color: #fff;
            }
            .promo-toast.success { background: #00C6A7; }
            .promo-toast.error { background: #ff4757; }
        `;
        document.head.appendChild(style);
    }

    function showSuccessMessage() {
        ensureToastStyles();
        const toast = document.createElement('div');
        toast.className = 'promo-toast success';
        toast.innerHTML = `
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:20px;">✓</span>
                <div>
                    <div style="font-weight:600;">Заявка отправлена!</div>
                    <div style="font-size:13px;opacity:.9;">Скидка 15% закреплена</div>
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    function showErrorMessage(message) {
        ensureToastStyles();
        const toast = document.createElement('div');
        toast.className = 'promo-toast error';
        toast.innerHTML = `
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:20px;">⚠</span>
                <div>
                    <div style="font-weight:600;">Ошибка</div>
                    <div style="font-size:13px;opacity:.9;">${message}</div>
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    function resetForm() {
        if (!form) return;
        form.reset();
        clearAllErrors();
        recalc();
    }

    async function sendToServer(formData) {
        const base = parseInt(calcBase?.value || '0', 10) || 0;
        const extra = parseInt(calcExtra?.value || '0', 10) || 0;
        formData.set('Base', String(base));
        formData.set('Extra', String(extra));

        const res = await fetch('/ajax/promo/send', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': window.__CSRF_TOKEN__ || ''
            },
            body: formData
        });

        if (!res.ok) {
            const data = await res.json().catch(() => ({}));
            throw new Error(data?.message || 'Ошибка сервера');
        }

        const data = await res.json().catch(() => ({}));
        return !!data.ok;
    }

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearAllErrors();

            if (!validateForm()) return;

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Отправка...';
            }

            try {
                const formData = new FormData(form);
                const ok = await sendToServer(formData);

                if (ok) {
                    showSuccessMessage();
                    setTimeout(closeModal, 1200);
                } else {
                    showErrorMessage('Не удалось отправить. Попробуйте ещё раз.');
                }
            } catch (err) {
                showErrorMessage(err.message || 'Произошла ошибка. Попробуйте позже.');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Зафиксировать скидку';
                }
            }
        });
    }

    recalc();
});
