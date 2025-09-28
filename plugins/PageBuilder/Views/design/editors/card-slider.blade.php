{{-- ماژول ویرایش اسلایدر کارتی - سبک مدرن --}}
<template id="module-editor-card-slider-template">
  <div class="card-slider-editor">
    <div class="top-spacing"></div>
    
    {{-- تنظیمات عرض ماژول --}}
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

    {{-- تنظیمات نمایش --}}
    <div class="editor-section">
      <div class="section-title">تنظیمات نمایش</div>
      <div class="section-content">
        {{-- تنظیم تعداد آیتم در هر سطر --}}
        <div class="setting-group">
          <div class="setting-label">تعداد آیتم در هر سطر</div>
          <div class="segmented-buttons">
            <div 
              :class="['segmented-btn', { active: form.items_per_row === 2 }]" 
              @click="form.items_per_row = 2"
            >
              2 آیتم
            </div>
            <div 
              :class="['segmented-btn', { active: form.items_per_row === 3 }]" 
              @click="form.items_per_row = 3"
            >
              3 آیتم
            </div>
            <div 
              :class="['segmented-btn', { active: form.items_per_row === 4 }]" 
              @click="form.items_per_row = 4"
            >
              4 آیتم
            </div>
            <div 
              :class="['segmented-btn', { active: form.items_per_row === 6 }]" 
              @click="form.items_per_row = 6"
            >
              6 آیتم
            </div>
          </div>
        </div>

        {{-- تنظیم خودکار چرخش --}}
        <div class="setting-group">
          <div class="setting-label">چرخش خودکار</div>
          <div class="switch-wrapper">
            <el-switch 
              v-model="form.autoplay" 
              @change="onChange"
              :disabled="form.screens.length > 1" 
              active-text="فعال" 
              inactive-text="غیرفعال"
              size="small"
            ></el-switch>
          </div>
          <div v-if="form.screens.length > 1" class="form-tip">
            <i class="el-icon-info"></i>
            لطفاً ابتدا صفحات اضافی را حذف کنید تا چرخش خودکار را غیرفعال کنید
          </div>
        </div>
      </div>
    </div>

    {{-- محتوای محصولات --}}
    <div class="editor-section">
      <div class="section-title">محتوای محصولات</div>
      <div class="section-content">
        <div class="tab-container">
          <el-tabs v-model="activeTab" type="card" @tab-click="handleTabClick" class="custom-tabs">
            <el-tab-pane 
              v-for="(screen, index) in form.screens" 
              :key="index" 
              :label="'صفحه ' + (index + 1)"
              :name="index"
            >
              <div class="screen-content">
                {{-- جستجوی محصولات --}}
                <div class="search-section">
                  <div class="section-subtitle">افزودن محصول</div>
                  <el-autocomplete 
                    class="search-input" 
                    v-model="keyword" 
                    value-key="name" 
                    size="small"
                    :fetch-suggestions="querySearch" 
                    placeholder="لطفاً کلمه کلیدی محصول را وارد کنید" 
                    :highlight-first-item="true"
                    @select="handleSelect"
                    style="width: 100%;"
                  ></el-autocomplete>
                </div>

                {{-- لیست محصولات --}}
                <div class="products-section">
                  <div class="section-subtitle">محصولات انتخاب شده</div>
                  <div class="products-list" v-loading="loading">
                    <template v-if="screen.products.length">
                      <draggable 
                        ghost-class="dragabble-ghost" 
                        :list="screen.products" 
                        @change="itemChange"
                        :options="{ animation: 330 }"
                        class="products-draggable"
                      >
                        <div v-for="(item, index) in screen.products" :key="index" class="product-item">
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
            </el-tab-pane>
          </el-tabs>

          {{-- دکمه‌های عملیات صفحه --}}
          <div class="screen-actions">
            <el-button 
              type="primary" 
              size="small" 
              @click="addScreen" 
              :disabled="!form.autoplay"
              icon="el-icon-plus"
            >
              افزودن صفحه
            </el-button>
            <el-button 
              type="danger" 
              size="small" 
              @click="removeScreen"
              :disabled="form.screens.length <= 1"
              icon="el-icon-delete"
            >
              حذف صفحه فعلی
            </el-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

{{-- ماژول ویرایش محصولات پایتون --}}
<script type="text/javascript">
  Vue.component('module-editor-card-slider', {
    delimiters: ['${', '}'],
    template: '#module-editor-card-slider-template',
    props: ['module'],
    data: function() {
      return {
        keyword: '',
        productData: [],
        loading: null,
        debounceTimer: null,
        form: {
          screens: [{
            products: []
          }],
          items_per_row: 4,
          activeTab: 0,
          autoplay: true,
          width: 'wide',
          title: {}
        },
        activeTab: 0
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

      // گرفتن آرایه screens و اطمینان از آن
      if (!this.form.screens || !Array.isArray(this.form.screens)) {
        this.$set(this.form, 'screens', [{
          products: []
        }]);
      }

      // اطمینان از آرایه products در هر صفحه
      this.form.screens.forEach(screen => {
        if (!screen.products || !Array.isArray(screen.products)) {
          this.$set(screen, 'products', []);
        }
      });

      if (!this.form.items_per_row) {
        this.$set(this.form, 'items_per_row', 4);
      }

      if (typeof this.form.activeTab === 'undefined') {
        this.$set(this.form, 'activeTab', 0);
      }

      if (!this.form.title) {
        this.$set(this.form, 'title', this.languagesFill(''));
      }

      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }

      this.activeTab = this.form.activeTab;
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

      tabTitleLanguage(titles) {
        return titles['zh_cn'];
      },

      tabsValueProductData(tabIndex) {
        var that = this;
        if (!this.form.screens[tabIndex].products.length) return;
        this.loading = true;

        axios.get('api/panel/products/names?ids=' + this.form.screens[tabIndex].products.map(e => e.id).join(
          ','), {
          hload: true
        }).then((res) => {
          this.loading = false;
          that.productData = res.data;
          this.itemChange(that.productData);
        })
      },

      querySearch(keyword, cb) {
        axios.get('api/panel/products/autocomplete?keyword=' + encodeURIComponent(keyword), null, {
          hload: true
        }).then((res) => {
          cb(res.data);
        })
      },

      handleSelect(item) {
        const currentScreen = this.form.screens[this.activeTab];
        if (!currentScreen.products.find(v => v.id == item.id)) {
          currentScreen.products.push(item);
        }
        this.keyword = "";
      },

      itemChange(evt) {
        this.form.screens[this.activeTab].products = evt;
      },

      removeProduct(index) {
        if (this.form.screens[this.activeTab].products.length <= 1) {
          this.$message.warning('هر صفحه باید حداقل یک محصول داشته باشد');
          return;
        }
        this.form.screens[this.activeTab].products.splice(index, 1);
      },

      handleTabClick(tab) {
        this.activeTab = tab.index;
        this.form.activeTab = tab.index;
        this.tabsValueProductData(tab.index);
      },

      addScreen() {
        this.form.screens.push({
          products: []
        });
        this.activeTab = this.form.screens.length - 1;
      },

      removeScreen() {
        if (this.form.screens.length <= 1) {
          this.$message.warning('حداقل یک صفحه باید باقی بماند');
          return;
        }
        this.form.screens.splice(this.activeTab, 1);
        this.activeTab = Math.min(this.activeTab, this.form.screens.length - 1);
      }
    }
  });
</script>
