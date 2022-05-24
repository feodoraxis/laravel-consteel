@extends('layouts.app')

@section('content')

    <div class="wrapper">
        <div class="breadcrumbs">
            <ol itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscopeitemtype="http://schema.org/ListItem"><a class="before" itemprop="item" href="/"><span itemprop="name">Главная</span>
                        <meta itemprop="position" content="1"></a></li>
                <li itemprop="itemListElement" itemscopeitemtype="http://schema.org/ListItem"><span itemprop="name">Продукция</span>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </div>
        <div class="main__page-title">
            <h1>Контакты</h1>
        </div>
        <div class="contacts">
            <div class="row no-gutters">
                <div class="col-xxl-4 col-xl-5 col-md-8">
                    <div class="contacts__item contacts__item-no_borders">
                        <div class="contacts__item-header">
                            <h3>Коммерческий отдел</h3>
                            <p>Запросы B2B, заказ</p>
                        </div>
                        <div class="contacts__item-footer">
                            <div class="contacts__item-phones">
                                <div class="contacts__item-phone"><span>Бесплатно по России</span>
                                    <p> <a class="before" href="tel:8 800 350 03 27">8 800 350 03 27</a></p>
                                </div>
                                <div class="contacts__item-phone"><span>Факс</span>
                                    <p> <a class="before" href="tel:+7 4012 99 49 27">+7 4012 99 49 27</a></p>
                                </div>
                                <div class="contacts__item-phone"><span>Whatsapp, Viber</span>
                                    <p> <a class="before" href="tel:+7 909 790 49 27">+7 909 790 49 27</a></p>
                                </div>
                                <div class="contacts__item-phone"><span>Дополнительный номер</span>
                                    <p> <a class="before" href="tel:+7 963 738 77 27">+7 963 738 77 27</a></p>
                                </div>
                            </div>
                            <div class="contacts__item-email"> <a class="before" href="mailto:sale@consteel-electronics.ru">sale@consteel-electronics.ru</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-3 col-md-4 contacts-desctop">
                    <div class="contacts-bg"></div>
                </div>
                <div class="col-xl-4 col-md-6 contacts-no_mobile">
                    <div class="contacts__item">
                        <div class="contacts__item-header">
                            <p>Если у Вас есть дополнительные вопросы, Мы всегда готовы ответить на них. <br><br> Мы в Вашем распоряжении по будням с 9:00 до 18:00.</p>
                        </div>
                        <div class="contacts__item-footer">
                            <div class="to__detail"><a class="before before" href="#">Связаться с нами </a></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contacts__item">
                        <div class="contacts__item-header">
                            <h3>Бухгалтерия</h3>
                            <p>Учет, расчеты, счета-фактуры</p>
                        </div>
                        <div class="contacts__item-footer">
                            <div class="contacts__item-phones">
                                <div class="contacts__item-phone">
                                    <p> <a class="before" href="tel:+7 963 738 77 27">+7 963 738 77 27</a></p>
                                </div>
                            </div>
                            <div class="contacts__item-email"> <a class="before" href="mailto:order@consteel-electronics.ru">order@consteel-electronics.ru</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contacts__item">
                        <div class="contacts__item-header">
                            <h3>Техподдержка</h3>
                            <p>Помогаем по электронной почте</p>
                        </div>
                        <div class="contacts__item-footer">
                            <div class="contacts__item-email"> <a class="before" href="mailto:support@consteel-electronics.ru">support@consteel-electronics.ru</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contacts__item">
                        <div class="contacts__item-header">
                            <h3>Маркетинг</h3>
                            <p>Маркетинговые материалы и прочие вопросы</p>
                        </div>
                        <div class="contacts__item-footer">
                            <div class="contacts__item-phones">
                                <div class="contacts__item-phone">
                                    <p> <a class="before" href="tel:+7 963 738 77 27">+7 963 738 77 27</a></p>
                                </div>
                            </div>
                            <div class="contacts__item-email"> <a class="before" href="mailto:marketing@consteel-electronics.ru">marketing@consteel-electronics.ru</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
