<?php /** @var $page_data */?>
@extends('layouts.app')

@section('content')

    <div class="wrapper">
        <div class="breadcrumbs">
            <ol itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscopeitemtype="http://schema.org/ListItem">
                    <a class="before" itemprop="item" href="/">
                        <span itemprop="name">Главная</span>
                        <meta itemprop="position" content="1">
                    </a>
                </li>
                <li itemprop="itemListElement" itemscopeitemtype="http://schema.org/ListItem">
                    <span itemprop="name">Продукция</span>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </div>
        <div class="main__page-title">
            <h1>Сравнение</h1>
        </div>

        @if ( isset($page_data['categories']) && !empty($page_data['categories']) )

            <div class="compare-categoryes">
                <!--У ссылок добавил атрибуты, которые ссылаются на табы. Ссылка ведет на класс таба. Обязательно название начинается с точки, как на примере-->
                <div class="catalog__categoryes" id="catalog__categoryes">
                    <ul>

                        @foreach ( $page_data['categories'] as $category )

                            <li><a class="before" href="#" data-for=".{{ $category['data']['slug'] }}">{{ $category['data']['name'] }}</a></li>

                        @endforeach

                    </ul>
                </div>
            </div>

            <!--Добавлены табы и в них завернуты слайдеры-->
            <?php
            /**
             * Один таб - одна категория. Табы генерить только по мере необходимости. Сначала разобраться, как вообще добавлять и считать сравнение и только потом выводить его.
             **/
            ?>
            @foreach ( $page_data['categories'] as $category )

                <div class="compare-tab {{ $category['data']['slug'] }}{{ $category['class'] }}">
                    <div class="compare-list compare-desctop">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="compare-manage before">
                                    <a href="{{ $category['data']['link'] }}" class="before add">Добавить товары <br />к сравнению</a>
                                    <button class="before clear_list" id="clear_compare">Очистить список</button>
                                </div>
                                <div class="compare-chars">
                                    <div class="compare-chars-title"> <b>Сравнение характеристик</b></div>
                                    <div class="compare-chars-check">
                                        <div class="checkbox-switch">
                                            <input type="checkbox" id="switch">
                                            <label class="before after" for="switch">Только различающиеся</label>
                                        </div>
                                    </div>
                                    <div class="compare-chars-list">
                                        <ul>
                                            <li class="before after">Код товара</li>

                                            @foreach( $category['characteristics_names'] as $item )

                                                <li class="before after">{{ $item['name'] }}</li>

                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <!--Для слайдера в каждом табе свой ID. Последняя цифра -- порядковый номер от единицы до бесконечности. Какую попало цифру ставить нельзя. Только по порядку-->
                                <div class="compare-products owl-carousel" id="compare_products_{{ $category['num'] }}">

                                    @foreach( $category['list'] as $product )

                                        <div class="compare-product-item">
                                            <div class="compare-products-item-product">

                                                {{ view('catalog.preview', ['item' => $product]) }}

                                            </div>
                                            <div class="compare-products-item-chars">
                                                <ul>
                                                    <li class="before after">{{ $product['sku'] }}</li>

                                                    @if ( !empty($product['characteristics']) )

                                                        @foreach( $product['characteristics'] as $item )

                                                            <li class="before after">{{ $item['value'] }}</li>

                                                        @endforeach

                                                    @endif

                                                </ul>
                                            </div>
                                        </div>

                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="compare-list compare-mobile">
                        <div class="row no-gutters before">
                            <div class="col-6 before">
                                <div class="compare-slider_mobile compare-slider_mobile-first owl-carousel">

                                    @foreach( $category['mobile']['first']['list'] as $product )

                                        <div class="compare-slider_mobile-item">
                                            <div class="compare-slider_mobile-item-product">

                                                {{ view('catalog.preview', ['item' => $product]) }}

                                            </div>
                                            <div class="compare-slider_mobile-item-chars">
                                                <ul>
                                                    <li class="before after">{{ $product['sku'] }}</li>

                                                    @if ( !empty($product['characteristics']) )

                                                        @foreach( $product['characteristics'] as $item )

                                                            <li class="before after">{{ $item['value'] }}</li>

                                                        @endforeach

                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="compare-slider_mobile-nums"> <span>{{ $product['num'] }}</span><span> из </span><span>{{ $category['mobile']['first']['count'] }}</span></div>
                                        </div>

                                    @endforeach

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="compare-slider_mobile compare-slider_mobile-second owl-carousel">

                                    @foreach( $category['mobile']['second']['list'] as $product )

                                        <div class="compare-slider_mobile-item">
                                            <div class="compare-slider_mobile-item-product">

                                                {{ view('catalog.preview', ['item' => $product]) }}

                                            </div>
                                            <div class="compare-slider_mobile-item-chars">
                                                <ul>
                                                    <li class="before after">{{ $product['sku'] }}</li>

                                                    @if ( !empty($product['characteristics']) )

                                                        @foreach( $product['characteristics'] as $item )

                                                            <li class="before after">{{ $item['value'] }}</li>

                                                        @endforeach

                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="compare-slider_mobile-nums"> <span>{{ $product['num'] }}</span><span> из </span><span>{{ $category['mobile']['second']['count'] }}</span></div>
                                        </div>

                                    @endforeach

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="compare-mobile-data">
                                    <div class="compare-mobile-data-title"><b>Сравнение характеристик</b></div>
                                    <div class="compare-mobile-data-check">
                                        <div class="checkbox-switch">
                                            <input type="checkbox" id="switch2">
                                            <label class="before after" for="switch2">Только различающиеся</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        @else
            <p>Ничего не добавлено к сравнению</p>
        @endif

    </div>

@endsection
