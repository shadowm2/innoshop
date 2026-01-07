{{-- ویرایشگر ماژول اسلایدر دسته‌بندی --}}
<script type="text/x-template" id="module-editor-category-carousel-template">
  <div class="module-editor">
    <div class="top-spacing"></div>

    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit"></i>
        عنوان ماژول
      </div>
      <div class="section-content">
        <text-i18n v-model="module.title" @change="onChange" placeholder="عنوان را وارد کنید"></text-i18n>
      </div>
    </div>

    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-picture"></i>
        انتخاب دسته‌بندی‌ها
      </div>
      <div class="section-content">
        <div class="search-section">
          <el-autocomplete
            class="search-input"
            v-model="keyword"
            value-key="name"
            size="small"
            :fetch-suggestions="querySearch"
            placeholder="جستجوی دسته‌بندی..."
            @select="handleSelect"
            style="width: 100%;"
          ></el-autocomplete>
        </div>

        <div class="products-section">
          <div class="section-subtitle">دسته‌بندی‌های انتخاب شده</div>
          <div class="products-list" v-loading="loading">
            <template v-if="module.category_ids && module.category_ids.length">
              <div v-for="(cat, index) in selectedCategories" :key="cat.id" class="product-item">
                <div class="product-info">
                  <div class="product-details">
                    <div class="product-name">${cat.name}</div>
                  </div>
                </div>
                <div class="product-actions">
                  <el-button type="danger" size="mini" icon="el-icon-delete" circle @click="removeCategory(index)"></el-button>
                </div>
              </div>
            </template>
            <div v-else class="empty-state">
              <i class="el-icon-folder-opened"></i>
              <p>هیچ دسته‌بندی انتخاب نشده است</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-brush"></i>
        تنظیمات نمایش
      </div>
      <div class="section-content">
        <div class="setting-group">
          <div class="setting-label">تعداد ستون‌ها</div>
          <div class="segmented-buttons">
            <div :class="['segmented-btn', { active: module.columns === 3 }]" @click="setColumns(3)">3</div>
            <div :class="['segmented-btn', { active: module.columns === 4 }]" @click="setColumns(4)">4</div>
            <div :class="['segmented-btn', { active: module.columns === 6 }]" @click="setColumns(6)">6</div>
          </div>
        </div>

        <div class="setting-group">
          <div class="setting-label">نمایش تصویر</div>
          <div class="switch-wrapper">
            <el-switch v-model="module.showImage" @change="onChange" active-text="نمایش" inactive-text="مخفی" size="small"></el-switch>
          </div>
        </div>

        <div class="setting-group">
          <div class="setting-label">نمایش نام</div>
          <div class="switch-wrapper">
            <el-switch v-model="module.showName" @change="onChange" active-text="نمایش" inactive-text="مخفی" size="small"></el-switch>
          </div>
        </div>

        <div class="setting-group">
          <div class="setting-label">پخش خودکار</div>
          <div class="switch-wrapper">
            <el-switch v-model="module.autoplay" @change="onChange" active-text="فعال" inactive-text="غیرفعال" size="small"></el-switch>
          </div>
        </div>

        <div class="setting-group" v-if="module.autoplay">
          <div class="setting-label">فاصله زمانی پخش (ms)</div>
          <el-input-number v-model="module.autoplaySpeed" @change="onChange" :min="1000" :max="10000" :step="500" size="small" style="width: 100%;"></el-input-number>
        </div>
      </div>
    </div>
  </div>
</script>

<script>
  Vue.component('module-editor-category-carousel', {
    delimiters: ['${', '}'],
    template: '#module-editor-category-carousel-template',
    props: ['module'],
    data: function() {
      return {
        keyword: '',
        loading: false,
        selectedCategories: []
      }
    },

    watch: {
      module: {
        handler: function(val) {
          this.$emit('on-changed', val);
          this.syncSelected();
        },
        deep: true
      }
    },

    created: function() {
      if (!this.module.category_ids) {
        this.$set(this.module, 'category_ids', []);
      }
      if (!this.module.columns) {
        this.$set(this.module, 'columns', 6);
      }
      if (this.module.showImage === undefined) {
        this.$set(this.module, 'showImage', true);
      }
      if (this.module.showName === undefined) {
        this.$set(this.module, 'showName', true);
      }
      if (this.module.autoplay === undefined) {
        this.$set(this.module, 'autoplay', false);
      }
      if (!this.module.autoplaySpeed) {
        this.$set(this.module, 'autoplaySpeed', 3000);
      }

      this.syncSelected();
    },

    methods: {
      onChange() {
        this.$emit('on-changed', this.module);
      },

      querySearch(keyword, cb) {
        if (!keyword || !keyword.trim()) {
          cb([]);
          return;
        }
        axios.get('api/panel/categories/autocomplete?keyword=' + encodeURIComponent(keyword.trim()))
          .then((res) => {
            cb(res.data || []);
          })
          .catch((err) => { cb([]); });
      },

      handleSelect(item) {
        if (!item || !item.id) return;
        if (!this.module.category_ids.includes(item.id)) {
          this.module.category_ids.push(item.id);
          this.selectedCategories.push(item);
          this.onChange();
        }
        this.keyword = '';
      },

      removeCategory(index) {
        const cat = this.selectedCategories[index];
        if (cat) {
          const idIndex = this.module.category_ids.indexOf(cat.id);
          if (idIndex >= 0) this.module.category_ids.splice(idIndex, 1);
        }
        this.selectedCategories.splice(index, 1);
        this.onChange();
      },

      setColumns(n) {
        this.module.columns = n;
        this.onChange();
      },

      syncSelected() {
        // request category data for saved ids
        if (!this.module.category_ids || !this.module.category_ids.length) {
          this.selectedCategories = [];
          return;
        }
        axios.post('api/panel/categories/get-list-by-ids', { ids: this.module.category_ids })
          .then((res) => {
            this.selectedCategories = res.data || [];
          })
          .catch(() => {
            this.selectedCategories = [];
          })
      }
    }
  });
</script>
