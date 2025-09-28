{{-- ماژول ویرایش جدیدترین محصولات --}}
<template id="module-editor-latest-products-template">
  <div class="editor-container">
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
            <i class="el-icon-copy-document"></i>
            عرض کوتاه
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'wide' }]" 
            @click="form.width = 'wide'"
          >
            <i class="el-icon-copy-document"></i>
            عرض کامل
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'full' }]" 
            @click="form.width = 'full'"
          >
            <i class="el-icon-full-screen"></i>
            تمام صفحه
          </div>
        </div>
      </div>
    </div>

    {{-- تنظیم عنوان ماژول --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit"></i>
        عنوان ماژول
      </div>
      <div class="section-content">
        <text-i18n v-model="form.title" @change="onChange" placeholder="لطفاً عنوان ماژول را وارد کنید"></text-i18n>
      </div>
    </div>

    {{-- تنظیم نمایش --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-setting"></i>
        تنظیمات نمایش
      </div>
      <div class="section-content">
        {{-- تنظیم تعداد آیتم در هر سطر --}}
        <div class="setting-group">
          <div class="setting-label">تعداد آیتم در هر سطر</div>
          <div class="segmented-buttons">
            <div 
              :class="['segmented-btn', { active: form.columns === 3 }]" 
              @click="form.columns = 3"
            >
              <i class="el-icon-grid"></i>
              3 آیتم
            </div>
            <div 
              :class="['segmented-btn', { active: form.columns === 4 }]" 
              @click="form.columns = 4"
            >
              <i class="el-icon-grid"></i>
              4 آیتم
            </div>
            <div 
              :class="['segmented-btn', { active: form.columns === 6 }]" 
              @click="form.columns = 6"
            >
              <i class="el-icon-grid"></i>
              6 آیتم
            </div>
          </div>
        </div>

        {{-- تنظیم تعداد آیتم --}}
        <div class="setting-group">
          <div class="setting-label">تعداد آیتم</div>
          <el-input 
            v-model="form.limit" 
            type="number" 
            size="small" 
            placeholder="لطفاً تعداد آیتم را وارد کنید"
            style="width: 100%;"
          ></el-input>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            نمایش آیتم‌های جدیدترین محصولات
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

{{-- اسکریپت ویرایش ماژول جدیدترین محصولات --}}
<script type="text/javascript">
  Vue.component('module-editor-latest-products', {
    delimiters: ['${', '}'],
    template: '#module-editor-latest-products-template',
    props: ['module'],
    data: function() {
      return {
        debounceTimer: null,
        form: {
          title: {},
          limit: 8,
          columns: 4,
          width: 'wide'
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

      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }

      if (!this.form.columns) {
        this.$set(this.form, 'columns', 4);
      }

      if (!this.form.limit) {
        this.$set(this.form, 'limit', 8);
      }

      this.$emit('on-changed', this.form);
    },

    methods: {
      onChange() {
        // پاک کردن زمانبندی قبلی
        if (this.debounceTimer) {
          clearTimeout(this.debounceTimer);
        }
        
        // تنظیم زمانبندی جدید
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
      }
    }
  });
</script> 