{{-- ماژول ویرایش محصولات دسته‌بندی --}}
<template id="module-editor-category-products-template">
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
        <text-i18n v-model="form.title"></text-i18n>
      </div>
    </div>

    {{-- تنظیم نمایش --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-setting"></i>
        تنظیمات نمایش
      </div>
      <div class="section-content">
        {{-- تنظیم تعداد نمایش --}}
        <div class="setting-group">
          <div class="setting-label">تعداد محصول در هر سطر</div>
          <div class="segmented-buttons">
            <div 
              :class="['segmented-btn', { active: form.columns === 3 }]" 
              @click="form.columns = 3"
            >
              <i class="el-icon-grid"></i>
              3 عدد
            </div>
            <div 
              :class="['segmented-btn', { active: form.columns === 4 }]" 
              @click="form.columns = 4"
            >
              <i class="el-icon-grid"></i>
              4 عدد
            </div>
            <div 
              :class="['segmented-btn', { active: form.columns === 6 }]" 
              @click="form.columns = 6"
            >
              <i class="el-icon-grid"></i>
              6 عدد
            </div>
          </div>
        </div>

        {{-- تنظیم تعداد محصول --}}
        <div class="setting-group">
          <div class="setting-label">تعداد محصول</div>
          <el-input 
            v-model="form.limit" 
            type="number" 
            size="small" 
            placeholder="لطفاً تعداد محصول را وارد کنید"
            @input="limitChange"
            style="width: 100%;"
          ></el-input>
        </div>
      </div>
    </div>

    {{-- تنظیم دسته‌بندی --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-folder"></i>
        تنظیمات دسته‌بندی
      </div>
      <div class="section-content">
        {{-- دسته‌بندی فعلی انتخاب شده --}}
        <div class="setting-group" v-if="form.category_name">
          <div class="setting-label">دسته‌بندی فعلی</div>
          <div class="selected-category">
            <div class="category-info">
              <i class="el-icon-folder"></i>
              <span class="category-name">${ form.category_name }</span>
            </div>
            <el-button 
              type="text" 
              size="mini" 
              @click="clearCategory"
              style="color: #f56c6c;"
            >
              <i class="el-icon-delete"></i>
              پاک کردن
            </el-button>
          </div>
        </div>

        {{-- جستجوی دسته‌بندی --}}
        <div class="setting-group">
          <div class="setting-label">جستجوی دسته‌بندی</div>
          <div class="autocomplete-group-wrapper">
            <el-autocomplete 
              class="inline-input" 
              v-model="keyword" 
              value-key="name" 
              size="small"
              :fetch-suggestions="querySearch" 
              placeholder="لطفاً کلمه کلیدی را برای جستجوی دسته‌بندی وارد کنید" 
              :highlight-first-item="true"
              @select="handleSelect"
              style="width: 100%;"
            ></el-autocomplete>
          </div>
        </div>

        {{-- تنظیم مرتب‌سازی --}}
        <div class="setting-group">
          <div class="setting-label">روش مرتب‌سازی</div>
          <el-select v-model="form.sort" size="small" style="width: 100%;" @change="onSortChange">
            <el-option label="پرفروش‌ترین" value="sales_desc"></el-option>
            <el-option label="قیمت بالاترین" value="price_desc"></el-option>
            <el-option label="قیمت پایین‌ترین" value="price_asc"></el-option>
            <el-option label="جدیدترین" value="created_desc"></el-option>
            <el-option label="برترین امتیاز" value="rating_desc"></el-option>
            <el-option label="پربازدیدترین" value="viewed_desc"></el-option>
            <el-option label="آخرین به‌روزرسانی" value="updated_desc"></el-option>
            <el-option label="پیش‌فرض" value="position_asc"></el-option>
          </el-select>
        </div>
      </div>
    </div>
  </div>
</template>

{{-- اسکریپت ماژول ویرایش محصولات دسته‌بندی --}}
<script type="text/javascript">
  Vue.component('module-editor-category-products', {
    delimiters: ['${', '}'],
    template: '#module-editor-category-products-template',
    props: ['module'],
    data: function() {
      return {
        keyword: '',
        form: null
      }
    },

    watch: {
      form: {
        handler: function(val) {
          this.$emit('on-changed', val);
        },
        deep: true
      }
    },

    created: function() {
      this.form = JSON.parse(JSON.stringify(this.module));
      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }
      if (!this.form.columns) {
        this.$set(this.form, 'columns', 4);
      }
      if (!this.form.sort) {
        this.$set(this.form, 'sort', 'sales_desc');
      }

      // تنظیم نام دسته‌بندی فعلی در جستجوی خودکار
      if (this.form.category_name) {
        this.keyword = this.form.category_name;
      }
    },

    computed: {},

    methods: {
      querySearch(keyword, cb) {
        let url = 'api/panel/categories/autocomplete';
        if (keyword && keyword.length > 0) {
          url += '?keyword=' + encodeURIComponent(keyword);
        }
        
        axios.get(url, {
          hload: true
        }).then((res) => {
          cb(res.data || []);
        }).catch(() => {
          cb([]);
        });
      },

      handleSelect(item) {
        console.log('انتخاب دسته‌بندی:', item);
        this.form.category_id = item.id;
        this.form.category_name = item.name;
        this.keyword = item.name;

        // تحریک گرفتن به‌روزرسانی فرم
        this.$emit('on-changed', this.form);
      },

      clearCategory() {
        this.form.category_id = '';
        this.form.category_name = '';
        this.keyword = '';
        this.$emit('on-changed', this.form);
      },

      onSortChange() {
        // وقتی تغییر مرتب‌سازی اتفاق می‌افتد، فقط به‌روزرسانی فرم را تحریک کنید
        console.log('روش مرتب‌سازی تغییر کرده است به:', this.form.sort);
        this.$emit('on-changed', this.form);
      },

      limitChange(e) {
        this.form.limit = e;
        // وقتی تغییر تعداد محصول اتفاق می‌افتد، فقط به‌روزرسانی فرم را تحریک کنید
        console.log('تعداد محصول تغییر کرده است به:', this.form.limit);
        this.$emit('on-changed', this.form);
      },


    }
  });
</script> 