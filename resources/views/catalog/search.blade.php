<?php /** @var $page_data */?>
@extends('layouts.app')

@section('content')

    <div class="wrapper">
        <div class="breadcrumbs">
            <ol itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscopeitemtype="http://schema.org/ListItem"><a class="before" itemprop="item" href="/"><span itemprop="name">Главная</span>
                        <meta itemprop="position" content="1"></a></li>
                <li itemprop="itemListElement" itemscopeitemtype="http://schema.org/ListItem"><span itemprop="name">Поиск</span>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </div>
        <div class="main__page-title">
            <h1>Результаты поиска</h1>
        </div>
    </div>
    <div class="catalog">
        <div class="wrapper">
            <div class="search__detail">
                <div class="search__detail-list">
                    <ul>
                        <li class="before">Найдено результатов: {{ $page_data['count'] }}</li>
                        <li>По запросу: {{ $page_data['search_request'] }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="wrapper catalog-wrapper">

            @if ( !empty($page_data['list']) && is_array($page_data['list']) )

                <div class="catalog-list">
                    <div class="catalog__list">
                        <div class="row no-gutters">

                            @foreach ( $page_data['list'] as $item )

                                <div class="col-xl-3 col-lg-4 col-sm-6 catalog__list-item before after">
                                    {{ view('catalog.preview', ['item' => $item]) }}
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>

            @else

                <div class="catalog-list">
                    <div class="catalog__list">
                        <div class="product__preview">
                            <p>К сожалению, ничего не найдено</p>

                        </div>
                    </div>
                </div>
            @endif
        </div>
        {!! $page_data['pagination'] !!}
    </div>

@endsection
