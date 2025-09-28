{{-- ماژول ویرایش اسلایدشو - نسخه ساده --}}
<template id="module-editor-slideshow">
  <div class="slideshow-editor">
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
            :class="['segmented-btn', { active: module.width === 'narrow' }]" 
            @click="module.width = 'narrow'"
          >
            عرض کوتاه
          </div>
          <div 
            :class="['segmented-btn', { active: module.width === 'wide' }]" 
            @click="module.width = 'wide'"
          >
            عرض وسیع
          </div>
          <div 
            :class="['segmented-btn', { active: module.width === 'full' }]" 
            @click="module.width = 'full'"
          >
            تمام صفحه
          </div>
        </div>
      </div>
    </div>

    {{-- محتوای اسلایدشو --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-picture"></i>
        مدیریت اسلایدشو
      </div>
      <div class="slideshow-list">
        <draggable
          ghost-class="dragabble-ghost"
          :list="module.images"
          :options="{animation: 330, handle: '.drag-handle'}"
        >
          <div class="slide-item" v-for="(item, index) in module.images" :key="index">
            {{-- سربرگ اسلاید --}}
            <div class="slide-header" @click="toggleSlide(index)">
              <div class="slide-info">
                <div class="drag-handle">
                  <i class="el-icon-rank"></i>
                </div>
                <div class="slide-preview" @click.stop>
                  <img :src="thumbnail(item.image, 60, 40)" class="preview-img">
                  <div class="slide-number"># @{{ index + 1 }}</div>
                </div>
                <div class="slide-title">
                  <span v-if="getTitleText(item)">
                    @{{ getTitleText(item) }}
                  </span>
                  <span v-else>عنوان تنظیم نشده</span>
                </div>
              </div>
              
              <div class="slide-actions">
                <el-button 
                  type="danger" 
                  size="mini" 
                  icon="el-icon-delete" 
                  circle
                  @click.stop="removeImage(index)"
                ></el-button>
                <i :class="'el-icon-arrow-' + (item.show ? 'up' : 'down') + ' toggle-icon'"></i>
              </div>
            </div>

            {{-- ویرایش محتوای اسلاید --}}
            <div :class="'slide-content ' + (item.show ? 'expanded' : '')">
              {{-- تنظیم تصویر --}}
              <div class="content-section">
                <div class="section-subtitle">
                  <i class="el-icon-picture-outline"></i>
                  تنظیمات تصویر
                </div>
                <div class="image-selector-wrapper">
                  <single-image-selector v-model="item.image" @change="onChange"></single-image-selector>
                  <div class="image-tips">پیشنهادات اندازه (عرض x ارتفاع): 1920 x 600</div>
                </div>
              </div>

              {{-- تنظیم لینک --}}
              <div class="content-section">
                <div class="section-subtitle">
                  <i class="el-icon-link"></i>
                  تنظیمات لینک
                </div>
                <link-selector v-model="item.link" @change="onChange" ></link-selector>
              </div>

              {{-- تنظیم عنوان --}}
              <div class="content-section">
                <div class="section-subtitle">
                  <i class="el-icon-edit"></i>
                  تنظیمات عنوان
                </div>
                <text-i18n v-model="item.title" @change="onChange" placeholder="لطفا عنوان را وارد کنید"></text-i18n>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">رنگ عنوان</label>
                    <el-color-picker v-model="item.title_color" @change="onChange" show-alpha size="small"></el-color-picker>
                  </div>
                  <div class="form-group">
                    <label class="form-label">اندازه عنوان</label>
                    <el-input-number v-model="item.title_size" @change="onChange" :min="12" :max="72" :step="2" size="small"></el-input-number>
                  </div>
                </div>
              </div>

              {{-- تنظیم زیرعنوان --}}
              <div class="content-section">
                <div class="section-subtitle">
                  <i class="el-icon-document"></i>
                  تنظیمات زیرعنوان
                </div>
                <text-i18n v-model="item.subtitle" @change="onChange" placeholder="لطفا زیرعنوان را وارد کنید"></text-i18n>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">رنگ زیرعنوان</label>
                    <el-color-picker v-model="item.subtitle_color" @change="onChange" show-alpha size="small"></el-color-picker>
                  </div>
                  <div class="form-group">
                    <label class="form-label">اندازه زیرعنوان</label>
                    <el-input-number v-model="item.subtitle_size" @change="onChange" :min="12" :max="48" :step="2" size="small"></el-input-number>
                  </div>
                </div>
              </div>

              {{-- تنظیم دکمه --}}
              <div class="content-section">
                <div class="section-subtitle">
                  <i class="el-icon-mouse"></i>
                  تنظیمات دکمه
                </div>
                <text-i18n v-model="item.button_text" @change="onChange" placeholder="لطفا متن دکمه را وارد کنید"></text-i18n>
                <div class="setting-group mt-3">
                  <div class="section-subtitle">
                    <i class="el-icon-link"></i>
                    لینک دکمه
                  </div>
                  <link-selector v-model="item.button_link" @change="onChange"></link-selector>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">رنگ پس زمینه دکمه</label>
                    <el-color-picker v-model="item.button_color" @change="onChange" show-alpha size="small"></el-color-picker>
                  </div>
                  <div class="form-group">
                    <label class="form-label">رنگ متن دکمه</label>
                    <el-color-picker v-model="item.button_text_color" @change="onChange" show-alpha size="small"></el-color-picker>
                  </div>
                </div>
              </div>

              {{-- تنظیم موقعیت --}}
              <div class="content-section">
                <div class="section-subtitle">
                  <i class="el-icon-s-grid"></i>
                  تنظیم موقعیت
                </div>
                <div class="setting-group">
                  <label class="form-label">موقعیت محتوا</label>
                  <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <el-button 
                      :type="item.title_align === 'left' ? 'primary' : 'default'"
                      size="small"
                      @click="item.title_align = 'left'; onChange()"
                      icon="el-icon-s-fold"
                    >
                      چپ
                    </el-button>
                    <el-button 
                      :type="item.title_align === 'center' ? 'primary' : 'default'"
                      size="small"
                      @click="item.title_align = 'center'; onChange()"
                      icon="el-icon-s-operation"
                    >
                      مرکز
                    </el-button>
                    <el-button 
                      :type="item.title_align === 'right' ? 'primary' : 'default'"
                      size="small"
                      @click="item.title_align = 'right'; onChange()"
                      icon="el-icon-s-unfold"
                    >
                      راست
                    </el-button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </draggable>

        {{-- وضعیت خالی --}}
        <div v-if="!module.images || module.images.length === 0" class="empty-state">
          <i class="el-icon-picture-outline"></i>
          <p>هیچ اسلایدی وجود ندارد، لطفا دکمه زیر را برای اضافه کردن کلیک کنید</p>
        </div>

        {{-- دکمه اضافه کردن --}}
        <div class="add-button-wrapper">
          <el-button type="primary" size="small" @click="addImage" icon="el-icon-plus">
            افزودن اسلاید
          </el-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
Vue.component('module-editor-slideshow', {
  template: '#module-editor-slideshow',

  props: ['module'],

  data: function () {
    return {
      debounceTimer: null,
      currentLocale: '{{ locale_code() }}',
      isToggling: false
    }
  },

  watch: {
    module: {
      handler: function (val) {
        if (!this.isToggling) {
          this.onChange();
        }
      },
      deep: true,
    }
  },

  created: function () {
    // مقداردهی اولیه پیش‌فرض
    if (!this.module.images) {
      this.module.images = [{
        image: this.getDefaultImage(),
        link: {
          type: 'product',
          value: ''
        },
        button_link: {
          type: 'product',
          value: ''
        },
        title: this.languagesFill(''),
        subtitle: this.languagesFill(''),
        button_text: this.languagesFill(''),
        title_color: '#ffffff',
        subtitle_color: '#ffffff',
        button_color: '#667eea',
        button_text_color: '#ffffff',
        title_size: 24,
        subtitle_size: 16,
        title_align: 'center',
        show: true
      }];
    } else {
      // مطمئن شوید داده‌های موجود دارای ساختار درست هستند
      this.module.images.forEach(item => {
        if (!item.title) {
          this.$set(item, 'title', this.languagesFill(''));
        }
        if (!item.subtitle) {
          this.$set(item, 'subtitle', this.languagesFill(''));
        }
        if (!item.button_text) {
          this.$set(item, 'button_text', this.languagesFill(''));
        }
        if (!item.button_link) {
          this.$set(item, 'button_link', {
            type: 'product',
            value: ''
          });
        }
        if (!item.title_color) {
          this.$set(item, 'title_color', '#ffffff');
        }
        if (!item.subtitle_color) {
          this.$set(item, 'subtitle_color', '#ffffff');
        }
        if (!item.button_color) {
          this.$set(item, 'button_color', '#667eea');
        }
        if (!item.button_text_color) {
          this.$set(item, 'button_text_color', '#ffffff');
        }
        if (!item.title_size) {
          this.$set(item, 'title_size', 24);
        }
        if (!item.subtitle_size) {
          this.$set(item, 'subtitle_size', 16);
        }
        if (!item.title_align) {
          this.$set(item, 'title_align', 'center');
        }
        if (typeof item.show === 'undefined') {
          this.$set(item, 'show', false);
        }
      });
    }
    if (!this.module.width) {
      this.$set(this.module, 'width', 'wide');
    }
  },

  methods: {
    onChange() {
      // پاک کردن زمان‌بندی قبلی
      if (this.debounceTimer) {
        clearTimeout(this.debounceTimer);
      }
      
      // تنظیم زمان‌بندی جدید
      this.debounceTimer = setTimeout(() => {
        this.$emit('on-changed', this.module);
      }, 300);
    },

    removeImage(index) {
      this.$confirm('آیا مطمئن هستید که می‌خواهید این اسلاید را حذف کنید؟', 'هشدار', {
        confirmButtonText: 'تأیید',
        cancelButtonText: 'لغو',
        type: 'warning'
      }).then(() => {
        this.module.images.splice(index, 1);
        this.$message.success('حذف با موفقیت انجام شد');
      }).catch(() => {});
    },

    toggleSlide(index) {
      this.isToggling = true;
      
      // بستن اسلایدهای دیگر
      this.module.images.forEach((item, key) => {
        if (key !== index) {
          this.$set(item, 'show', false);
        }
      });
      // تغییر وضعیت اسلاید فعلی
      const currentShow = this.module.images[index].show;
      this.$set(this.module.images[index], 'show', !currentShow);
      
      // تاخیر بازگشت به علامت، تضمین کنید که DOM به‌روزرسانی شده است
      this.$nextTick(() => {
        this.isToggling = false;
      });
    },

    addImage() {
      // بستن تمام اسلایدها
      this.module.images.forEach(item => {
        item.show = false;
      });
      
      // اضافه کردن اسلاید جدید
      this.module.images.push({
        image: this.getDefaultImage(), 
        link: {
          type: 'product', 
          value: ''
        },
        button_link: {
          type: 'product',
          value: ''
        },
        title: this.languagesFill(''),
        subtitle: this.languagesFill(''),
        button_text: this.languagesFill(''),
        title_color: '#ffffff',
        subtitle_color: '#ffffff',
        button_color: '#667eea',
        button_text_color: '#ffffff',
        title_size: 24,
        subtitle_size: 16,
        title_align: 'center',
        show: true
      });
      
      this.$message.success('افزودن اسلاید با موفقیت انجام شد');
    },
    
    languagesFill(text) {
      const obj = {};
      $languages.forEach(e => {
        obj[e.code] = text;
      });
      return obj;
    },

    getDefaultImage() {
      return PLACEHOLDER_IMAGE_PATH;
    },

    thumbnail(image, width = 60, height = 40) {
      if (!image) {
        return PLACEHOLDER_IMAGE_URL;
      }
      
      let imageUrl = '';
      
      if (typeof image === 'string') {
        imageUrl = image;
      } else if (typeof image === 'object') {
        const locale = this.currentLocale;
        imageUrl = image[locale] || Object.values(image)[0];
        if (!imageUrl) {
          return PLACEHOLDER_IMAGE_URL;
        }
      }
      
      // اگر URL کامل باشد، مستقیماً برگردانید
      if (imageUrl.indexOf('http') === 0) {
        return imageUrl;
      }
      
      // اگر مسیر نسبی باشد، asset را اضافه کنید
      const fullUrl = asset + imageUrl;
      
      // از تابع image_resize برای تولید تصویر کوچکتر استفاده کنید
      if (typeof image_resize === 'function') {
        return image_resize(fullUrl, width, height);
      }
      
      return fullUrl;
    },

    getTitleText(item) {
      if (!item.title) return '';
      if (typeof item.title === 'string') return item.title;
      if (typeof item.title === 'object' && item.title[this.currentLocale]) {
        return item.title[this.currentLocale].trim();
      }
      return '';
    }
  }
});
</script>
