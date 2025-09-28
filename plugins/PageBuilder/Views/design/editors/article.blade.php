{{-- ماژول ویرایش مقاله - سبک مدرن --}}
<template id="module-editor-article-template">
  <div class="article-editor">
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
            @click="setModuleWidth('narrow')"
          >
            عرض کوتاه
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'wide' }]" 
            @click="setModuleWidth('wide')"
          >
            عرض وسیع
          </div>
          <div 
            :class="['segmented-btn', { active: form.width === 'full' }]" 
            @click="setModuleWidth('full')"
          >
            تمام صفحه
          </div>
        </div>
      </div>
    </div>

    {{-- عنوان ماژول --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit"></i>
        عنوان ماژول
      </div>
      <div class="section-content">
        <text-i18n 
          v-model="form.title" 
          @change="onChange" 
          placeholder="لطفا عنوان ماژول را وارد کنید"
        ></text-i18n>
      </div>
    </div>

    {{-- زیر عنوان --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit-outline"></i>
        زیر عنوان
      </div>
      <div class="section-content">
        <text-i18n 
          v-model="form.subtitle" 
          @change="onChange" 
          placeholder="لطفا زیر عنوان را وارد کنید"
        ></text-i18n>
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
                      @click="setColumns(3)"
                    >
                      3 آیتم
                    </div>
                    <div
                      :class="['segmented-btn', { active: form.columns === 4 }]"
                      @click="setColumns(4)"
                    >
                      4 آیتم
                    </div>
                  </div>
                </div>
      </div>
    </div>

    {{-- مدیریت مقالات --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-document"></i>
        مدیریت مقالات
      </div>
      <div class="section-content">
        <div class="setting-tip">
          <i class="el-icon-info"></i>
          پشتیبانی از رها کردن برای مرتب سازی، می‌توانید چند مقاله را اضافه کنید
        </div>

        <div class="search-section">
          <el-autocomplete 
            v-model="keyword" 
            value-key="name" 
            size="small"
            :fetch-suggestions="querySearch" 
            placeholder="لطفا کلمه کلیدی مقاله را وارد کنید" 
            :highlight-first-item="true"
            @select="handleSelect" 
            style="width: 100%;"
          >
          </el-autocomplete>
        </div>

        <div class="articles-section" v-loading="loading">
          <template v-if="articleData.length">
            <draggable 
              ghost-class="dragabble-ghost" 
              :list="articleData" 
              @change="itemChange"
              :options="{ animation: 330, handle: '.drag-handle' }"
            >
              <div v-for="(item, index) in articleData" :key="index" class="article-item">
                <div class="article-info">
                  <el-tooltip class="drag-handle" effect="dark" content="رها کردن برای مرتب سازی" placement="left">
                    <i class="el-icon-rank"></i>
                  </el-tooltip>
                  <i class="el-icon-document"></i>
                  <span class="article-title">@{{ item.name }}</span>
                </div>
                <div class="article-actions">
                  <el-tooltip effect="dark" content="حذف" placement="left">
                    <div class="remove-btn" @click="removeArticle(index)">
                      <i class="el-icon-delete"></i>
                    </div>
                  </el-tooltip>
                </div>
              </div>
            </draggable>
          </template>
          <template v-else>
            <div class="empty-state">
              <i class="el-icon-document"></i>
              <p>هیچ مقاله‌ای وجود ندارد</p>
              <span>لطفا جستجو کرده و مقاله اضافه کنید</span>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

{{-- اسکریپت ویرایش ماژول مقاله --}}
<script type="text/javascript">
  Vue.component('module-editor-article', {
    template: '#module-editor-article-template',
    props: ['module'],
    data: function() {
      return {
        debounceTimer: null,
        keyword: '',
        articleData: [],
        loading: false,
        form: {
          title: {},
          subtitle: {},
          articles: [],
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

      if (!this.form.title) {
        this.$set(this.form, 'title', this.languagesFill(''));
      }

      if (!this.form.subtitle) {
        this.$set(this.form, 'subtitle', this.languagesFill(''));
      }

      if (!this.form.articles) {
        this.$set(this.form, 'articles', []);
      }

      if (!this.form.width) {
        this.$set(this.form, 'width', 'wide');
      }

      if (!this.form.columns) {
        this.$set(this.form, 'columns', 4);
      }

      this.loadArticles();
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

      setColumns(columns) {
        this.$set(this.form, 'columns', columns);
        this.onChange();
      },

      setModuleWidth(width) {
        this.$set(this.form, 'width', width);
        this.onChange();
      },

      loadArticles() {
        if (!this.form.articles.length) return;
        this.loading = true;

        axios.get('api/panel/articles/names?ids=' + this.form.articles.map(e => e.id).join(','), {
          headers: {
            
          }
        }).then((res) => {
          this.loading = false;
          this.articleData = res.data;
        }).catch(() => {
          this.loading = false;
        });
      },

      querySearch(keyword, cb) {
        axios.get('api/panel/articles/autocomplete?keyword=' + encodeURIComponent(keyword), {
          headers: {
            
          }
        }).then((res) => {
          cb(res.data);
        }).catch(() => {
          cb([]);
        });
      },

      handleSelect(item) {
        if (!this.form.articles.find(v => v.id === item.id)) {
          this.form.articles.push(item);
          this.articleData.push(item);
        } else {
          this.$message.warning('این مقاله قبلا اضافه شده است');
        }
        this.keyword = "";
      },

      itemChange(evt) {
        this.form.articles = this.articleData;
      },

      removeArticle(index) {
        this.articleData.splice(index, 1);
        this.form.articles.splice(index, 1);
      }
    }
  });
</script>

<style>
  /* خصوصیات ویرایشگر مقاله */
  
  .search-section {
    margin-bottom: 16px;
  }

  .articles-section {
    min-height: 120px;
  }

  .article-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    background: #f8f9fa;
    transition: all 0.3s ease;
    margin-bottom: 12px;
  }

  .article-item:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
    transform: translateY(-1px);
  }

  .article-info {
    display: flex;
    align-items: center;
    flex: 1;
    gap: 12px;
  }

  .drag-handle {
    cursor: move;
    color: #999;
    font-size: 14px;
    padding: 4px;
    border-radius: 4px;
    transition: all 0.2s ease;
  }

  .drag-handle:hover {
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
  }

  .article-title {
    font-size: 14px;
    color: #333;
    font-weight: 500;
    flex: 1;
  }

  .article-actions {
    display: flex;
    align-items: center;
  }

  .remove-btn {
    cursor: pointer;
    color: #dc3545;
    padding: 6px;
    border-radius: 4px;
    transition: all 0.2s ease;
  }

  .remove-btn:hover {
    background: rgba(220, 53, 69, 0.1);
    transform: scale(1.1);
  }

  .empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #999;
  }

  .empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    display: block;
    color: #ccc;
  }

  .empty-state p {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 500;
  }

  .empty-state span {
    font-size: 14px;
    color: #bbb;
  }

  .setting-tip {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 16px;
    font-size: 13px;
    color: #666;
  }

  .setting-tip i {
    color: #667eea;
    margin-right: 6px;
  }
</style>