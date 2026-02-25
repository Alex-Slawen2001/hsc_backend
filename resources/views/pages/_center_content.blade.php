<div class="container">
    <div class="page-header">
        <div class="breadcrumbs">
            <a href="/">Главная</a><span class="crumb-sep">→</span>
            <span>Центры</span>
        </div>
    </div>
</div>

    <div style="margin-top: -50px;" class="hsc-site-content">
        <div class="container">
            <div class="main-content">

                <div class="page-header">
                    <h1 class="page-header__title">Авиационные учебные центры</h1>

                    <div class="view-toggle">
                        <button class="view-toggle__btn active">
                            Список
                        </button>
                        <a href="/#" class="view-toggle__btn">
                             На карте
                        </a>
                    </div>
                </div>

                <div class="training-center-list">
                    <div class="training-center-card">
                        <div class="training-center-card__content">
                            <h2 class="training-center-card__title">
                                <a href="/training/center/item-9746548">
                                    АУЦ Акционерного общества «Новосибирский авиаремонтный завод»
                                </a>
                            </h2>

                            <div class="training-center-card__description">
                                <p>Авиационный учебный центр АО «Новосибирский авиаремонтный завод» (АУЦ АО «НАРЗ») создан на базе единственного в РФ авиационного предприятия, выполняющего техническое обслуживание и ремонт всех типов и модификаций вертолетов марки «Ми».</p>
                                <p>При разработке учебных программ и методических материалов использован более чем 75-ти летний опыт эксплуатации и ремонта авиационной техники.</p>
                            </div>

                            <a href="#" class="training-center-card__link">
                                <span>Читать подробнее</span>
                                <i>→</i>
                            </a>

                            <div class="training-center-card__contacts">
                                <div class="contact-item">
                                    <div class="contact-item__icon">
                                        <i>📍</i>
                                    </div>
                                    <div class="contact-item__content">
                                        <div class="contact-item__label">Адрес</div>
                                        <div class="contact-item__value">
                                            630123, Россия, г. Новосибирск, ул. Аэропорт 2/4
                                        </div>
                                    </div>
                                </div>

                                <div class="contact-item">
                                    <div class="contact-item__icon">
                                        <i>📞</i>
                                    </div>
                                    <div class="contact-item__content">
                                        <div class="contact-item__label">Телефон</div>
                                        <div class="contact-item__value">
                                            +7 (383) 228-96-70, +7 (383) 228-96-78
                                        </div>
                                    </div>
                                </div>

                                <div class="contact-item">
                                    <div class="contact-item__icon">
                                        <i>📠</i>
                                    </div>
                                    <div class="contact-item__content">
                                        <div class="contact-item__label">Факс</div>
                                        <div class="contact-item__value">
                                            +7 (383) 200-30-19
                                        </div>
                                    </div>
                                </div>

                                <div class="contact-item">
                                    <div class="contact-item__icon">
                                        <i>✉️</i>
                                    </div>
                                    <div class="contact-item__content">
                                        <div class="contact-item__label">Email</div>
                                        <div class="contact-item__value">
                                            <a href="mailto:info@narp.ru">info@narp.ru</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewButtons = document.querySelectorAll('.view-toggle__btn');
            viewButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (this.classList.contains('view-toggle__btn')) {
                        viewButtons.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                    }
                });
            });

            const cards = document.querySelectorAll('.training-center-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.zIndex = '10';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.zIndex = '1';
                });
            });

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if(targetId !== '#') {
                        const targetElement = document.querySelector(targetId);
                        if(targetElement) {
                            window.scrollTo({
                                top: targetElement.offsetTop - 80,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });
        });
    </script>