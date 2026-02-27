document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('calcModal');
    const openBtns = document.querySelectorAll('.js-open-calc');
    const closeBtns = document.querySelectorAll('.js-calc-close');
    const form = document.getElementById('calcForm');
    const formError = document.getElementById('calcFormError');

    if (!modal) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const toast = (text) => {
        const el = document.createElement('div');
        el.textContent = text;
        el.style.cssText =
            'position:fixed;right:16px;bottom:16px;z-index:99999;padding:10px 12px;border-radius:14px;' +
            'background:rgba(0,0,0,.78);border:1px solid rgba(255,255,255,.18);color:#fff;' +
            'max-width:min(360px,calc(100% - 32px));font:500 14px/1.3 Inter,system-ui,Arial';
        document.body.appendChild(el);
        setTimeout(() => el.remove(), 2200);
    };

    const open = () => {
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    const close = () => {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        clearErrors();
        if (formError) { formError.style.display = 'none'; formError.textContent = ''; }
    };

    const clearErrors = () => {
        modal.querySelectorAll('[data-error]').forEach(el => { el.textContent = ''; });
    };

    const setFieldError = (field, message) => {
        const el = modal.querySelector(`[data-error="${field}"]`);
        if (el) el.textContent = message;
    };

    openBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        open();
    }));

    closeBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        close();
    }));

    modal.addEventListener('click', (e) => {
        if (e.target === modal) close();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });

    // AJAX submit
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            clearErrors();
            if (formError) { formError.style.display = 'none'; formError.textContent = ''; }

            const submitBtn = form.querySelector('button[type="submit"]');
            const prevText = submitBtn ? submitBtn.textContent : null;
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Отправка...';
            }

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        ...(csrf ? {'X-CSRF-TOKEN': csrf} : {})
                    },
                    body: new FormData(form)
                });

                // Валидация Laravel
                if (res.status === 422) {
                    const data = await res.json().catch(() => null);

                    if (data && data.errors) {
                        Object.entries(data.errors).forEach(([field, msgs]) => {
                            const msg = Array.isArray(msgs) ? msgs[0] : String(msgs);
                            setFieldError(field, msg);
                        });
                    } else if (formError) {
                        formError.style.display = 'block';
                        formError.textContent = 'Проверьте корректность заполнения формы.';
                    }

                    return;
                }

                if (!res.ok) {
                    if (formError) {
                        formError.style.display = 'block';
                        formError.textContent = 'Ошибка отправки. Попробуйте ещё раз.';
                    } else {
                        toast('Ошибка отправки. Попробуйте ещё раз.');
                    }
                    return;
                }

                const data = await res.json().catch(() => null);
                toast(data?.message || 'Заявка отправлена!');

                form.reset();
                close();

            } catch (err) {
                if (formError) {
                    formError.style.display = 'block';
                    formError.textContent = 'Не удалось отправить. Проверьте интернет и попробуйте ещё раз.';
                } else {
                    toast('Не удалось отправить. Попробуйте ещё раз.');
                }
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    if (prevText) submitBtn.textContent = prevText;
                }
            }
        });
    }
});
