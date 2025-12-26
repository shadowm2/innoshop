<!-- Basic Store Information -->
<div class="tab-pane fade show active" id="tab-setting-basics">
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="card-title mb-0">{{ __('panel/setting.basic_store_info') }}</h5>
      <p class="text-muted small mb-0">{{ __('panel/setting.basic_store_info_desc') }}</p>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-6 col-md-3">
          <x-common-form-image title="{{ __('panel/setting.front_logo') }}" name="front_logo"
                               value="{{ old('front_logo', system_setting('front_logo')) }}"/>
        </div>
        <div class="col-6 col-md-3">
          <x-common-form-image title="{{ __('panel/setting.backend_logo') }}" name="panel_logo"
                               value="{{ old('panel_logo', system_setting('panel_logo')) }}"/>
        </div>
        <div class="col-6 col-md-3">
          <x-common-form-image title="{{ __('panel/setting.placeholder') }}" name="placeholder"
                               value="{{ old('placeholder', system_setting('placeholder')) }}"/>
        </div>
        <div class="col-6 col-md-3">
          <x-common-form-image title="{{ __('panel/setting.favicon') }}" name="favicon"
                               value="{{ old('favicon', system_setting('favicon')) }}"/>
        </div>
      </div>

      <x-common-form-input title="{{ __('panel/setting.shop_address') }}" name="address"
                           value="{{ old('address', system_setting('address')) }}"
                           placeholder="{{ __('panel/setting.shop_address') }}"/>

      <x-common-form-input title="{{ __('panel/setting.telephone') }}" name="telephone"
                           value="{{ old('telephone', system_setting('telephone')) }}"
                           placeholder="{{ __('panel/setting.telephone') }}"/>

      <x-common-form-input title="{{ __('panel/setting.email') }}" name="email"
                           value="{{ old('email', system_setting('email')) }}"
                           placeholder="{{ __('panel/setting.email') }}"/>
    </div>
  </div>

  <!-- Header Top Settings -->
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="card-title mb-0">{{ __('panel/setting.header_top_settings') }}</h5>
      <p class="text-muted small mb-0">{{ __('panel/setting.header_top_settings_desc') }}</p>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-4">
            <x-common-form-switch-radio title="{{ __('panel/setting.header_top_enable') }}" name="header_top_enable"
                                        required
                                        value="{{ old('header_top_enable', system_setting('header_top_enable', true)) }}"/>
            <div class="text-secondary"><small>{{ __('panel/setting.header_top_enable_desc') }}</small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-4">
            <x-common-form-input title="{{ __('panel/setting.header_top_bg_color') }}" name="header_top_bg_color"
                                 value="{{ old('header_top_bg_color', system_setting('header_top_bg_color', '#1B1F22')) }}"
                                 placeholder="{{ __('panel/setting.header_top_bg_color_placeholder') }}"/>
            <div class="text-secondary"><small>{{ __('panel/setting.header_top_bg_color_desc') }}</small></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="mb-4">
            <x-common-form-input title="{{ __('panel/setting.header_top_instagram') }}" name="header_top_instagram"
                                 value="{{ old('header_top_instagram', system_setting('header_top_instagram')) }}"
                                 placeholder="{{ __('panel/setting.header_top_instagram_placeholder') }}"/>
            <div class="text-secondary"><small>{{ __('panel/setting.header_top_instagram_desc') }}</small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-4">
            <x-common-form-input title="{{ __('panel/setting.header_top_telegram') }}" name="header_top_telegram"
                                 value="{{ old('header_top_telegram', system_setting('header_top_telegram')) }}"
                                 placeholder="{{ __('panel/setting.header_top_telegram_placeholder') }}"/>
            <div class="text-secondary"><small>{{ __('panel/setting.header_top_telegram_desc') }}</small></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Settings -->
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="card-title mb-0">{{ __('panel/setting.footer_settings') }}</h5>
      <p class="text-muted small mb-0">{{ __('panel/setting.footer_settings_desc') }}</p>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <x-common-form-input title="{{ __('panel/setting.footer_bg_color') }}" name="footer_bg_color"
                               value="{{ old('footer_bg_color', system_setting('footer_bg_color', '#b62323')) }}"
                               placeholder="{{ __('panel/setting.footer_bg_color_placeholder') }}"/>
          <div class="text-secondary"><small>{{ __('panel/setting.footer_bg_color_desc') }}</small></div>
        </div>
        <div class="col-md-6">
          <x-common-form-input title="{{ __('panel/setting.footer_header_color') }}" name="footer_header_color"
                               value="{{ old('footer_header_color', system_setting('footer_header_color', '#b62323')) }}"
                               placeholder="{{ __('panel/setting.footer_header_color_placeholder') }}"/>
          <div class="text-secondary">
            <small>{{ __('panel/setting.footer_header_color_desc') }}</small>
          </div>
        </div>
        <div class="col-md-6">
          <x-common-form-input title="{{ __('panel/setting.footer_color') }}" name="footer_color"
                               value="{{ old('footer_color', system_setting('footer_color', '#b62323')) }}"
                               placeholder="{{ __('panel/setting.footer_color_placeholder') }}"/>
          <div class="text-secondary">
            <small>{{ __('panel/setting.footer_color_desc') }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Font Settings -->
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="card-title mb-0">{{ __('panel/setting.font_settings') }}</h5>
      <p class="text-muted small mb-0">{{ __('panel/setting.font_settings_desc') }}</p>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-4">
            <x-common-form-input title="{{ __('panel/setting.font_family') }}" name="font_family"
                                 value="{{ old('font_family', system_setting('font_family', 'Vazirmatn')) }}"
                                 placeholder="{{ __('panel/setting.font_family_placeholder') }}"/>
            <div class="text-secondary"><small>{{ __('panel/setting.font_family_desc') }}</small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-4">
            <x-common-form-input title="{{ __('panel/setting.font_size') }}" name="font_size"
                                 value="{{ old('font_size', system_setting('font_size', '14px')) }}"
                                 placeholder="{{ __('panel/setting.font_size_placeholder') }}"/>
            <div class="text-secondary"><small>{{ __('panel/setting.font_size_desc') }}</small></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="mb-4">
            <x-common-form-input title="{{ __('panel/setting.font_color') }}" name="font_color"
                                 value="{{ old('font_color', system_setting('font_color', '#000000')) }}"
                                 placeholder="{{ __('panel/setting.font_color_placeholder') }}"/>
            <div class="text-secondary"><small>{{ __('panel/setting.font_color_desc') }}</small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-4">
            <x-common-form-input title="{{ __('panel/setting.page_bg_color') }}" name="page_bg_color"
                                 value="{{ old('page_bg_color', system_setting('page_bg_color', '#ffffff')) }}"
                                 placeholder="{{ __('panel/setting.page_bg_color_placeholder') }}"/>
            <div class="text-secondary"><small>{{ __('panel/setting.page_bg_color_desc') }}</small></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SEO Settings -->
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="card-title mb-0">{{ __('panel/setting.seo_settings') }}</h5>
      <p class="text-muted small mb-0">{{ __('panel/setting.seo_settings_desc') }}</p>
    </div>
    <div class="card-body">
      <x-common-form-input title="{{ __('panel/setting.meta_title') }}" name="meta_title"
                           :value="old('meta_keywords', system_setting('meta_title'))"
                           :multiple="true"/>

      <x-common-form-input title="{{ __('panel/setting.meta_keywords') }}" :multiple="true"
                           name="meta_keywords"
                           :value="old('meta_keywords', system_setting('meta_keywords'))"
                           placeholder="{{ __('panel/setting.meta_keywords') }}"/>

      <x-common-form-textarea title="{{ __('panel/setting.meta_description') }}" name="meta_description"
                              :multiple="true"
                              :value="old('meta_description', system_setting('meta_description'))"
                              placeholder="{{ __('panel/setting.meta_description') }}"/>
    </div>
  </div>
</div>
