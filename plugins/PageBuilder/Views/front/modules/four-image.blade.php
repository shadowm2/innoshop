@if(!empty($content['images']))
<section class="module-line">
    <div class="module-four-image">
        <div class="{{ $content['width_class'] ?? 'container' }}">
            @if(isset($content['title']))
                @php
                    $titleValue = is_array($content['title']) ? ($content['title'][front_locale_code()] ?? array_first($content['title'])) : $content['title'];
                @endphp
                @if(!empty($titleValue))
                    <div class="module-title-wrap text-center mb-4">
                        <div class="module-title h3">{{ $titleValue }}</div>
                        @if(isset($content['subtitle']))
                            @php
                                $subtitleValue = is_array($content['subtitle']) ? ($content['subtitle'][front_locale_code()] ?? array_first($content['subtitle'])) : $content['subtitle'];
                            @endphp
                            @if(!empty($subtitleValue))
                                <div class="module-sub-title">{{ $subtitleValue }}</div>
                            @endif
                        @endif
                    </div>
                @endif
            @endif

            <div class="image-grid">
                @foreach($content['images'] as $image)
                    <div class="image-item">
                        <a href="{{ $image['link']['link'] ?? 'javascript:void(0)' }}" class="d-block">
                            <div class="image-wrap">
                                <img src="{{ image_resize($image['image']) }}"
                                     style="object-fit: {{ $image['object_fit'] ?? 'cover' }}"
                                     alt="">
                            </div>
                            @if(isset($image['text']))
                                @php
                                    $textValue = is_array($image['text']) ? ($image['text'][front_locale_code()] ?? array_first($image['text'])) : $image['text'];
                                @endphp
                                @if(!empty($textValue))
                                    <div class="image-text">{{ $textValue }}</div>
                                @endif
                            @endif
                            @if(isset($image['sub_text']))
                                @php
                                    $subTextValue = is_array($image['sub_text']) ? ($image['sub_text'][front_locale_code()] ?? array_first($image['sub_text'])) : $image['sub_text'];
                                @endphp
                                @if(!empty($subTextValue))
                                    <div class="image-sub-text">{{ $subTextValue }}</div>
                                @endif
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
.module-four-image {
    padding: 30px 0;
}
.module-four-image .module-sub-title {
    color: #6c757d !important;
    display: block !important;
    margin-top: 8px;
}
.module-four-image .image-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.module-four-image .image-item {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    background: #f8f8f8;
}
.module-four-image .image-wrap {
    position: relative;
    width: 100%;
    height: 300px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.module-four-image .image-wrap img {
    width: 100%;
    height: 100%;
    transition: transform 0.3s ease;
}
.module-four-image .image-item:hover img {
    transform: scale(1.05);
}
.module-four-image .image-text {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 30px;
    text-align: center;
    color: #ffffff !important;
    font-size: 1rem;
    font-weight: bold;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    z-index: 1;
    padding: 0 15px;
    display: block !important;
}
.module-four-image .image-sub-text {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 10px;
    text-align: center;
    color: #ffffff !important;
    font-size: 0.875rem;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    z-index: 1;
    padding: 0 15px;
    display: block !important;
}

@media (max-width: 768px) {
    .module-four-image .image-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    .module-four-image .image-wrap {
        height: 150px; /* 移动端图片高度减半 */
    }
}
</style>
@endif
