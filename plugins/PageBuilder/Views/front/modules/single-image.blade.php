@if(!empty($content['images']))
<section class="module-line">
    <div class="module-single-image">
        <div class="{{ $content['width_class'] ?? 'container' }}">
            @if(isset($content['title']))
                @php
                    $titleValue = is_array($content['title']) ? ($content['title'][front_locale_code()] ?? array_first($content['title'])) : $content['title'];
                @endphp
                @if(!empty($titleValue))
                    <div class="module-title-wrap text-center">
                        <div class="module-title">{{ $titleValue }}</div>
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

            <div class="image-wrap">
                @foreach($content['images'] as $image)
                    <a href="{{ $image['link']['link'] ?? 'javascript:void(0)' }}">
                        <img src="{{ $image['image'] ?? '' }}" class="img-fluid w-100" alt="">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
