@extends('layouts.app')

@section('content')

    <div class="wrapper">
        {!! $breadcrumbs !!}
        <div class="main__page-title">
            <h1>{{ $page_data['category_data']['name'] }}</h1>
        </div>
    </div>
    <div class="catalog">
        @if ( !empty($page_data['products']) )

            <div class="wrapper">
                {!! $subcategories !!}

                @if ( !empty($page_data['filter']) )

                    <div class="catalog-form">
                        <div class="catalog-filter">
                            <div class="filter">
                                <div class="filter-button mobile" id="open_mobile_filter"><span class="before">Фильтр</span></div>
                                <div class="desctop">
                                    <form>
                                        <input type="hidden" id="filter_and_sort" value=''>
                                        <div class="row">
                                            <div class="col-lg-9 col-md-8">
                                                <div class="filter-list">

                                                    <div class="filter-item before" for="#filter_price"><span>Цена</span></div>

                                                    @foreach ($page_data['filter'] as $filter )

                                                        <div class="filter-item before" for="#filter_{{ $filter['slug'] }}"><span>{{ $filter['name'] }}</span></div>

                                                    @endforeach

                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div class="filter-reset">
                                                    <button class="before">Сбросить все</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="catalog-sort">
                            <div class="sort">
                                <div class="sort-title" id="open_mobile_sort"><span class="before">Сортировка</span></div>
                                <div class="row sort-body">
                                    <div class="col-lg-9">
                                        <div class="sort-list">
                                            <div class="sort-item">
                                                <div class="sort__item">
                                                    <input type="hidden">
                                                    <div class="sort__item-label">
                                                        <span>Сортировка:</span>
                                                        <span class="before">{{ $page_data['sort'] }}</span>
                                                    </div>
                                                    <div class="sort__item-select" id="catalog-sort">
                                                        <ul>
                                                            <li data-value="price-desc">сначала подороже</li> <!-- desc -- от большего к меньшему. -->
                                                            <li data-value="price-asc">Сначала подешевле</li>
                                                            <li data-value="popular">Сначала популярные</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sort-item">
                                                <div class="sort__item">
                                                    <input type="hidden">
                                                    <div class="sort__item-label">
                                                        <span>Группировка:</span>
                                                        <span class="before">по наличию</span>
                                                    </div>
                                                    <div class="sort__item-select" id="catalog-quantity">
                                                        <ul>
                                                            <li data-value="has">по наличию</li>
                                                            <li data-value="has-not">по отсутствию</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="sort-data">
                                            <div class="sort-length"> <span>256 товаров</span></div>
                                            <div class="sort-visible">
                                                <ul>
                                                    <li class="sort-visible-grid"></li>
                                                    <li class="sort-visible-list"></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            </div>
            <div class="wrapper catalog-wrapper">
                <div class="catalog-list">

                    <div class="catalog__list">
                        <div class="row no-gutters" id="catalog__list_row">

                            {!! $page_data['products'] !!}

                        </div>
                    </div>

                </div>
            </div>

            {!! $page_data['pagination'] !!}

        @else
            <div class="wrapper">
                <p>Категория находится в разработке</p>
            </div>
        @endif

    </div>

@endsection
