@if(!empty($content))
<section class="module-line">
    <div class="module-rich-text">
        <div class="{{ $content['width_class'] ?? 'container' }}">
            @if(!empty($content['title']))
                <div class="module-title-wrap text-center">
                    <div class="module-title">{{ $content['title'][front_locale_code()] ?? '' }}</div>
                    @if(!empty($content['subtitle']))
                        <div class="module-sub-title">{{ $content['subtitle'][front_locale_code()] ?? '' }}</div>
                    @endif
                </div>
            @endif

            @if(!empty($content['content']) && !empty($content['content'][front_locale_code()]))
                <div class="rich-text-content">
                    {!! $content['content'][front_locale_code()] !!}
                </div>
            @elseif(request()->get('design'))
                {{-- راهنمای محتوای خالی در حالت طراحی --}}
                <div class="rich-text-empty">
                    <div class="empty-content">
                        <div class="empty-icon">
                            <i class="el-icon-edit-outline"></i>
                        </div>
                        <div class="empty-text">
                            <h4>محتوایی وجود ندارد</h4>
                            <p>لطفاً محتوای متن غنی را در پنل مدیریت آپلود کنید</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@elseif(request()->get('design'))
{{-- راهنمای ماژول پیکربندی نشده در حالت طراحی --}}
<div class="module-not-configured">
    <div class="not-configured-content">
        <div class="not-configured-icon">
            <i class="el-icon-warning-outline"></i>
        </div>
        <div class="not-configured-text">
            <h4>ماژول پیکربندی نشده است</h4>
            <p>لطفاً این ماژول متن غنی را در پنل مدیریت پیکربندی کنید</p>
        </div>
    </div>
</div>
@endif
