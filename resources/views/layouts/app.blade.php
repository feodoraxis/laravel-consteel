<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="format-detection" content="telephone=no">
        <meta name="tagline" content="https://feodoraxis.ru/">
        <meta name="author" content="Andrei Smorodin @feodoraxis">
        <meta name="theme-color" content="#FFF">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/temp.css') }}">


    </head>
    <body>
        <header class="main__header main__header-{{ $header_class }}">
            <div class="wrapper">
                <div class="main__header-first">
                    <div class="main__header-contacts">
                        <div class="main__header-contacts-item">
                            <div class="phone"><a href="tel:{{ $main_data['phone'] }}">{{ $main_data['phone'] }}</a></div>
                        </div>
                        <div class="main__header-contacts-item">
                            <div class="email"><a href="mailto:{{ $main_data['email'] }}">{{ $main_data['email'] }}</a></div>
                        </div>
                    </div>
                    <div class="main__header-shop">
                        <div class="main__header-compare">
                            <div class="compare">

                                <a href="/compare/">Сравнение @if ( $main_data['compare'] > 0 )<span>{{ $main_data['compare'] }}@endif</span></a>

                            </div>
                        </div>
                        <div class="main__header-cart">
                            <div class="mini__cart"><a href="cart.html">5 256 ₽ <span>4</span></a></div>
                        </div>
                    </div>
                </div>
                <div class="main__header-second">
                    <div class="main__header-logo">
                        <div class="logo">
                            <a href="/">
                                <img src="{{ $main_data['logo'] }}">
                            </a>
                        </div>
                    </div>

                    @if (!empty($top_menu))

                        <div class="main__header-nav">
                            <nav>
                                <ul>
                                    <li><a class="main__header-nav-catalog before" href="#"><span>Продукция</span></a></li>

                                    @foreach($top_menu as $menu)

                                        <li><a href="{{ $menu['link'] }}">{{ $menu['title'] }}</a></li>

                                    @endforeach

                                </ul>
                            </nav>
                        </div>

                    @endif

                    <div class="main__header-right">
                        <div class="main__header-search">
                            <div class="search__button" id="search_button">
                                <button></button>
                            </div>
                        </div>
                        <div class="main__header-hamburger">
                            <div class="hamburger" id="hamburger"></div>
                        </div>
                    </div>
                </div>
                <!-- Чтобы открыть результаты элементу .main__search добавить .active -->
                <div class="main__search before" id="main_search">
                    <form method="get" action="/catalog/search/">
                        <input type="text" name="search" id="main_search_input" placeholder="Что вы хотите найти?">
                    </form>
                    <div class="main__search-result" id="main__search_result">
                        <div class="main__search-categories"><b>Категории</b>
                            <div class="catalog__categoryes">
                                <ul>
                                    <li><a class="before" href="#">Лазерные сканеры</a></li>
                                    <li><a class="before" href="#">Реле</a></li>
                                    <li><a class="before" href="#">Аварийные выключатели</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="main__search-list">
                            <b>Товары</b>
                            <div id="main__search_result"></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="main__header-catalog_menu">
            <div class="catalog__menu" id="catalog__menu">
                <div class="wrapper">
                    <div class="row">
                        @foreach($catalog_menu as $menu)

                            <div class="col-md-4">
                                <ul class="catalog__menu-{{ $menu['class'] }}" id="{{ $menu['id'] }}">

                                    @foreach($menu['items'] as $item)
                                        <li><a href="{{ $item['link'] }}"

                                                @if (isset($catalog_menu[$item['id']]))
                                                    class="before" data-child="#menu_{{ $item['id'] }}"
                                                @endif

                                            >{{ $item['name'] }}</a></li>
                                    @endforeach

                                </ul>
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="mobile__menu" id="mobile__menu">
            <div class="mobile__menu-wrapper">
                <div class="mobile__menu-close"><span class="close"> </span></div>
                <div class="mobile__menu-header">
                    <div class="mobile__menu-header-flexbox">
                        <div class="mobile__menu-cart">
                            <div class="mini__cart mini__cart-popup"><a href="cart.html">5 256 ₽ </a><span>4</span></div>
                        </div>
                        <div class="mobile__menu-compare">
                            <div class="compare compare-popup"><a href="#">Сравнение </a><span>2</span></div>
                        </div>
                    </div>
                    <div class="mobile__menu-header-search">
                        <div class="search__mobile before">
                            <form>
                                <input type="search" placeholder="Поиск...">
                            </form>
                        </div>
                    </div>
                </div>

                @if (!empty($top_menu))

                    <div class="mobile__menu-body">
                        <ul>
                            <li><a class="mobile-catalog before" href="#"><span>Каталог продукции</span></a>
                            </li>

                                @foreach($top_menu as $menu)

                                    <li><a href="{{ $menu['link'] }}">{{ $menu['title'] }}</a></li>

                                @endforeach

                        </ul>
                    </div>

                @endif

                <div class="mobile__menu-footer">
                    <div class="mobile__menu-footer-phone">
                        <div class="phone phone-mobile"><a class="before" href="tel:{{ $main_data['phone'] }}">{{ $main_data['phone'] }}</a></div>
                    </div>
                    <div class="mobile__menu-footer-email">
                        <div class="email email-mobile"><a class="before" href="mailto:{{ $main_data['email'] }}">{{ $main_data['email'] }}</a></div>
                    </div>
                </div>
                <div class="mobile__menu-submenu mobile__menu-submenu-first" id="mobile_submenu_first">
                    <div class="mobile__menu-submenu-item">
                        <div class="mobile__menu-submenu-title"><b>Каталог продукции</b>
                            <button>Вернуться назад</button>
                        </div>
                        <ul>
                            @foreach($catalog_menu['0']['items'] as $item)

                                <li><a href="{{ $item['link'] }}"

                                       @if (isset($catalog_menu[ $item['id'] ]))
                                       class="before" data-child="#menu_{{ $item['id'] }}"
                                        @endif

                                    >{{ $item['name'] }}</a></li>

                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mobile__menu-submenu mobile__menu-submenu-second" id="mobile_submenu_second">
                    <div class="mobile__menu-submenu-item" id="mobile_submenu1">
                        <div class="mobile__menu-submenu-title"><b>Системы автоматизации</b>
                            <button>Вернуться назад</button>
                        </div>
                        <ul>
                            <li><a href="#">Волоконно-оптические кабели</a></li>
                            <li><a class="before" href="#" data-child="#mobile_submenu3">Волоконно-оптические патчкорды</a></li>
                            <li><a href="#">Железнодорожные кабели</a></li>
                            <li><a href="#">Кабели null modem</a></li>
                            <li><a href="#">Кабели Super Seal</a></li>
                            <li><a href="#">Кабели USB</a></li>
                            <li><a href="#">Кабели высокого напряжения</a></li>
                            <li><a href="#">Кабели для ветроэнергетики</a></li>
                            <li><a href="#">Кабели для открытых горных работ</a></li>
                            <li><a href="#">Судовые кабели</a></li>
                            <li><a href="#">Телекоммуникационные кабели</a></li>
                            <li><a href="#">Электроэнергетические кабели</a></li>
                        </ul>
                    </div>
                    <div class="mobile__menu-submenu-item" id="mobile_submenu2">
                        <div class="mobile__menu-submenu-title"><b>Кабели и провода</b>
                            <button>Вернуться назад</button>
                        </div>
                        <ul>
                            <li><a href="#">Судовые кабели</a></li>
                            <li><a href="#">Телекоммуникационные кабели</a></li>
                            <li><a href="#">Электроэнергетические кабели</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mobile__menu-submenu mobile__menu-submenu-thirth" id="mobile_submenu_thirth">
                    <div class="mobile__menu-submenu-item" id="mobile_submenu3">
                        <div class="mobile__menu-submenu-title"><b>Системы автоматизации</b>
                            <button>Вернуться назад</button>
                        </div>
                        <ul>
                            <li><a href="#">Многомодовое волоконно</a></li>
                            <li><a href="#">Одномодовое волоконно</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="{{ $main_class }}">
            @yield('content')
            <br>
        </main>

        @if ( isset($page_data['filter']) && !empty($page_data['filter']) )

            <form id="global_filter" method="get" data-category="{{ $page_data['category_id'] }}" data-csrf="{{ $page_data['csrf'] }}" action="/ajax/filter/">

                <div class="filter__modal" data-type="diapason" id="filter_price">
                    <div class="filter__modal-close"> <span class="close"></span></div>
                    <div class="filter__modal-header">
                        <div class="wrapper">
                            <div class="filter__modal-title"> <b>Цена</b></div>
                        </div>
                    </div>
                    <div class="filter__modal-body">
                        <div class="wrapper">
                            <div id="slider-range"></div>
                            <div class="filter__modal-price">
                                <div class="filter__modal-price-item filter__modal-price-from before"> <span>от</span>
                                    <input type="text" name="filter[price][from]" value="" id="from">
                                </div>
                                <div class="filter__modal-price-item filter__modal-price-to before"> <span>до</span>
                                    <input type="text" name="filter[price][to]"   value="" id="to">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter__modal-footer">
                        <div class="row no-gutters">
                            <div class="col-6">
                                <button class="button button-red button-filter"> <span>Применить</span></button>
                            </div>
                            <div class="col-6">
                                <button class="button button-white button-reset"> <span>Сбросить</span></button>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($page_data['filter'] as $filter )

                    <div class="filter__modal" data-type="items" id="filter_{{ $filter['slug'] }}">
                        <div class="filter__modal-close"> <span class="close"></span></div>
                        <div class="filter__modal-header">
                            <div class="wrapper">
                                <div class="filter__modal-title"> <b>{{ $filter['name'] }}</b></div>
                            </div>
                        </div>
                        <div class="filter__modal-body">
                            <div class="wrapper">
                                <div class="row">

                                    @foreach( $filter['values'] as $key => $value )

                                        <div class="col-md-4">
                                            <div class="filter__modal-item">
                                                <div class="checkbox checkbox-right">
                                                    <input type="checkbox" name="filter[{{ $filter['id'] }}][]" value="{{ $value['name'] }}"{{ $value['checked'] }} id="filter__modal-{{ $filter['slug'] }}-{{ $key + 1 }}">
                                                    <label class="before" for="filter__modal-{{ $filter['slug'] }}-{{ $key + 1 }}">{{ $value['name'] }} {{$filter['unit']}}</label>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="filter__modal-footer">
                            <div class="row no-gutters">
                                <div class="col-6">
                                    <button class="button button-red button-filter"> <span>Применить</span></button>
                                </div>
                                <div class="col-6">
                                    <button class="button button-white button-reset"> <span>Сбросить</span></button>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

            </form>

        @endif

        <footer class="main__footer after">
            <div class="wrapper">
                <div class="main__footer-phone">
                    <div class="footer__phone"><small>Бесплатно по России</small><a href="tel:{{ $main_data['phone'] }}">{{ $main_data['phone'] }}</a></div>
                </div>
                <div class="main__footer-email">
                    <div class="footer__email">
                        <div class="footer__email-select"><span class="first">Коммерческий отдел</span><span class="before checker active_first"></span><span class="second">Техническая поддержка</span></div>
                        <div class="footer__email-address"><small>Коммерческий отдел</small><a class="first active" href="mailto:{{ $main_data['email'] }}">{{ $main_data['email'] }}</a><small>Техническая поддержка</small><a class="second" href="mailto:{{ $main_data['email-support'] }}">{{ $main_data['email-support'] }}</a></div>
                    </div>
                </div>
                <div class="main__footer-nav">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="footer__nav">
                                <ul>
                                    <li> <a class="before">Системы автоматизации</a>
                                        <ul>
                                            <li><a href="#">Панельные компьютеры</a>
                                            </li>
                                            <li><a href="#">Промышленные компьютеры</a>
                                            </li>
                                            <li><a href="#">Беспроводная связь</a>
                                            </li>
                                            <li><a href="#">Промышленная коммуникация</a>
                                            </li>
                                            <li><a href="#">Конвертеры и шлюзы</a>
                                            </li>
                                            <li><a href="#">Модули ввода/вывода</a>
                                            </li>
                                            <li><a href="#">Сенсорные мониторы</a>
                                            </li>
                                            <li><a href="#">HMI. панели оператора</a>
                                            </li>
                                            <li><a href="#">Контроллеры</a>
                                            </li>
                                            <li><a href="#">Сепараторы/ретрансляторы</a>
                                            </li>
                                            <li><a href="#">Сетевой оборудование</a>
                                            </li>
                                            <li><a href="#">Источники питания</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="footer__nav">
                                <ul>
                                    <li> <a>Кабели и провода</a></li>
                                </ul>
                            </div>
                            <div class="footer__nav">
                                <ul>
                                    <li> <a class="before">Безопасность машин</a>
                                        <ul>
                                            <li><a href="#">Лазерные сканеры безопасности</a>
                                            </li>
                                            <li><a href="#">Реле</a>
                                            </li>
                                            <li><a href="#">Аварийные выключатели</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="footer__nav footer__nav-last">
                                <ul>
                                    <li><a href="#">О компании</a>
                                    </li>
                                    <li><a href="#">Решения</a>
                                    </li>
                                    <li><a href="#">Бренды</a>
                                    </li>
                                    <li><a href="#">Сервис и поддержка</a>
                                    </li>
                                    <li><a href="#">Документация</a>
                                    </li>
                                    <li><a href="#">Контакты</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row main__footer-row_bottom">
                    <div class="col-lg-6 col-md-8">
                        <div class="main__footer-copyright">
                            <p>2020 &copy; OOO "КОНСТИЛ ЭЛЕКТРОНИКС РУС" (CONSTEEL Electronics RUS).</p>
                            <ul>
                                <li><a>Политика конфиденциальности</a></li>
                                <li> <a>Пользовательского соглашение</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-md-4">
                        <div class="main__footer-nds">
                            <div class="show__nds" id="show__nds">
                                <p>Показывать цены:</p>
                                <ul>
                                    <li class="show__nds-text">с НДС</li>
                                    <li class="show__nds-selecter show__nds-selecter-left before"></li>
                                    <li class="show__nds-text">без НДС</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--Новое. Высплывашка для конфигуратора у детальной товара -->
        <div class="modal single_configuration" id="single_configuration">
            <div class="modal-close"> <span class="close"></span></div>
            <div class="modal-flexbox">
                <div class="modal-window">
                    <div class="wrapper single_configuration-wrapper">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="single_configuration-left">
                                    <div class="single_configuration-header">
                                        <h2>HYGIELOCK KL3-SS</h2>
                                        <div class="single_configuration-subtitle">
                                            <p>Выберите доступные опции для модели.</p>
                                        </div>
                                    </div>
                                    <div class="single_configuration-body">
                                        <div class="single_configuration-item"><b>Блок питания</b>
                                            <div class="single_configuration-line">
                                                <div class="radio">
                                                    <input type="radio" id="block_1">
                                                    <label class="before after" for="block_1">100~240VAC</label>
                                                </div>
                                                <p>+ 9 928 ₽</p>
                                            </div>
                                            <div class="single_configuration-line">
                                                <div class="radio">
                                                    <input type="radio" id="block_2">
                                                    <label class="before after" for="block_2">9~36VDC</label>
                                                </div>
                                                <p>+ 9 928 ₽</p>
                                            </div>
                                        </div>
                                        <div class="single_configuration-item"><b>RAM</b>
                                            <div class="single_configuration-line">
                                                <div class="radio">
                                                    <input type="radio" id="ram_1">
                                                    <label class="before after" for="ram_1">100~240VAC</label>
                                                </div>
                                                <p>+ 9 928 ₽</p>
                                            </div>
                                            <div class="single_configuration-line">
                                                <div class="radio">
                                                    <input type="radio" id="ram_2">
                                                    <label class="before after" for="ram_2">9~36VDC</label>
                                                </div>
                                                <p>+ 9 928 ₽</p>
                                            </div>
                                        </div>
                                        <div class="single_configuration-item"><b>HDD</b>
                                            <div class="single_configuration-line">
                                                <div class="radio">
                                                    <input type="radio" id="hdd_1">
                                                    <label class="before after" for="hdd_1">100~240VAC</label>
                                                </div>
                                                <p>+ 9 928 ₽</p>
                                            </div>
                                            <div class="single_configuration-line">
                                                <div class="radio">
                                                    <input type="radio" id="hdd_2">
                                                    <label class="before after" for="hdd_2">9~36VDC</label>
                                                </div>
                                                <p>+ 9 928 ₽</p>
                                            </div>
                                            <div class="single_configuration-line">
                                                <div class="radio">
                                                    <input type="radio" id="hdd_3">
                                                    <label class="before after" for="hdd_3">9~36VDC</label>
                                                </div>
                                                <p>+ 9 928 ₽</p>
                                            </div>
                                        </div>
                                        <div class="single_configuration-item"><b>OS</b>
                                            <div class="single_configuration-line">
                                                <div class="radio">
                                                    <input type="radio" id="os_1">
                                                    <label class="before after" for="os_1">100~240VAC</label>
                                                </div>
                                                <p>+ 9 928 ₽</p>
                                            </div>
                                            <div class="single_configuration-line">
                                                <div class="radio">
                                                    <input type="radio" id="os_2">
                                                    <label class="before after" for="os_2">9~36VDC</label>
                                                </div>
                                                <p>+ 9 928 ₽</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 single_configuration-container_right">
                                <div class="single_configuration-right">
                                    <div class="single_configuration-thumbnail">
                                        <picture>
                                            <source srcset="img/product/1.webp" loading="lazy" type="image/webp"><img src="img/product/1.jpg" loading="lazy" type="image/webp">
                                        </picture>
                                    </div>
                                    <div class="single_configuration-bottom">
                                        <div class="single_configuration-price"> <span>611 105 ₽</span></div>
                                        <div class="single_configuration-button">
                                            <button class="button button-red button-configuration_detail"><span class="button-configuration_detail-icon"></span><span class="button-configuration_detail-text">Подтвердить конфиграцию</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--Новое (конец)-->
        <div class="modal">
            <div class="modal-close"> <span class="close"></span></div>
            <div class="modal-flexbox">
                <div class="modal-window">
                    <div class="modal-header modal-header-more_padding">
                        <div class="modal-result before">
                            <h2>ваша заявка отправлена!</h2>
                            <p>В ближайшее время мы свяжемся с вами.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="help_choice_modal">
            <div class="modal-close"> <span class="close"></span></div>
            <div class="modal-flexbox">
                <div class="modal-window">
                    <div class="modal-header">
                        <h2>Нужна помощь с выбором?</h2>
                        <p>Оставьте заявку и мы постараемся помочь вам в ближайшее время.</p>
                    </div>
                    <div class="modal-body">
                        <div class="modal-form">
                            <div class="modal-form-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input__group input__group-required">
                                            <input type="text" placeholder="">
                                            <p class="placeholder">Представьтесь <span>*</span></p>
                                        </div>
                                        <div class="input__group input__group-required">
                                            <input type="text" placeholder="">
                                            <p class="placeholder">Электронная почта <span>*</span></p><span>Укажите почту</span>
                                        </div>
                                        <div class="input__group input__group-required">
                                            <input type="tel" placeholder="">
                                            <p class="placeholder">Телефон <span>*</span></p><span>Введите номер</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input__group input__group-textarea">
                                            <textarea></textarea>
                                            <p class="placeholder">Комментарии</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-form-footer">
                                <div class="modal-form-footer-column">
                                    <div class="checkbox">
                                        <input type="checkbox">
                                        <label class="before">Я согласен на обработку персональных данных</label>
                                    </div>
                                </div>
                                <div class="modal-form-footer-column">
                                    <button class="button button-red button-checkout"> <span>Отправить</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/libs.min.js') }}" defer></script>
        <script src="{{ asset('js/common.js') }}" defer></script>
        <script src="{{ asset('js/web.js') }}" defer></script>
    </body>
</html>
