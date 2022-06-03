<li data-product-id="{{ $item['id'] }}">
    <a href="{{ $item['link'] }}">
        <div class="main__search-thumb"> <img src="{{ $item['thumbnail_preview']['link'] }}"></div>
        <div class="main__search-content">
            <b>{{ $item['name'] }}</b>
            <p>{!! $item['price']['html'] !!}</p>
        </div>
    </a>
</li>
