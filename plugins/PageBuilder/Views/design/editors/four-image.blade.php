{{-- ماژول ویرایش چهار تصویر در یک ردیف - سبک مدرن --}}
<template id="module-editor-four-image-template">
  <div class="four-image-editor">
    <div class="top-spacing"></div>
    
    {{-- تنظیم عرض ماژول --}}
    <div class="editor-section">
      <div class="section-title">عرض ماژول</div>
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

    {{-- عنوان ماژول --}}
    <div class="editor-section">
      <div class="section-title">عنوان ماژول</div>
      <div class="section-content">
        <text-i18n v-model="form.title" @change="onChange" placeholder="لطفا عنوان ماژول را وارد کنید"></text-i18n>
      </div>
    </div>

    {{-- زیر عنوان --}}
    <div class="editor-section">
      <div class="section-title">زیر عنوان</div>
      <div class="section-content">
        <text-i18n v-model="form.subtitle" @change="onChange" placeholder="لطفا زیر عنوان را وارد کنید"></text-i18n>
      </div>
    </div>

    {{-- تنظیم تصاویر --}}
    <div class="editor-section">
      <div class="section-title">تنظیم تصاویر</div>
      <div class="section-content">
        <div class="setting-tip">
          <i class="el-icon-info"></i>
          پیشنهاد می‌شود تصاویر یکسان را بارگذاری کنید، بهترین اندازه 400x400، پشتیبانی از رها کردن برای مرتب‌سازی
        </div>

        <draggable ghost-class="dragabble-ghost" :list="form.images"
          :options="{ animation: 330, handle: '.icon-rank' }">
          <div class="image-item" v-for="(item, index) in form.images" :key="index">
            <div class="image-header" @click="itemShow(index)">
              <div class="image-info">
                <el-tooltip class="drag-handle" effect="dark" content="رها کردن برای مرتب‌سازی" placement="left">
                  <i class="el-icon-rank"></i>
                </el-tooltip>
                <img :src="thumbnail(item.image[source.locale])" class="image-preview">
                <span class="image-label">تصویر @{{ index + 1 }}</span>
              </div>
              <div class="image-actions">
                <el-tooltip effect="dark" content="حذف" placement="left">
                  <div class="remove-btn" @click.stop="removeImage(index)">
                    <i class="el-icon-delete"></i>
                  </div>
                </el-tooltip>
                <i :class="'el-icon-arrow-' + (item.show ? 'up' : 'down')"></i>
              </div>
            </div>
            <div :class="'image-content ' + (item.show ? 'active' : '')">
              <div class="image-upload-section">
                <single-image-selector v-model="item.image" :aspectRatio="1" :targetWidth="400"
                  :targetHeight="400"></single-image-selector>
                <div class="upload-tip">پیشنهادی: 400 x 400، نسبت تصویر 1:1</div>
              </div>
              <div class="image-settings">
                <div class="setting-group">
                  <div class="setting-label">توضیحات تصویر</div>
                  <text-i18n v-model="item.description" @change="onChange" placeholder="لطفا توضیحات تصویر را وارد کنید"></text-i18n>
                </div>
                <div class="setting-group">
                  <div class="setting-label">پیوند تصویر</div>
                  <link-selector :hide-types="['catalog', 'static']" v-model="item.link" @change="onChange"></link-selector>
                </div>
              </div>
            </div>
          </div>
        </draggable>

        <div class="add-image-section" v-if="form.images.length < 4">
          <el-button type="primary" size="small" @click="addImage" icon="el-icon-circle-plus-outline">
            افزودن تصویر (@{{ form.images.length }}/4)
          </el-button>
        </div>
      </div>
    </div>
  </div>
</template>

{{-- اسکریپت ماژول ویرایش چهار تصویر --}}
<script type="text/javascript">
  Vue.component('module-editor-four-image', {
    template: '#module-editor-four-image-template',
    props: ['module'],
    data: function() {
      return {
        debounceTimer: null,
        form: {
          title: {},
          subtitle: {},
          images: [],
          width: 'wide'
        },
        source: {
          locale: $locale
        }
      }
    },
    watch: {
      form: {
        handler: function(val) {
          this.onChange();
        },
        deep: true
      }
    },
    created: function() {
      if (this.module) {
        this.form = JSON.parse(JSON.stringify(this.module));
      }

      if (!this.form.title) {
        this.$set(this.form, 'title', this.languagesFill(''));
      }

      if (!this.form.subtitle) {
        this.$set(this.form, 'subtitle', this.languagesFill(''));
      }

      if (!this.form.images) {
        this.$set(this.form, 'images', []);
      }

      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }

      this.$emit('on-changed', this.form);
    },
    methods: {
      onChange() {
        // پاک کردن زمان‌بندی قبلی
        if (this.debounceTimer) {
          clearTimeout(this.debounceTimer);
        }
        
        // تنظیم زمان‌بندی جدید
        this.debounceTimer = setTimeout(() => {
          this.$emit('on-changed', this.form);
        }, 300);
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
          return PLACEHOLDER_IMAGE_URL;
        }
        if (typeof image === 'string' && image.indexOf('http') === 0) {
          return image;
        }
        if (typeof image === 'object') {
          const locale = this.source.locale;
          return image[locale] || (Object.values(image)[0] || PLACEHOLDER_IMAGE_URL);
        }
        return PLACEHOLDER_IMAGE_URL;
      },
      addImage() {
        if (this.form.images.length >= 4) {
          this.$message.warning('حداکثر می‌توانید 4 تصویر اضافه کنید');
          return;
        }
        this.form.images.push({
          image: this.languagesFill(''),
          description: this.languagesFill(''),
          link: {
            type: 'product',
            value: ''
          },
          show: true
        });
      },
      removeImage(index) {
        this.form.images.splice(index, 1);
      },
      itemShow(index) {
        this.form.images[index].show = !this.form.images[index].show;
      }
    }
  });
</script>
