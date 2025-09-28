{{-- ماژول ویرایش لیست تصویر-متن - سبک مدرن --}}
<template id="module-editor-image-text-list-template">
  <div class="image-text-list-editor">
    <div class="top-spacing"></div>
    
    {{-- تنظیمات عرض ماژول --}}
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
            ضعیف
          </div>
          <div 
            :class="['segmented-btn', { active: module.width === 'wide' }]" 
            @click="setModuleWidth('wide')"
          >
            عریض
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

    {{-- عنوان ماژول --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-edit"></i>
        عنوان ماژول
      </div>
      <div class="section-content">
        <text-i18n 
          v-model="module.title" 
          @change="onChange" 
          placeholder="لطفا عنوان ماژول را وارد کنید"
        ></text-i18n>
      </div>
    </div>

    {{-- تنظیمات نمایش --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-setting"></i>
        تنظیمات نمایش
      </div>
      <div class="section-content">
        {{-- تنظیم آیتم در هر ردیف --}}
        <div class="setting-group">
          <div class="setting-label">آیتم در هر ردیف</div>
          <div class="segmented-buttons">
            <div 
              :class="['segmented-btn', { active: module.columns === 3 }]" 
              @click="setColumns(3)"
            >
              3
            </div>
            <div 
              :class="['segmented-btn', { active: module.columns === 4 }]" 
              @click="setColumns(4)"
            >
              4
            </div>
            <div 
              :class="['segmented-btn', { active: module.columns === 5 }]" 
              @click="setColumns(5)"
            >
              5
            </div>
            <div 
              :class="['segmented-btn', { active: module.columns === 6 }]" 
              @click="setColumns(6)"
            >
              6
            </div>
          </div>
        </div>

        {{-- تنظیمات خودکار پخش --}}
        <div class="setting-group">
          <div class="setting-label">خودکار پخش</div>
          <div class="switch-wrapper">
            <el-switch 
              v-model="module.autoplay" 
              @change="onChange"
              active-text="فعال" 
              inactive-text="غیرفعال"
              size="small"
            ></el-switch>
          </div>
        </div>

        {{-- زمان پخش خودکار --}}
        <div class="setting-group" v-if="module.autoplay">
          <div class="setting-label">زمان پخش خودکار</div>
          <el-input-number 
            v-model="module.autoplaySpeed" 
            @change="onChange"
            :min="1000" 
            :max="10000" 
            :step="500"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            واحد: میلی ثانیه، پیشنهاد 3000-5000
          </div>
        </div>

        {{-- نمایش عناوین --}}
        <div class="setting-group">
          <div class="setting-label">نمایش عناوین</div>
          <div class="switch-wrapper">
            <el-switch 
              v-model="module.showNames" 
              @change="onChange"
              active-text="نمایش" 
              inactive-text="مخفی"
              size="small"
            ></el-switch>
          </div>
        </div>

        {{-- تنظیم ارتفاع تصویر --}}
        <div class="setting-group">
          <div class="setting-label">ارتفاع تصویر</div>
          <el-input-number 
            v-model="module.itemHeight" 
            @change="onChange"
            :min="60" 
            :max="300" 
            :step="10"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            واحد: پیکسل، پیشنهاد 80-200
          </div>
        </div>

        {{-- تنظیم پدینگ --}}
        <div class="setting-group">
          <div class="setting-label">پدینگ</div>
          <el-input-number 
            v-model="module.padding" 
            @change="onChange"
            :min="0" 
            :max="40" 
            :step="2"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            واحد: پیکسل، 0 برای پدینگ صفر، کنترل فاصله بین تصویر/متن و لبه‌های کارت
          </div>
        </div>

        {{-- گرد کردن لبه --}}
        <div class="setting-group">
          <div class="setting-label">گرد کردن لبه</div>
          <el-input-number 
            v-model="module.borderRadius" 
            @change="onChange"
            :min="0" 
            :max="50" 
            :step="1"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            واحد: پیکسل، 0 برای لبه‌های حداکثر، پیشنهاد 4-16
          </div>
        </div>

        {{-- عرض خط --}}
        <div class="setting-group">
          <div class="setting-label">عرض خط</div>
          <el-input-number 
            v-model="module.borderWidth" 
            @change="onChange"
            :min="0" 
            :max="10" 
            :step="1"
            size="small"
            style="width: 100%;"
          ></el-input-number>
          <div class="setting-tip">
            <i class="el-icon-info"></i>
            واحد: پیکسل، 0 برای خط صفر
          </div>
        </div>

        {{-- رنگ خط --}}
        <div class="setting-group">
          <div class="setting-label">رنگ خط</div>
          <el-color-picker 
            v-model="module.borderColor" 
            @change="onChange"
            size="small"
            style="width: 100%;"
            show-alpha
          ></el-color-picker>
        </div>

        {{-- سبک خط --}}
        <div class="setting-group">
          <div class="setting-label">سبک خط</div>
          <el-select 
            v-model="module.borderStyle" 
            @change="onChange"
            size="small"
            style="width: 100%;"
          >
            <el-option label="پیوسته" value="solid"></el-option>
            <el-option label="چینه" value="dashed"></el-option>
            <el-option label="نقطه‌ای" value="dotted"></el-option>
            <el-option label="دوگانه" value="double"></el-option>
          </el-select>
        </div>
      </div>
    </div>

    {{-- مدیریت آیتم‌های تصویر-متن --}}
    <div class="editor-section">
      <div class="section-title">
        <i class="el-icon-picture"></i>
        مدیریت آیتم‌های تصویر-متن
      </div>
      <div class="section-content">
        {{-- لیست آیتم‌های تصویر-متن --}}
        <div class="image-text-list" v-loading="loading">
          <template v-if="module.imageTextItems && module.imageTextItems.length">
            <draggable 
              ghost-class="dragabble-ghost" 
              :list="module.imageTextItems" 
              @change="onChange"
              :options="{ animation: 330 }"
              class="image-text-draggable"
            >
                             <div v-for="(item, index) in module.imageTextItems" :key="index" class="image-text-item">
                 <div class="item-preview">
                   <img 
                     :src="getImageUrl(item.image)" 
                     :alt="item.name"
                     class="preview-img"
                   >
                 </div>
                 <div class="item-info">
                   <div class="item-name">@{{ item.name }}</div>
                   <div class="item-link" v-if="item.link && item.link.value && item.link.type">
                     <i class="el-icon-link"></i>
                     @{{ getLinkDisplayText(item.link) }}
                   </div>
                 </div>
                 <div class="item-actions">
                   <el-button 
                     type="primary" 
                     size="mini" 
                     icon="el-icon-edit" 
                     @click="editItem(index)"
                     style="padding: 6px; min-width: 28px;"
                   ></el-button>
                   <el-button 
                     type="danger" 
                     size="mini" 
                     icon="el-icon-delete" 
                     @click="removeItem(index)"
                     style="padding: 6px; min-width: 28px;"
                   ></el-button>
                 </div>
               </div>
            </draggable>
          </template>
          
          {{-- حالت خالی --}}
          <div v-else class="empty-state">
            <i class="el-icon-picture-outline"></i>
            <p>آیتم تصویر-متنی وجود ندارد</p>
            <span>برای اضافه کردن آیتم‌های تصویر-متن کلیک کنید</span>
          </div>
        </div>

        {{-- دکمه اضافه کردن آیتم تصویر-متن --}}
        <div class="add-item-section">
          <el-button 
            type="primary" 
            icon="el-icon-plus" 
            @click="addItem"
            size="small"
            style="width: 100%;"
          >
            آیتم تصویر-متن اضافه کنید
          </el-button>
        </div>
      </div>
    </div>

    {{-- دیالوگ ویرایش آیتم تصویر-متن --}}
    <el-dialog 
      :title="editingItemIndex === -1 ? 'اضافه کردن آیتم تصویر-متن' : 'ویرایش آیتم تصویر-متن'" 
      :visible.sync="showItemDialog" 
      width="500px"
      @close="closeItemDialog"
    >
      <div class="item-form">
        {{-- عنوان --}}
        <div class="form-group">
          <label>عنوان</label>
          <el-input 
            v-model="editingItem.name" 
            placeholder="لطفا عنوان را وارد کنید"
            size="small"
          ></el-input>
        </div>

        {{-- تصویر --}}
        <div class="form-group">
          <label>تصویر</label>
          <single-image-selector 
            v-model="editingItem.image" 
            :aspectRatio="2/1" 
            :targetWidth="200"
            :targetHeight="100"
          ></single-image-selector>
          <div class="form-tip">
            <i class="el-icon-info"></i>
            پیشنهادی: 200 x 100 (نسبت 2:1)
          </div>
        </div>

        {{-- لینک --}}
        <div class="form-group">
          <label>لینک (اختیاری)</label>
          <link-selector 
            v-model="editingItem.link" 
            placeholder="لطفا لینک را انتخاب کنید یا وارد کنید"
            :is-title="false"
          ></link-selector>
          <div class="form-tip" v-if="editingItem.link && editingItem.link.value">
            <i class="el-icon-info"></i>
            لینک جاری: @{{ getLinkDisplayText(editingItem.link) }}
          </div>
        </div>
      </div>
      
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeItemDialog">انصراف</el-button>
        <el-button type="primary" @click="saveItem">تایید</el-button>
      </div>
    </el-dialog>
  </div>
</template>

{{-- ماژول ویرایش لیست تصویر-متن - اسکریپت --}}
<script type="text/javascript">
  Vue.component('module-editor-image-text-list', {
    template: '#module-editor-image-text-list-template',
    props: ['module'],
    
    data: function() {
      return {
        debounceTimer: null,
        loading: false,
        showItemDialog: false,
        editingItemIndex: -1,
        editingItem: {
          name: '',
          image: '',
          link: {
            type: 'url',
            value: ''
          }
        },
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
      // مقادیر پیش‌فرض را مقداردهی کنید
        if (!this.module.title) {
          this.$set(this.module, 'title', this.languagesFill('لیست تصویر-متن'));
        }
      if (!this.module.imageTextItems) {
        this.$set(this.module, 'imageTextItems', []);
      }
      if (!this.module.columns) {
        this.$set(this.module, 'columns', 4);
      }
      if (!this.module.autoplay) {
        this.$set(this.module, 'autoplay', false);
      }
      if (!this.module.autoplaySpeed) {
        this.$set(this.module, 'autoplaySpeed', 3000);
      }
      if (!this.module.showNames) {
        this.$set(this.module, 'showNames', true);
      }
      if (!this.module.width) {
        this.$set(this.module, 'width', 'wide');
      }
      if (!this.module.itemHeight) {
        this.$set(this.module, 'itemHeight', 120);
      }
      if (!this.module.padding) {
        this.$set(this.module, 'padding', 16);
      }
      if (!this.module.borderRadius) {
        this.$set(this.module, 'borderRadius', 8);
      }
      if (!this.module.borderWidth) {
        this.$set(this.module, 'borderWidth', 1);
      }
      if (!this.module.borderColor) {
        this.$set(this.module, 'borderColor', '#f0f0f0');
      }
      if (!this.module.borderStyle) {
        this.$set(this.module, 'borderStyle', 'solid');
      }
    },

    methods: {
      onChange() {
        // زمان پیش‌فرض را پاک کنید
        if (this.debounceTimer) {
          clearTimeout(this.debounceTimer);
        }
        
        // تنظیم زمان جدید
        this.debounceTimer = setTimeout(() => {
          this.$emit('on-changed', this.module);
        }, 300);
      },

      setModuleWidth(width) {
        this.$set(this.module, 'width', width);
        this.onChange();
      },

      setColumns(columns) {
        this.$set(this.module, 'columns', columns);
        this.onChange();
      },

      getImageUrl(image) {
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
      },

      addItem() {
        this.editingItemIndex = -1;
        this.editingItem = {
          name: '',
          image: '',
          link: {
            type: 'url',
            value: ''
          }
        };
        this.showItemDialog = true;
      },

      editItem(index) {
        this.editingItemIndex = index;
        this.editingItem = JSON.parse(JSON.stringify(this.module.imageTextItems[index]));
        this.showItemDialog = true;
      },

      removeItem(index) {
        this.$confirm('آیا از حذف این آیتم تصویر-متن اطمینان دارید؟', 'تایید', {
          confirmButtonText: 'تایید',
          cancelButtonText: 'انصراف',
          type: 'warning'
        }).then(() => {
          this.module.imageTextItems.splice(index, 1);
          this.onChange();
          this.$message.success('با موفقیت حذف شد');
        }).catch(() => {
          // کاربر حذف را لغو کرد
        });
      },

      saveItem() {
        if (!this.editingItem.name.trim()) {
          this.$message.error('لطفا عنوان را وارد کنید');
          return;
        }
        if (!this.editingItem.image) {
          this.$message.error('لطفا تصویر را انتخاب کنید');
          return;
        }

        if (this.editingItemIndex === -1) {
          // اضافه کردن آیتم تصویر-متن جدید
          this.module.imageTextItems.push(JSON.parse(JSON.stringify(this.editingItem)));
        } else {
          // ویرایش آیتم تصویر-متن موجود
          this.$set(this.module.imageTextItems, this.editingItemIndex, JSON.parse(JSON.stringify(this.editingItem)));
        }

        this.onChange();
        this.closeItemDialog();
        this.$message.success(this.editingItemIndex === -1 ? 'با موفقیت اضافه شد' : 'با موفقیت به‌روزرسانی شد');
      },

      closeItemDialog() {
        this.showItemDialog = false;
        this.editingItemIndex = -1;
        this.editingItem = {
          name: '',
          image: '',
          link: {
            type: 'url',
            value: ''
          }
        };
      },

      languagesFill(text) {
        const obj = {};
        $languages.forEach(e => {
          obj[e.code] = text;
        });
        return obj;
      },

      getLinkDisplayText(link) {
        if (!link || !link.type) {
          return '';
        }

        switch (link.type) {
          case 'custom':
            return link.value || 'لینک سفارشی';
          case 'static':
            const staticLinks = {
              'account.index': 'مرکز حساب کاربری',
              'account.wishlist.index': 'لیست علاقه‌مندی‌های من',
              'account.order.index': 'سفارش‌های من',
              'brands.index': 'لیست برند'
            };
            return staticLinks[link.value] || link.value;
          case 'product':
            return link.value ? `محصول #${link.value}` : 'لینک سفارشی محصول';
          case 'category':
            return link.value ? `دسته‌بندی #${link.value}` : 'دسته‌بندی محصول';
          case 'page':
            return link.value ? `صفحه #${link.value}` : 'لینک صفحه';
          case 'catalog':
            return link.value ? `دسته‌بندی مقاله #${link.value}` : 'دسته‌بندی مقاله';
          case 'brand':
            return link.value ? `برند #${link.value}` : 'لینک برند';
          default:
            return link.value || 'لینک غیرمعلوم';
        }
      }
    }
  });
</script> 