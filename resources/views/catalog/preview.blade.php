
<div class="product__preview" data-product-id="{{ $item['id'] }}">
    <a href="{{ $item['link'] }}">
        <div class="product__preview-compare">
            <button>
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 8H3C2.44772 8 2 8.44772 2 9V19C2 19.5523 2.44772 20 3 20H13C13.5523 20 14 19.5523 14 19C14 19 14 16.5621 14 15C14 14.6095 14 14 14 14V9C14 8.44772 13.5523 8 13 8ZM3 7C1.89543 7 1 7.89543 1 9V19C1 20.1046 1.89543 21 3 21H13C14.1046 21 15 20.1046 15 19V9C15 7.89543 14.1046 7 13 7H3Z" fill="#919194"/>
                    <path d="M19 2H9C8.44772 2 8 2.44772 8 3H7C7 1.89543 7.89543 1 9 1H19C20.1046 1 21 1.89543 21 3V13C21 14.1046 20.1046 15 19 15V14C19.5523 14 20 13.5523 20 13V3C20 2.44772 19.5523 2 19 2Z" fill="#919194"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 8H3C2.44772 8 2 8.44772 2 9V19C2 19.5523 2.44772 20 3 20H13C13.5523 20 14 19.5523 14 19C14 19 14 16.5621 14 15C14 14.6095 14 14 14 14V9C14 8.44772 13.5523 8 13 8ZM3 7C1.89543 7 1 7.89543 1 9V19C1 20.1046 1.89543 21 3 21H13C14.1046 21 15 20.1046 15 19V9C15 7.89543 14.1046 7 13 7H3Z" stroke="#919194" stroke-width="0.3"/>
                    <path d="M19 2H9C8.44772 2 8 2.44772 8 3H7C7 1.89543 7.89543 1 9 1H19C20.1046 1 21 1.89543 21 3V13C21 14.1046 20.1046 15 19 15V14C19.5523 14 20 13.5523 20 13V3C20 2.44772 19.5523 2 19 2Z" stroke="#919194" stroke-width="0.3"/>
                </svg>
            </button>
        </div>
        <div class="product__preview-thumbnail">
            <picture>
                <img src="{{ $item['thumbnail_preview']['link'] }}" alt="{{ $item['thumbnail_preview']['name'] }}" loading="lazy">
            </picture>
        </div>
        <div class="product__preview-title">
            <h3>{{ $item['name'] }}</h3>
        </div>
        <div class="product__preview-description">
            <p>{{ $item['description'] }}</p>
        </div>
        <div class="product__preview-footer">
            <div class="product__preview-price">
                @if ( $item['price']['integer'] > $item['price_discount']['integer'] )
                    <span class="product__preview-price_old before">{!! $item['price']['html'] !!}</span>
                    <div class="product__preview-price_actual">{!! $item['price_discount']['html'] !!} </div>
                @else
                    <div class="product__preview-price_actual">{!! $item['price']['html'] !!}</div>
                @endif
            </div>
            <div class="product__preview-add_to_cart">
                <button class="button button-red button-add_to_cart_preview"><span></span></button>
            </div>
        </div>
    </a>
</div>
