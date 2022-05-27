<?php /** @var $page_data */?>
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
            <h1>{{ $page_data['name'] }}</h1>
        </div>
        <div class="product-compare before">
            <button>Добавить к сравнению</button>
        </div>
        <div class="product-data">
            <div class="row">
                <div class="col-lg-5">
                    <div class="product-thumbnail">
                        <div class="product-thumbnail-desctop">
                            <div class="fotorama" data-nav="thumbs" data-thumbwidth="80" data-thumbheight="80" data-thumbmargin="12" data-arrows="false" data-click="false" data-swipe="false">


                                <a class="fancybox" href="{{ $page_data['thumbnail_detail']['link'] }}" data-img="{{ $page_data['thumbnail_detail']['link'] }}">
                                    <picture>
{{--                                        <source srcset="img/product/1.webp" loading="lazy" type="image/webp">--}}
                                        <img src="{{ $page_data['thumbnail_detail']['link'] }}" original-src="{{ $page_data['thumbnail_detail']['link'] }}" loading="lazy" type="image/webp">
                                    </picture>
                                </a>

                                @if ( !empty($page_data['gallery']) )

                                    @foreach( $page_data['gallery'] as $gallery )

                                        <a class="fancybox" href="{{ $gallery['link'] }}" data-img="{{ $gallery['link'] }}">
                                            <picture>
                                                <img src="{{ $gallery['link'] }}" original-src="{{ $gallery['link'] }}" loading="lazy" type="image/webp">
                                            </picture>
                                        </a>

                                    @endforeach

                                @endif

                            </div>
                        </div>
                        <div class="product-thumbnail-mobile">
                            <div class="owl-carousel" id="product_thumbnails_mobile">
                                <div class="item">
                                    <picture>
                                        <img src="{{ $page_data['thumbnail_detail']['link'] }}" original-src="{{ $page_data['thumbnail_detail']['link'] }}" loading="lazy" type="image/webp">
                                    </picture>
                                </div>

                                @if ( !empty($page_data['gallery']) )

                                    @foreach( $page_data['gallery'] as $gallery )

                                        <div class="item">
                                            <picture>
                                                <img src="{{ $gallery['link'] }}" original-src="{{ $gallery['link'] }}" loading="lazy" type="image/webp">
                                            </picture>
                                        </div>

                                    @endforeach

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="product-first">
                        <div class="product-first-top">
                            <div class="product-meta">
                                <ul>
                                    @if ( isset($page_data['sku']) && !empty($page_data['sku']) )
                                        <li>Код товара: {{ $page_data['sku'] }}</li>
                                    @endif

                                    @if ( isset($page_data['brand']) )
                                        <li>{{ $page_data['brand']['name'] }}: {{ $page_data['brand']['value'] }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="product-desctipion">
                                <p>{{ $page_data['description'] }}</p>
                            </div>
                        </div>
                        <div class="product-first-bottom">

                            @if ( $page_data['quantity'] > 0 )
                                <div class="in__stock before in__stock-true"> <span>В наличии</span></div>
                            @else
                                <div class="in__stock before in__stock-false"> <span>Нет в наличии</span></div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="product-second">
                        <div class="product-price">

                            @if ( isset( $page_data['price_discount']['html'] ) && $page_data['price_discount']['integer'] > 0 )
                                <div class="product-price-old"> <span>{!! $page_data['price']['html'] !!}</span></div>
                                <div class="product-price-regular"> <span>{!! $page_data['price_discount']['html'] !!}</span></div>
                            @else
                                <div class="product-price-regular"> <span>{!! $page_data['price']['html'] !!}</span></div>
                            @endif
                        </div>
                        <div class="product-length">
                            <div class="length__math length__math-big">
                                <span class="length__math-plus"></span>
                                <input type="text" value="1">
                                <span class="length__math-minus"></span>
                            </div>
                        </div>
                        <div class="product-button">
                            <button class="button button-red button-add_to_cart_detail">
                                <span class="button-add_to_cart_detail-icon"></span>
                                <span class="button-add_to_cart_detail-text">Добавить в корзину</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-bottom_description">
            <div class="row">
                <div class="col-md-4">
                    <div class="product-bottom_description-left">
                        <div class="product-tabs">
                            <ul>
                                <li class="active" for="#tab_description"> <span class="before">Описание</span></li>
                                @if ( !empty( $page_data['characteristics'] ) )
                                    <li for="#tab_chars"> <span class="before">Характеристики</span></li>
                                @endif
                                <li for="#tab_docs"> <span class="before">Документация</span></li>
                            </ul>
                        </div>
                        <div class="product-help">
                            <div class="to__detail"><a class="before" href="#" id="help_choice_button">Помощь с выбором </a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 offset-md-1">
                    <div class="product__tab active" id="tab_description">{!! $page_data['description_detail'] !!}</div>

                    @if ( !empty( $page_data['characteristics'] ) && is_array($page_data['characteristics']) )

                        <div class="product__tab" id="tab_chars">
                            <h3>Основные характеристики</h3>
                            <div class="product__chars">
                                <ul>

                                    @foreach( $page_data['characteristics'] as $item)

                                        <li class="before"> <span>{{ $item['name'] }}</span><span>{{ $item['value'] }} {{ $item['unit'] }}</span></li>

                                    @endforeach

                                </ul>
                            </div>
                        </div>

                    @endif

                    <div class="product__tab" id="tab_docs">
                        <div class="docs-list">
                            <div class="docs-item">
                                <div class="docs-item-title before"> <b>Datasheet</b></div>
                                <div class="docs-item-meta">
                                    <ul>
                                        <li>PDF                </li>
                                        <li>612 КБ</li>
                                    </ul>
                                </div>
                                <div class="docs-item-action">
                                    <div class="to__detail"><a class="before" href="#">Скачать</a></div>
                                </div>
                            </div>
                            <div class="docs-item">
                                <div class="docs-item-title before"> <b>Чертеж для AutoCAD 2D</b></div>
                                <div class="docs-item-meta">
                                    <ul>
                                        <li>PDF                </li>
                                        <li>612 КБ</li>
                                    </ul>
                                </div>
                                <div class="docs-item-action">
                                    <div class="to__detail"><a class="before" href="#">Скачать</a></div>
                                </div>
                            </div>
                            <div class="docs-item">
                                <div class="docs-item-title before"> <b>3D-модель</b></div>
                                <div class="docs-item-meta">
                                    <ul>
                                        <li>PDF                </li>
                                        <li>612 КБ</li>
                                    </ul>
                                </div>
                                <div class="docs-item-action">
                                    <div class="to__detail"><a class="before" href="#">Скачать</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-slider">
            <div class="product-slider-title"> <b>HYGIELOCK KL3-SS <br>в наших решениях</b></div>
            <div class="product-slider-body">
                <div class="owl-carousel" id="product_slider">
                    <div class="product-slider-item">
                        <div class="decision__item"> <a href="#">
                                <div class="decision__item-content">
                                    <div class="decision__item-left">
                                        <div class="decision__item-title">
                                            <h3>нефтегазовая отрасль</h3>
                                        </div>
                                        <div class="decision__item-text">
                                            <p>Типовые решения <br>системы АСУ ТП <br>на энергообъектах <br>6-750 кВ</p>
                                        </div>
                                    </div>
                                    <div class="decision__item-right">
                                        <div class="decision__item-thumbnail before">
                                            <picture>
                                                <source srcset="img/pf.webp" type="image/webp"><img src="img/pf.jpg" type="image/webp">
                                            </picture>
                                        </div>
                                    </div>
                                </div></a></div>
                    </div>
                    <div class="product-slider-item">
                        <div class="decision__item"> <a href="#">
                                <div class="decision__item-content">
                                    <div class="decision__item-left">
                                        <div class="decision__item-title">
                                            <h3>нефтегазовая отрасль</h3>
                                        </div>
                                        <div class="decision__item-text">
                                            <p>Типовые решения <br>системы АСУ ТП <br>на энергообъектах <br>6-750 кВ</p>
                                        </div>
                                    </div>
                                    <div class="decision__item-right">
                                        <div class="decision__item-thumbnail before">
                                            <picture>
                                                <source srcset="img/pf.webp" type="image/webp"><img src="img/pf.jpg" type="image/webp">
                                            </picture>
                                        </div>
                                    </div>
                                </div></a></div>
                    </div>
                    <div class="product-slider-item">
                        <div class="decision__item"> <a href="#">
                                <div class="decision__item-content">
                                    <div class="decision__item-left">
                                        <div class="decision__item-title">
                                            <h3>нефтегазовая отрасль</h3>
                                        </div>
                                        <div class="decision__item-text">
                                            <p>Типовые решения <br>системы АСУ ТП <br>на энергообъектах <br>6-750 кВ</p>
                                        </div>
                                    </div>
                                    <div class="decision__item-right">
                                        <div class="decision__item-thumbnail before">
                                            <picture>
                                                <source srcset="img/pf.webp" type="image/webp"><img src="img/pf.jpg" type="image/webp">
                                            </picture>
                                        </div>
                                    </div>
                                </div></a></div>
                    </div>
                    <div class="product-slider-item">
                        <div class="decision__item"> <a href="#">
                                <div class="decision__item-content">
                                    <div class="decision__item-left">
                                        <div class="decision__item-title">
                                            <h3>нефтегазовая отрасль</h3>
                                        </div>
                                        <div class="decision__item-text">
                                            <p>Типовые решения <br>системы АСУ ТП <br>на энергообъектах <br>6-750 кВ</p>
                                        </div>
                                    </div>
                                    <div class="decision__item-right">
                                        <div class="decision__item-thumbnail before">
                                            <picture>
                                                <source srcset="img/pf.webp" type="image/webp"><img src="img/pf.jpg" type="image/webp">
                                            </picture>
                                        </div>
                                    </div>
                                </div></a></div>
                    </div>
                    <div class="product-slider-item">
                        <div class="decision__item"> <a href="#">
                                <div class="decision__item-content">
                                    <div class="decision__item-left">
                                        <div class="decision__item-title">
                                            <h3>нефтегазовая отрасль</h3>
                                        </div>
                                        <div class="decision__item-text">
                                            <p>Типовые решения <br>системы АСУ ТП <br>на энергообъектах <br>6-750 кВ</p>
                                        </div>
                                    </div>
                                    <div class="decision__item-right">
                                        <div class="decision__item-thumbnail before">
                                            <picture>
                                                <source srcset="img/pf.webp" type="image/webp"><img src="img/pf.jpg" type="image/webp">
                                            </picture>
                                        </div>
                                    </div>
                                </div></a></div>
                    </div>
                    <div class="product-slider-item">
                        <div class="decision__item"> <a href="#">
                                <div class="decision__item-content">
                                    <div class="decision__item-left">
                                        <div class="decision__item-title">
                                            <h3>нефтегазовая отрасль</h3>
                                        </div>
                                        <div class="decision__item-text">
                                            <p>Типовые решения <br>системы АСУ ТП <br>на энергообъектах <br>6-750 кВ</p>
                                        </div>
                                    </div>
                                    <div class="decision__item-right">
                                        <div class="decision__item-thumbnail before">
                                            <picture>
                                                <source srcset="img/pf.webp" type="image/webp"><img src="img/pf.jpg" type="image/webp">
                                            </picture>
                                        </div>
                                    </div>
                                </div></a></div>
                    </div>
                    <div class="product-slider-item">
                        <div class="decision__item"> <a href="#">
                                <div class="decision__item-content">
                                    <div class="decision__item-left">
                                        <div class="decision__item-title">
                                            <h3>нефтегазовая отрасль</h3>
                                        </div>
                                        <div class="decision__item-text">
                                            <p>Типовые решения <br>системы АСУ ТП <br>на энергообъектах <br>6-750 кВ</p>
                                        </div>
                                    </div>
                                    <div class="decision__item-right">
                                        <div class="decision__item-thumbnail before">
                                            <picture>
                                                <source srcset="img/pf.webp" type="image/webp"><img src="img/pf.jpg" type="image/webp">
                                            </picture>
                                        </div>
                                    </div>
                                </div></a></div>
                    </div>
                    <div class="product-slider-item">
                        <div class="decision__item"> <a href="#">
                                <div class="decision__item-content">
                                    <div class="decision__item-left">
                                        <div class="decision__item-title">
                                            <h3>нефтегазовая отрасль</h3>
                                        </div>
                                        <div class="decision__item-text">
                                            <p>Типовые решения <br>системы АСУ ТП <br>на энергообъектах <br>6-750 кВ</p>
                                        </div>
                                    </div>
                                    <div class="decision__item-right">
                                        <div class="decision__item-thumbnail before">
                                            <picture>
                                                <source srcset="img/pf.webp" type="image/webp"><img src="img/pf.jpg" type="image/webp">
                                            </picture>
                                        </div>
                                    </div>
                                </div></a></div>
                    </div>
                </div>
            </div>
        </div>

        @if ( isset($page_data['similar_products']) && is_array($page_data['similar_products']) )

            <div class="product-similar">
                <div class="product-similar-title">
                    <h2><span class="stroke">Аналогичные </span><span class="solid">товары</span></h2>
                </div>
                <div class="product-similar-body">
                    <div class="owl-carousel" id="product_similar">

                        @foreach( $page_data['similar_products'] as $similar_products )

                            {{ view('catalog.preview', ['item' => $similar_products]) }}

                        @endforeach

                    </div>
                </div>
            </div>

        @endif

        @if ( isset($page_data['viewed_products']) && is_array($page_data['viewed_products']) )

            <div class="product-viewed">
                <div class="product-viewed-title">
                    <h2><span class="solid">Вы недавно</span><span class="stroke">смотрели </span></h2>
                </div>
                <div class="product-viewed-body">
                    <div class="product-viewed-desctop">
                        <div class="row no-gutters">

                            @foreach( $page_data['viewed_products'] as $viewed_products )

                                <div class="col-xl-3 col-lg-4 col-sm-6 catalog__list-item before after">
                                    {{ view('catalog.preview', ['item' => $viewed_products]) }}
                                </div>

                            @endforeach

                        </div>
                    </div>
                    <div class="product-viewed-mobile">
                        <div class="owl-carousel" id="viewed_mobile">

                            @foreach( $page_data['viewed_products'] as $viewed_products )

                                <div class="product-viewed-item">
                                    {{ view('catalog.preview', ['item' => $viewed_products]) }}
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

        @endif

    </div>

@endsection
