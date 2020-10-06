<?php require_once 'header.php'; ?>

<div class="content">
    <div class="slider_wrap_bg">
        <div class="container">
            <div class="slider">
                <div class="slide">
                    <div class="slide_content">
                        <div class="slide_content__title">
                            Бесплатная социальная карта от аптеки «Неболейка»!
                        </div>
                        <div class="slide_content__body">
                            Социальная карта дает право на получение 6% скидки на весь ассортимент аптеки и 3% на лекарства из перечня жизненно важных лекарственных препаратов (ЖНВЛП).
                        </div>
                        <div class="slide_content_btn">
                            <a href="<?= PATH ?>page/free-social-card">Подробнее</a>
                        </div>
                    </div>
                    <img src="views/img/granny.png" alt="Гарантия качества" title="Гарантия качества">
                </div>
                <div class="slide">
                    <div class="slide_content">
                        <div class="slide_content__title">
                            Накопительная дисконтная карта
                        </div>
                        <div class="slide_content__body">
                            Накопительные дисконтные и VIP карты для наших постоянных покупателей!
                        </div>
                        <div class="slide_content_btn">
                            <a href="<?= PATH ?>page/sales-to-card">Подробнее</a>
                        </div>
                    </div>
                    <img src="views/img/card_nebol_1.png" alt="Гарантия качества" title="Гарантия качества">
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="tizers">
            <div class="tizer">
                <div class="tizer__img">
                    <img src="views/img/tizer_1.png" alt="Гарантия качества" title="Гарантия качества">
                </div>
                <div class="tizer__text">
                    <div class="tizer__top-text">Гарантия качества</div>
                    <div class="tizer__desc-text">Весь товар сертифицирован</div>
                </div>
            </div>
            <div class="tizer">
                <div class="tizer__img">
                    <img src="views/img/tizer_2.png" alt="Оптимальный выбор" title="Оптимальный выбор">
                </div>
                <div class="tizer__text">
                    <div class="tizer__top-text">Оптимальный выбор</div>
                    <div class="tizer__desc-text">Низкие цены и широкий ассортимент</div>
                </div>
            </div>
            <div class="tizer">
                <div class="tizer__img">
                    <img src="views/img/tizer_3.png" alt="24 часа" title="24 часа">
                </div>
                <div class="tizer__text">
                    <div class="tizer__top-text">24 часа</div>
                    <div class="tizer__desc-text">Работаем круглосуточно</div>
                </div>
            </div>
            <div class="tizer">
                <div class="tizer__img">
                    <img src="views/img/tizer_4.png" alt="Доставка в срок" title="Доставка в срок">
                </div>
                <div class="tizer__text">
                    <div class="tizer__top-text">Доставка в срок</div>
                    <div class="desc-text"></div>
                </div>
            </div>
        </div>
        <div class="sales">
            <div class="promotions__title">
                Акции
            </div>
            <div class="promotions">
                <div class="promotion">
                    <div class="promotion__img">
                        <a href="page/free-social-card">
                            <img src="views/img/granny.png">
                        </a>
                    </div>
                    <div class="promotion__text">
                        <a href="page/free-social-card">Бесплатная социальная карта от аптеки «Неболейка»!</a>
                    </div>
                </div>
                <div class="promotion">
                    <div class="promotion__img">
                        <a href="page/sales-to-card">
                            <img src="views/img/card_nebol_1.png">
                        </a>
                    </div>
                    <div class="promotion__text">
                        <a href="page/sales-to-card">Накопительные скидки по карте!</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="about_company">
            <h2>О компании</h2>
            <p>ООО "Аптека Неболейка" основана в 2007 году и входит в группу компаний ООО "Аптека
                Неболейка Плюс" и ООО "Вита".</p>
            <p>Мы предлагаем своим покупателям широкий спектр товаров для здоровья.</p>
            <p>Предлагаемые в аптеках товары, закупаются исключительно у официальных дистрибьюторов, имеют все необходимые сертификаты и лицензии, что гарантирует их высокое качество и доступные цены. </p>
        </div>
    </div>
    <div class="map">
        <div class="contacts_map">
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A951364c0022dd80f404d5ea921325fd1b1adcb2cfcb832e065ae92357219f0ca&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=false"></script>

        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>