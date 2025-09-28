{{-- ماژول ویرایش تصویر چپ و متن راست - سبک مدرن --}}
<template id="module-editor-left-image-right-text-template">
  <div class="left-image-right-text-editor">
    <div class="top-spacing"></div>
    
    {{-- تنظیم عرض ماژول --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-monitor"></i>
        عرض ماژول
      </div>
      <div class="section-content">
        <div class="segmented-buttons">
          <div 
            :class="['segmented-btn', { active: form.width === 'narrow' }]" 
            @click="form.width = 'narrow'"
          >
            عرض کوتاه
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'wide' }]" 
            @click="form.width = 'wide'"
          >
            عرض وسیع
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'full' }]" 
            @click="form.width = 'full'"
          >
            تمام صفحه
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیمات پایه --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-setting"></i>
        تنظیمات پایه
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">موقعیت تصویر</div>
          <div class="option-buttons">
            <div 
              :class="['option-btn', { active: form.image_position === 'left' }]" 
              @click="form.image_position = 'left'"
            >
              <div class="preview-container">
                <div class="preview-image"></div>
                <div class="preview-text"></div>
              </div>
              <span>تصویر سمت چپ و متن راست</span>
            </div>
            <div 
              :class="['option-btn', { active: form.image_position === 'right' }]" 
              @click="form.image_position = 'right'"
            >
              <div class="preview-container">
                <div class="preview-text"></div>
                <div class="preview-image"></div>
              </div>
              <span>تصویر سمت راست و متن چپ</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیمات محتوا --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit"></i>
        تنظیمات محتوا
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">عنوان ماژول</div>
          <text-i18n v-model="form.title" placeholder="لطفاً عنوان ماژول را وارد کنید"></text-i18n>
        </div>
        
        <div class="setting-group">
          <div class="setting-label">زیر عنوان</div>
          <text-i18n v-model="form.subtitle" placeholder="لطفاً زیر عنوان را وارد کنید"></text-i18n>
        </div>
        
        <div class="setting-group">
          <div class="setting-label">محتوای توضیحات</div>
          <text-i18n v-model="form.description" placeholder="لطفاً محتوای توضیحات را وارد کنید"></text-i18n>
        </div>
        
        <div class="setting-group">
          <div class="setting-label">روشن کردن متن</div>
          <div class="option-buttons">
            <div 
              :class="['option-btn', { active: form.text_align === 'left' }]" 
              @click="form.text_align = 'left'"
            >
              <i class="el-icon-s-fold"></i>
              <span>چپ</span>
            </div>
            <div 
              :class="['option-btn', { active: form.text_align === 'center' }]" 
              @click="form.text_align = 'center'"
            >
              <i class="el-icon-s-operation"></i>
              <span>مرکز</span>
            </div>
            <div 
              :class="['option-btn', { active: form.text_align === 'end' }]" 
              @click="form.text_align = 'end'"
            >
              <i class="el-icon-s-unfold"></i>
              <span>راست</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیمات فاصله --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-position"></i>
        فاصله ها
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">فاصله کلی</div>
          <div class="control-group">
            <div class="control-row">
              <div class="control-item">
                <div class="control-label">فاصله چپ</div>
                <el-input-number 
                  v-model="form.content_margin_left" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">پیکسل</span>
              </div>
              <div class="control-item">
                <div class="control-label">فاصله راست</div>
                <el-input-number 
                  v-model="form.content_margin_right" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">پیکسل</span>
              </div>
            </div>
            <div class="control-row">
              <div class="control-item">
                <div class="control-label">فاصله بالا</div>
                <el-input-number 
                  v-model="form.content_margin_top" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">پیکسل</span>
              </div>
              <div class="control-item">
                <div class="control-label">فاصله پایین</div>
                <el-input-number 
                  v-model="form.content_margin_bottom" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">پیکسل</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- فاصله محتوا --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-s-grid"></i>
        فاصله محتوا
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="control-group">
            <div class="control-item">
              <div class="control-label">فاصله عنوان</div>
              <el-input-number 
                v-model="form.title_spacing" 
                :min="0" 
                :max="50"
                size="small"
                controls-position="right"
              ></el-input-number>
              <span class="control-unit">پیکسل</span>
            </div>
            <div class="control-item">
              <div class="control-label">فاصله زیر عنوان</div>
              <el-input-number 
                v-model="form.subtitle_spacing" 
                :min="0" 
                :max="50"
                size="small"
                controls-position="right"
              ></el-input-number>
              <span class="control-unit">پیکسل</span>
            </div>
            <div class="control-item">
              <div class="control-label">فاصله توضیحات</div>
              <el-input-number 
                v-model="form.description_spacing" 
                :min="0" 
                :max="50"
                size="small"
                controls-position="right"
              ></el-input-number>
              <span class="control-unit">پیکسل</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیمات تصویر --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-picture"></i>
        تنظیمات تصویر
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">انتخاب تصویر</div>
          <single-image-selector 
            v-model="form.image" 
            :aspectRatio="16 / 9" 
            :targetWidth="800"
            :targetHeight="450"
          ></single-image-selector>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            پیشنهاد: 800 x 450، نسبت تصویر 16:9
          </div>
        </div>
        
        <div class="setting-group">
          <div class="setting-label">فاصله داخلی تصویر</div>
          <div class="control-group">
            <div class="control-row">
              <div class="control-item">
                <div class="control-label">فاصله افقی داخلی</div>
                <el-input-number 
                  v-model="form.image_padding_x" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">پیکسل</span>
              </div>
              <div class="control-item">
                <div class="control-label">فاصله عمودی داخلی</div>
                <el-input-number 
                  v-model="form.image_padding_y" 
                  :min="0" 
                  :max="100"
                  size="small"
                  controls-position="right"
                ></el-input-number>
                <span class="control-unit">پیکسل</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیمات دکمه --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-link"></i>
        تنظیمات دکمه
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">متن دکمه</div>
          <text-i18n v-model="form.button_text" placeholder="لطفاً متن دکمه را وارد کنید"></text-i18n>
        </div>
        
        <div class="setting-group">
          <div class="setting-label">پیوند دکمه</div>
          <link-selector 
            :hide-types="['catalog', 'static']" 
            v-model="form.link"
          ></link-selector>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
