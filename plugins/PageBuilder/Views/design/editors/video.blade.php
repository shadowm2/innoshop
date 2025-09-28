{{-- ماژول ویرایش ویدیو - سبک مدرن --}}
<template id="module-editor-video-template">
  <div class="video-editor">
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
            @click="setModuleWidth('narrow')"
          >
            عرض کوتاه
          </div>
          <div 
            :class="['segmented-btn', { active: module.width === 'wide' }]" 
            @click="setModuleWidth('wide')"
          >
            عرض وسیع
          </div>
          <div 
            :class="['segmented-btn', { active: module.width === 'full' }]" 
            @click="setModuleWidth('full')"
          >
            تمام صفحه
          </div>
        </div>
      </div>
    </div>

    {{-- انتخاب نوع ویدیو --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-video-camera"></i>
        نوع ویدیو
      </div>
      <div class="section-content">
        <div class="segmented-buttons">
          <div 
            :class="['segmented-btn', { active: module.videoType === 'local' }]" 
            @click="setVideoType('local')"
          >
            ویدیو محلی
          </div>
          <div 
            :class="['segmented-btn', { active: module.videoType === 'youtube' }]" 
            @click="setVideoType('youtube')"
          >
            YouTube
          </div>
          <div 
            :class="['segmented-btn', { active: module.videoType === 'vimeo' }]" 
            @click="setVideoType('vimeo')"
          >
            Vimeo
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیمات ویدیو محلی --}}
    <div class="editor-section" v-if="module.videoType === 'local'">
      <div class="section-title">
        <i class="el-icon-upload"></i>
        فایل ویدیو
      </div>
      <div class="section-content">
        <div class="video-upload-wrapper">
          <div class="upload-area" @click="openVideoSelector">
            <div v-if="!module.videoUrl" class="upload-placeholder">
              <i class="el-icon-video-camera"></i>
              <p>برای انتخاب فایل ویدیو کلیک کنید</p>
              <span class="upload-tip">پشتیبانی می‌شود: MP4, WebM, OGV فرمت</span>
            </div>
            <div v-else class="video-preview">
              <video 
                :src="module.videoUrl" 
                controls 
                preload="metadata"
                class="preview-video"
              ></video>
              <div class="video-info">
                <span class="video-name">@{{ getVideoFileName(module.videoUrl) }}</span>
                <el-button 
                  type="danger" 
                  size="mini" 
                  icon="el-icon-delete" 
                  @click.stop="removeVideo"
                ></el-button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیمات ویدیو آنلاین --}}
    <div class="editor-section" v-if="module.videoType === 'youtube' || module.videoType === 'vimeo'">
      <div class="section-title">
        <i class="el-icon-link"></i>
        لینک‌های ویدیو
      </div>
      <div class="section-content">
        <div class="video-url-wrapper">
          <el-input 
            v-model="module.videoUrl" 
            :placeholder="getVideoUrlPlaceholder()"
            @change="onChange"
            size="small"
          >
            <template slot="prepend">
              <i :class="getVideoIcon()"></i>
            </template>
          </el-input>
          <div class="url-tips">
            @{{ getVideoUrlTips() }}
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیمات تصویر کاور ویدیو --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-picture"></i>
        تصویر کاور ویدیو
      </div>
      <div class="section-content">
        <div class="cover-image-wrapper">
          <single-image-selector 
            v-model="module.coverImage" 
            :aspectRatio="16/9" 
            :targetWidth="1280"
            :targetHeight="720"
            @change="onChange"
          ></single-image-selector>
          <div class="cover-tips">
            <i class="el-icon-info"></i>
            پیشنهاد: 1280 x 720 (نسبت ارتفاع به عرض 16:9)
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیمات کنترل ویدیو --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-setting"></i>
        کنترل پخش
      </div>
      <div class="section-content">
        <div class="control-settings">
          {{-- خودکار پخش --}}
          <div class="setting-item">
            <div class="setting-label">خودکار پخش</div>
            <div class="setting-control">
              <el-switch 
                v-model="module.autoplay" 
                @change="onChange"
                active-text="فعال" 
                inactive-text="غیرفعال"
                size="small"
              ></el-switch>
            </div>
          </div>

          {{-- پخش مداوم --}}
          <div class="setting-item">
            <div class="setting-label">پخش مداوم</div>
            <div class="setting-control">
              <el-switch 
                v-model="module.loop" 
                @change="onChange"
                active-text="فعال" 
                inactive-text="غیرفعال"
                size="small"
              ></el-switch>
            </div>
          </div>

          {{-- صدای ساده پخش --}}
          <div class="setting-item">
            <div class="setting-label">صدای ساده پخش</div>
            <div class="setting-control">
              <el-switch 
                v-model="module.muted" 
                @change="onChange"
                active-text="فعال" 
                inactive-text="غیرفعال"
                size="small"
              ></el-switch>
            </div>
          </div>

          {{-- نمایش خط کنترل --}}
          <div class="setting-item">
            <div class="setting-label">نمایش خط کنترل</div>
            <div class="setting-control">
              <el-switch 
                v-model="module.controls" 
                @change="onChange"
                active-text="نمایش" 
                inactive-text="مخفی"
                size="small"
              ></el-switch>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- عنوان ویدیو --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit"></i>
        عنوان ویدیو
      </div>
      <div class="section-content">
        <text-i18n 
          v-model="module.title" 
          @change="onChange" 
          placeholder="لطفاً عنوان ویدیو را وارد کنید"
        ></text-i18n>
      </div>
    </div>

    {{-- توضیح ویدیو --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-document"></i>
        توضیح ویدیو
      </div>
      <div class="section-content">
        <text-i18n 
          v-model="module.description" 
          @change="onChange" 
          placeholder="لطفاً توضیح ویدیو را وارد کنید"
          type="textarea"
          :rows="3"
        ></text-i18n>
      </div>
    </div>
  </div>
</template>

{{-- اسکریپت ویرایش ماژول ویدیو --}}
<script type="text/javascript">
  Vue.component('module-editor-video', {
    template: '#module-editor-video-template',
    props: ['module'],
    
    data: function() {
      return {
        debounceTimer: null,
        source: {
          locale: $locale
        }
      }
    },

    watch: {
      module: {
        handler: function(val) {
          this.onChange();
        },
        deep: true,
      }
    },

    created: function() {
      // مقداردهی اولیه پیش‌فرض
      if (!this.module.videoType) {
        this.$set(this.module, 'videoType', 'local');
      }
      if (!this.module.videoUrl) {
        this.$set(this.module, 'videoUrl', '');
      }
      if (!this.module.coverImage) {
        this.$set(this.module, 'coverImage', this.languagesFill(''));
      }
      if (!this.module.title) {
        this.$set(this.module, 'title', this.languagesFill(''));
      }
      if (!this.module.description) {
        this.$set(this.module, 'description', this.languagesFill(''));
      }
      if (!this.module.autoplay) {
        this.$set(this.module, 'autoplay', false);
      }
      if (!this.module.loop) {
        this.$set(this.module, 'loop', false);
      }
      if (!this.module.muted) {
        this.$set(this.module, 'muted', false);
      }
      if (!this.module.controls) {
        this.$set(this.module, 'controls', true);
      }
      if (!this.module.width) {
        this.$set(this.module, 'width', 'wide');
      }
    },

    methods: {
      onChange() {
        // پاک کردن زمانبندی قبلی
        if (this.debounceTimer) {
          clearTimeout(this.debounceTimer);
        }
        
        // تنظیم زمانبندی جدید
        this.debounceTimer = setTimeout(() => {
          this.$emit('on-changed', this.module);
        }, 300);
      },

      setModuleWidth(width) {
        this.$set(this.module, 'width', width);
        this.onChange();
      },

      setVideoType(type) {
        this.$set(this.module, 'videoType', type);
        this.$set(this.module, 'videoUrl', '');
        this.onChange();
      },

      openVideoSelector() {
        // اینجا باید ابزار انتخاب فایل را پیاده‌سازی کنید
        // در حال حاضر از ورودی فایل ساده استفاده می‌شود
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'video/*';
        input.onchange = (e) => {
          const file = e.target.files[0];
          if (file) {
            // اینجا فایل را باید آپلود کرده و آدرس URL را دریافت کنید
            // در حال حاضر از آدرس URL محلی استفاده می‌شود
            this.$set(this.module, 'videoUrl', URL.createObjectURL(file));
            this.onChange();
          }
        };
        input.click();
      },

      removeVideo() {
        this.$set(this.module, 'videoUrl', '');
        this.onChange();
      },

      getVideoFileName(url) {
        if (!url) return '';
        const parts = url.split('/');
        return parts[parts.length - 1] || 'video.mp4';
      },

      getVideoUrlPlaceholder() {
        switch (this.module.videoType) {
          case 'youtube':
            return 'لطفاً لینک YouTube را وارد کنید، مثل: https://www.youtube.com/watch?v=VIDEO_ID';
          case 'vimeo':
            return 'لطفاً لینک Vimeo را وارد کنید، مثل: https://vimeo.com/VIDEO_ID';
          default:
            return 'لطفاً لینک‌های ویدیو را وارد کنید';
        }
      },

      getVideoUrlTips() {
        switch (this.module.videoType) {
          case 'youtube':
            return 'پشتیبانی می‌شود: لینک‌های پخش یا لینک‌های گذاشته شده';
          case 'vimeo':
            return 'پشتیبانی می‌شود: لینک‌های پخش یا لینک‌های گذاشته شده';
          default:
            return '';
        }
      },

      getVideoIcon() {
        switch (this.module.videoType) {
          case 'youtube':
            return 'el-icon-video-play';
          case 'vimeo':
            return 'el-icon-video-camera';
          default:
            return 'el-icon-video-camera';
        }
      },

      languagesFill(text) {
        const obj = {};
        $languages.forEach(e => {
          obj[e.code] = text;
        });
        return obj;
      }
    }
  });
</script> 