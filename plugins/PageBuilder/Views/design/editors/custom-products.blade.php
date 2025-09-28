{{-- ماژول ویرایش محصولات سفارشی --}}
<template id="module-editor-custom-products-template">
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
            طولانی
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'wide' }]" 
            @click="form.width = 'wide'"
          >
            <i class="el-icon-copy-document"></i>
            عرض
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'full' }]" 
            @click="form.width = 'full'"
          >
            <i class="el-icon-full-screen"></i>
            کامل
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
      </div>
    </div>

    {{-- تنظیم محصولات --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-shopping-cart-2"></i>
        تنظیم محصولات
      </div>
      <div class="section-content">
        {{-- جستجوی محصولات --}}
        <div class="setting-group">
          <div class="setting-label">جستجوی محصولات</div>
          <div class="autocomplete-group-wrapper">
            <el-autocomplete 
              class="inline-input" 
              v-model="keyword" 
              value-key="name" 
              size="small"
              :fetch-suggestions="querySearch" 
              placeholder="لطفاً کلمه کلیدی را برای جستجو وارد کنید" 
              :highlight-first-item="true"
              @select="handleSelect"
              style="width: 100%;"
            ></el-autocomplete>
          </div>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            محصولات مورد نظر خود را جستجو کرده و اضافه کنید
          </div>
        </div>

        {{-- لیست محصولات انتخاب شده --}}
        <div class="setting-group">
          <div class="setting-label">محصولات انتخاب شده</div>
          <div class="products-list" v-loading="loading">
            <template v-if="productData.length">
              <draggable 
                ghost-class="dragabble-ghost" 
                :list="productData" 
                @change="itemChange"
                :options="{ animation: 330 }"
                class="products-draggable"
              >
                <div v-for="(item, index) in productData" :key="index" class="product-item">
                  <div class="product-info">
                    <div class="drag-handle">
                      <i class="el-icon-rank"></i>
                    </div>
                    <div class="product-preview">
                      <img :src="thumbnail(item.image_big)" class="preview-img">
                    </div>
                    <div class="product-details">
                      <div class="product-name">${ item.name }</div>
                      <div class="product-price">${ item.price_format }</div>
                    </div>
                  </div>
                  <div class="product-actions">
                    <el-button 
                      type="danger" 
                      size="mini" 
                      icon="el-icon-delete" 
                      circle
                      @click="removeProduct(index)"
                    ></el-button>
                  </div>
                </div>
              </draggable>
            </template>
            <div v-else class="empty-state">
              <i class="el-icon-shopping-cart-2"></i>
              <p>هیچ محصولی وجود ندارد، لطفاً در بالا جستجو کرده و اضافه کنید</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

{{-- اسکریپت ویرایش محصولات سفارشی --}}
<script type="text/javascript">
  Vue.component('module-editor-custom-products', {
    delimiters: ['${', '}'],
    template: '#module-editor-custom-products-template',
    props: ['module'],
    data: function() {
      return {
        keyword: '',
        productData: [],
        loading: null,
        debounceTimer: null,
        form: {
          products: [],
          title: {},
          width: 'wide',
          columns: 4
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

      if (!this.form.products || !Array.isArray(this.form.products)) {
        this.$set(this.form, 'products', []);
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

      this.tabsValueProductData();
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
      },

      thumbnail(image) {
        if (!image) {
          return PLACEHOLDER_IMAGE;
        }
        if (typeof image === 'string' && image.indexOf('http') === 0) {
          return image;
        }
        if (typeof image === 'object') {
          const locale = $locale || 'zh_cn';
          return image[locale] || (Object.values(image)[0] || PLACEHOLDER_IMAGE);
        }
        return asset + image;
      },

      tabsValueProductData() {
        var that = this;
        if (!this.form.products.length) return;
        this.loading = true;

        axios.get('api/panel/products/names?ids=' + this.form.products.map(e => e.id).join(','), {
          hload: true
        }).then((res) => {
          this.loading = false;
          that.productData = res.data;
        })
      },

      querySearch(keyword, cb) {
        axios.get('api/panel/products/autocomplete?keyword=' + encodeURIComponent(keyword), null, {
          hload: true
        }).then((res) => {
          cb(res.data);
        }).catch((error) => {
          cb([]);
        })
      },

      handleSelect(item) {
        if (!this.form.products.find(v => v.id == item.id)) {
          this.form.products.push(item);
          this.productData.push(item);
        }
        this.keyword = "";
      },

      itemChange(evt) {
        this.form.products = this.productData;
      },

      removeProduct(index) {
        this.productData.splice(index, 1);
        this.form.products.splice(index, 1);
      }
    }
  });
</script>