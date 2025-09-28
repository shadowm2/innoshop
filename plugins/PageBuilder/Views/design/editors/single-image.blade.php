{{-- ماژول ویرایش تصویر تکی - سبک مدرن --}}
<template id="module-editor-single-image-template">
  <div class="image-editor">
    <div class="top-spacing"></div>
    
    {{-- تنظیم عرض ماژول --}}
    <div class="editor-section">
      <div class="section-title">عرض ماژول</div>
      <div class="section-content">
        <div class="segmented-buttons">
          <div 
            :class="['segmented-btn', { active: module.width === 'narrow' }]" 
            @click="setModuleWidth('narrow')"
          >
            طولانی
          </div>
          <div 
            :class="['segmented-btn', { active: module.width === 'wide' }]" 
            @click="setModuleWidth('wide')"
          >
            عرضی
          </div>
          <div 
            :class="['segmented-btn', { active: module.width === 'full' }]" 
            @click="setModuleWidth('full')"
          >
            کامل
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیمات تصویر --}}
    <div class="editor-section">
      <div class="section-title">تنظیمات تصویر</div>
      <div class="section-content">
        <div class="image-selector-wrapper">
          <single-image-selector 
            v-model="module.images[0].image" 
            :aspectRatio="2.0833" 
            :targetWidth="1000"
            :targetHeight="480"
            @change="onChange"
          ></single-image-selector>
          <div class="image-tips">پیشنهادات اندازه (عرض × ارتفاع): 1000 x 480</div>
        </div>
      </div>
    </div>

    {{-- تنظیم پیوند --}}
    <div class="editor-section">
      <div class="section-title">انتخاب پیوند</div>
      <div class="section-content">
        <link-selector 
          :hide-types="['catalog', 'static']" 
          v-model="module.images[0].link"
          @change="onChange"
        ></link-selector>
      </div>
    </div>
  </div>
</template>

{{-- اسکریپت ویرایشگر تصویر تکی --}}
<script type="text/javascript">
  Vue.component('module-editor-single-image', {
    template: '#module-editor-single-image-template',
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
      // تنظیم مقادیر پیش‌فرض
      if (!this.module.images) {
        this.module.images = [{
          image: this.languagesFill(''),
          link: {
            type: 'product',
            value: ''
          }
        }];
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

      setModuleWidth(width) {
        this.$set(this.module, 'width', width);
        this.onChange();
      },

      languagesFill(text) {
        const obj = {};
        $languages.forEach(e => {
          obj[e.code] = text;
        });
        return obj;
      },

      thumbnail(image) {
        if (!image) {
          return PLACEHOLDER_IMAGE;
        }
        if (typeof image === 'string' && image.indexOf('http') === 0) {
          return image;
        }
        if (typeof image === 'object') {
          const locale = this.source.locale;
          return image[locale] || (Object.values(image)[0] || PLACEHOLDER_IMAGE);
        }
        return asset + image;
      }
    }
  });
</script>

<style scoped>
.top-spacing {
  height: 18px;
}

.image-editor {
  padding: 0;
}

.editor-section {
  margin-bottom: 16px;
  border-bottom: 1px solid #f0f0f0;
  padding-bottom: 16px;
}

.editor-section:last-child {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}

.section-title {
  font-size: 13px;
  font-weight: 500;
  color: #333;
  margin-bottom: 8px;
  padding-left: 8px;
  border-left: 3px solid #667eea;
}

.section-content {
  padding: 0;
}

/* طراحی دکمه‌های جداکننده */
.segmented-buttons {
  display: flex;
  border: 1px solid #ddd;
  border-radius: 4px;
  overflow: hidden;
}

.segmented-btn {
  flex: 1;
  padding: 6px 12px;
  text-align: center;
  font-size: 12px;
  cursor: pointer;
  background: #fff;
  color: #666;
  border-right: 1px solid #ddd;
  transition: all 0.2s ease;
}

.segmented-btn:last-child {
  border-right: none;
}

.segmented-btn:hover {
  background: #f5f5f5;
}

.segmented-btn.active {
  background: #667eea;
  color: #fff;
}

.image-selector-wrapper {
  margin-bottom: 8px;
}

.image-tips {
  font-size: 11px;
  color: #999;
  margin-top: 4px;
}

/* طراحی پاسخگو */
@media (max-width: 768px) {
  .editor-section {
    margin-bottom: 12px;
    padding-bottom: 12px;
  }
  
  .section-title {
    font-size: 12px;
    margin-bottom: 6px;
  }
  
  .segmented-btn {
    padding: 5px 8px;
    font-size: 11px;
  }
}
</style>