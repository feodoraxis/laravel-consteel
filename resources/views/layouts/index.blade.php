<?php
/**
 * @var $page_data
 */
?>
@extends('layouts.app')

@section('content')

    <section class="general" id="front_general">
        <div class="general-bg bg">
            <picture>
                <source srcset="/img/general.webp" loading="lazy" type="image/webp"><img src="/img/general.jpg" loading="lazy" type="image/webp">
            </picture>
        </div>
        <div class="wrapper general-wrapper">
            <div class="general-flexbox">
                <div class="row">
                    <div class="col-xxl-3 col-xl-1">
                        <div class="general-subtitle"> <span>{!! $page_data['main']['subtitle'] !!}</span></div>
                    </div>
                    <div class="col-xxl-9 col-xl-11">
                        <h1>{!! $page_data['main']['title'] !!}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="general-to_bottom">
            <button></button>
        </div>
    </section>

    @if ($page_data['second_section']['categories'])

        <section class="equipment">
            <div class="wrapper equipment-wrapper before">
                <div class="equipment-title">
                    <h2>{!! $page_data['second_section']['title'] !!}</h2>
                </div>
                <div class="equipment-body">
                    <div class="equipment-line">
                        <div class="equipment-item">
                            <div class="equipment__item before ">
                                <a class="before after" href="{{ $page_data['second_section']['categories']['0']['link'] }}">
                                    <h3>{{ $page_data['second_section']['categories']['0']['name'] }}</h3>
                                    <div class="equipment__item-bg">
                                        <picture>
                                            <img src="{{ $page_data['second_section']['categories']['0']['preview_thumbnail'] }}" loading="lazy" type="image/webp">
                                        </picture>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="equipment-line">
                        <div class="equipment-item">
                            <div class="equipment__item before ">
                                <a class="before after" href="{{ $page_data['second_section']['categories']['1']['link'] }}">
                                    <h3>{{ $page_data['second_section']['categories']['1']['name'] }}</h3>
                                    <div class="equipment__item-bg">
                                        <picture>
                                            <img src="{{ $page_data['second_section']['categories']['1']['preview_thumbnail'] }}" loading="lazy" type="image/webp">
                                        </picture>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="equipment-item last">
                            <div class="equipment__item before last">
                                <a class="before after" href="{{ $page_data['second_section']['categories']['2']['link'] }}">
                                    <h3>{{ $page_data['second_section']['categories']['2']['name'] }}</h3>
                                    <div class="equipment__item-bg">
                                        <picture>
                                            <img src="{{ $page_data['second_section']['categories']['2']['preview_thumbnail'] }}" loading="lazy" type="image/webp">
                                        </picture>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endif

    @if ( $page_data['projects']['list'] )

        <section class="portfolio">
            <div class="portfolio-header">
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="portfolio-subtitle"><b>{!! $page_data['projects']['subtitle'] !!}</b></div>
                        </div>
                        <div class="col-md-9">
                            <div class="portfolio-title">
                                <h2>{!! $page_data['projects']['title'] !!}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portfolio-body" id="portfolio_body">
                <div class="portfolio-wrapper">
                    <div class="owl-carousel" id="portfolio_slider">

                        @foreach( $page_data['projects']['list'] as $item )

                            <div class="portfolio-item">
                                <div class="portfolio__item before">
                                    <a href="{{ $item['link'] }}">
                                        <div class="portfolio__item-category"> <span>{{ $item['category_name'] }}</span></div>
                                        <div class="portfolio__item-title">
                                            <h3>{{ $item['name'] }}</h3>
                                        </div>
                                        <div class="portfolio__item-thumbnail">
                                            <picture>
                                                <img src="{{ $item['preview_thumbnail'] }}" loading="lazy" type="image/webp">
                                            </picture>
                                        </div>
                                        <div class="portfolio__item-button">
                                            <button class="button button-arrow before after"> </button>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        @endforeach

                    </div>
                    <div class="portfolio-to_detail">
                        <div class="to__detail"><a class="before" href="/cases/">Все решения</a></div>
                    </div>
                </div>
            </div>
        </section>

    @endif

    <section class="prefers">
        <div class="wrapper prefers-wrapper after">
            <div class="prefers-title">
                <h2>{!! $page_data['prefers']['title'] !!}</h2>
            </div>
            <div class="prefers-body">
                <div class="row prefers-row">
                    <div class="col-12">
                        <div class="prefers-icons prefers-icons-mobile">
                            <div class="owl-carousel" id="prefers_icons">

                                @foreach( $page_data['prefers']['prefers_with_icons'] as $item )

                                    <div class="prefers-icons-item">
                                        <div class="prefer__icon">
                                            <div class="prefer__icon-icon"><img src="{{ $item['icon']['link'] }}"></div>
                                            <div class="prefer__icon-title"> <b>{{ $item['title'] }}</b></div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-lg-5">
                        <div class="prefers-icons prefers-icons-desctop">
                            <div class="row">

                                @foreach( $page_data['prefers']['prefers_with_icons'] as $item )

                                    <div class="col-sm-6">
                                        <div class="prefer__icon">
                                            <div class="prefer__icon-icon"><img src="{{ $item['icon']['link'] }}"></div>
                                            <div class="prefer__icon-title"> <b>{{ $item['title'] }}</b></div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>
                        <div class="prefers-to_detail prefers-to_detail-desctop">
                            <div class="to__detail"><a class="before" href="/about/">О компании </a></div>
                        </div>
                    </div>
                    <div class="offset-xxl-2 offset-xl-1 col-xl-6 col-lg-7">
                        <div class="prefers-text">
                            <div class="prefers-subtitle">
                                <h3>{{ $page_data['prefers']['subtitle'] }}</h3>
                            </div>

                            @if ( $page_data['prefers']['prefers_nums'] )

                                <div class="prefers-list">

                                    @foreach ( $page_data['prefers']['prefers_nums'] as $key => $item )

                                        @if ( $key == 0 || $key == 2 )
                                            <div class="row">
                                        @endif

                                        <div class="col-md-6">
                                            <div class="prefer__text">
                                                <div class="prefer__text-num"> <span>/ 0{{ $key+1 }}</span></div>
                                                <div class="prefer__text-text">
                                                    <p>{{ $item }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        @if ( $key == 1 || $key == 3 )
                                            </div>
                                        @endif

                                    @endforeach

                                </div>

                            @endif

                        </div>
                    </div>
                </div>
                <div class="prefers-to_detail prefers-to_detail-mobile">
                    <div class="to__detail"><a class="before" href="/about/">О компании </a></div>
                </div>
            </div>
        </div>
    </section>

@endsection