/* خصوصیات ویرایشگر تصویر چپ و متن راست - فقط خصوصیات واقعی را حفظ کنید */
.left-image-right-text-editor {
  padding: 0;
  background: #fff;
}

/* خصوصیات گزینه‌ای خصوصی - بازیابی اثر پیش‌بینی */
.option-btn .preview-container {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 8px;
  height: 24px;
  width: 100%;
}

.option-btn .preview-image {
  width: 16px;
  height: 16px;
  background: #667eea;
  border-radius: 2px;
  flex-shrink: 0;
}

.option-btn .preview-text {
  flex: 1;
  height: 8px;
  background: #dee2e6;
  border-radius: 4px;
}
</style>

<script type="text/javascript">
  Vue.component('module-editor-left-image-right-text', {
    template: '#module-editor-left-image-right-text-template',
    props: ['module'],
    data: function() {
      return {
        form: {
          image_position: 'left',
          title: '',
          subtitle: '',
          description: '',
          image: '',
          button_text: '',
          text_align: 'left',
          width: 'wide',
          content_margin_left: 0,
          content_margin_right: 0,
          content_margin_top: 0,
          content_margin_bottom: 0,
          title_spacing: 20,
          subtitle_spacing: 15,
          description_spacing: 20,
          image_padding_x: 0,
          image_padding_y: 0,
          link: {
            type: 'category',
            value: '',
            new_window: true
          }
        },
        source: {
          locale: $locale
        }
      }
    },
    created() {
      if (this.module && Object.keys(this.module).length) {
        this.form = Object.assign({}, this.form, this.module);
      }
      
      // گرفتن مقدار پیش‌فرض برای width
      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }
    },
    watch: {
      form: {
        handler: function(val) {
          this.$emit('on-changed', val);
        },
        deep: true
      }
    }
  });
</script>
