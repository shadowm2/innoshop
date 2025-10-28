<script>
  // ایجاد نمونه Vue
  const app = new Vue({
    el: '#app',
    data: {
      form: {
        modules: []
      },
      source: {
        locale: $locale || 'zh_cn',
        modules: []
      },
      lang: lang, // نصب شی lang سراسری
      design: {
        type: 'pc',
        editType: 'add',
        sidebar: true,
        editingModuleIndex: 0,
        ready: false,
        moduleLoadCount: 0,
        editorInitialized: false, // جدید: ردیابی اینکه آیا ویرایشگر واقعاً مقداردهی اولیه شده است
      },
      showPropertyPanel: false,
      saveStatus: 'saved', // saved, unsaved, saving
      saveStatusText: 'ذخیره شده',
      lastSavedTime: null,
      moduleSearch: '',
      selectedCategory: null,

    },

    computed: {
      editingModuleComponent() {
        if (!this.form.modules ||
          !this.form.modules.length ||
          this.design.editingModuleIndex < 0 ||
          !this.form.modules[this.design.editingModuleIndex] ||
          !this.form.modules[this.design.editingModuleIndex].code) {
          return null;
        }

        const module = this.form.modules[this.design.editingModuleIndex];
        return 'module-editor-' + module.code.replace('_', '-');
      },
      
      moduleCategories() {
        return [
          { value: 'product', label: lang.product_module },
          { value: 'media', label: lang.media_module },
          { value: 'content', label: lang.content_module },
          { value: 'layout', label: lang.layout_module }
        ];
      },
      
      filteredModules() {
        let modules = this.source.modules;
        
        // فیلتر بر اساس دسته‌بندی
        if (this.selectedCategory) {
          modules = modules.filter(module => {
            const category = this.getModuleCategory(module.code);
            return category === this.selectedCategory;
          });
        }
        
        // فیلتر بر اساس کلمه کلیدی جستجو
        if (this.moduleSearch) {
          const search = this.moduleSearch.toLowerCase();
          modules = modules.filter(module => {
            const title = (module.title || module.name || '').toLowerCase();
            const code = (module.code || '').toLowerCase();
            return title.includes(search) || code.includes(search);
          });
        }
        
        return modules;
      }
    },

    watch: {
      'design.editingModuleIndex': function(newVal) {
        if (newVal >= 0) {
          this.showPropertyPanel = true;
        }
      },

      'form.modules': {
        handler: function(newVal) {
          if (newVal.length === 0) {
            this.showPropertyPanel = false;
            this.design.editingModuleIndex = -1;
          }
        },
        deep: true
      }
    },

    methods: {
      // استفاده از inno.debounce برای حفظ زمینه this
      moduleUpdated: (window.inno && window.inno.debounce) ? window.inno.debounce(function(val) {
        // جلوگیری از فعال شدن AJAX هنگام مقداردهی اولیه ویرایشگر
        if (!this.design || !this.design.editorInitialized) {
          if (this.design) {
            this.design.moduleLoadCount = 1;
            this.design.editorInitialized = true; // علامت‌گذاری ویرایشگر به عنوان مقداردهی اولیه شده
          }
          return;
        }
        
        this.form.modules[this.design.editingModuleIndex].content = val;
        const data = this.form.modules[this.design.editingModuleIndex];
        
        // به‌روزرسانی وضعیت ذخیره
        this.saveStatus = 'unsaved';
        this.saveStatusText = 'ذخیره نشده';
        
        const page = '{{ $page ?? "home" }}';
        const url = page === 'home' ? '{{ panel_route('pbuilder.modules.preview', ['page' => 'home']) }}' : '{{ panel_route('pbuilder.modules.preview', ['page' => ':page']) }}'.replace(':page', page);
        axios.post(url + '?design=1', data).then((res) => {
          $(previewWindow.document).find('#module-' + data.module_id).replaceWith(res);
          $(previewWindow.document).find('.tooltip').remove();
          const tooltipTriggerList = previewWindow.document.querySelectorAll('[data-bs-toggle="tooltip"]')
          const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new previewWindow.bootstrap.Tooltip(tooltipTriggerEl))
        }).catch((error) => {
          // مدیریت خطای به‌روزرسانی ماژول
          let errorMessage = 'به‌روزرسانی ماژول ناموفق بود';
          
          if (error.response) {
            // سرور کد وضعیت خطا را برگردانده است
            const status = error.response.status;
            const data = error.response.data;
            
            if (status === 404) {
              errorMessage = 'فایل قالب ماژول وجود ندارد، لطفاً با مدیر تماس بگیرید';
            } else if (status === 500) {
              errorMessage = 'خطای داخلی سرور، لطفاً بعداً دوباره تلاش کنید';
            } else if (status === 422) {
              errorMessage = 'خطا در فرمت داده‌های ماژول: ' + (data.message || 'خطای نامشخص');
            } else if (data && data.message) {
              errorMessage = data.message;
            } else {
              errorMessage = `درخواست ناموفق (${status})`;
            }
          } else if (error.request) {
            // درخواست ارسال شده اما پاسخی دریافت نشده
            errorMessage = 'اتصال شبکه ناموفق، لطفاً اتصال شبکه را بررسی کنید';
          } else {
            // سایر خطاها
            errorMessage = error.message || 'خطای نامشخص';
          }
          
          // استفاده از پنجره layer برای نمایش اطلاعات خطا
          layer.msg(errorMessage, {
            icon: 2,
            time: 3000,
            shade: [0.3, '#000']
          });
          
          console.error('به‌روزرسانی ماژول ناموفق:', error);
        })
      }, 300) : function(val) {
        // fallback اگر inno.debounce موجود نباشد
        this.form.modules[this.design.editingModuleIndex].content = val;
        const data = this.form.modules[this.design.editingModuleIndex];
        this.saveStatus = 'unsaved';
        this.saveStatusText = 'ذخیره نشده';
      },

      addModuleButtonClicked(code, moduleItemIndex = null, callback = null) {
        const sourceModule = this.source.modules.find(e => e.code == code)
        const module_id = randomString(16)
        const _data = {
          code: code,
          content: sourceModule.make || sourceModule.content,
          module_id: module_id,
          name: sourceModule.title || sourceModule.name,
          view_path: sourceModule.view_path || '',
        }

        // به‌روزرسانی وضعیت ذخیره
        this.saveStatus = 'unsaved';
        this.saveStatusText = 'ذخیره نشده';

        const page = '{{ $page ?? "home" }}';
        const url = page === 'home' ? '{{ panel_route('pbuilder.modules.preview', ['page' => 'home']) }}' : '{{ panel_route('pbuilder.modules.preview', ['page' => ':page']) }}'.replace(':page', page);
        axios.post(url + '?design=1', _data).then((res) => {
          if (moduleItemIndex === null) {
            $(previewWindow.document).find('.modules-box').append(res);
            this.form.modules.push(_data);
            this.design.editingModuleIndex = this.form.modules.length - 1;
            this.design.editType = 'module';
          } else {
            $(previewWindow.document).find('.modules-box').children().eq(moduleItemIndex).before(res);
            this.form.modules.splice(moduleItemIndex, 0, _data);
            this.design.editingModuleIndex = moduleItemIndex;
            this.design.editType = 'module';
          }

          setTimeout(() => {
            const moduleElement = $(previewWindow.document).find('#module-' + module_id);
            if (moduleElement.length > 0 && moduleElement.offset()) {
              $(previewWindow.document).find("html, body").animate({
                scrollTop: moduleElement.offset().top - 96
              }, 50);
            }
          }, 200)
        }).catch((error) => {
          // مدیریت خطای AJAX
          let errorMessage = 'افزودن ماژول ناموفق بود';
          
          if (error.response) {
            // سرور کد وضعیت خطا را برگردانده است
            const status = error.response.status;
            const data = error.response.data;
            
            if (status === 404) {
              errorMessage = 'فایل قالب ماژول وجود ندارد، لطفاً با مدیر تماس بگیرید';
            } else if (status === 500) {
              errorMessage = 'خطای داخلی سرور، لطفاً بعداً دوباره تلاش کنید';
            } else if (status === 422) {
              errorMessage = 'خطا در فرمت داده‌های ماژول: ' + (data.message || 'خطای نامشخص');
            } else if (data && data.message) {
              errorMessage = data.message;
            } else {
              errorMessage = `درخواست ناموفق (${status})`;
            }
          } else if (error.request) {
            // درخواست ارسال شده اما پاسخی دریافت نشده
            errorMessage = 'اتصال شبکه ناموفق، لطفاً اتصال شبکه را بررسی کنید';
          } else {
            // سایر خطاها
            errorMessage = error.message || 'خطای نامشخص';
          }
          
          // استفاده از پنجره layer برای نمایش اطلاعات خطا
          layer.msg(errorMessage, {
            icon: 2,
            time: 3000,
            shade: [0.3, '#000']
          });
          
          console.error('افزودن ماژول ناموفق:', error);
        }).finally(() => {
          if (callback) {
            callback();
          }
        })
      },

      editModuleButtonClicked(index) {
        if (this.design) {
          // اگر قبلاً ماژول فعلی در حال ویرایش است، پردازش تکراری انجام نده
          if (this.design.editingModuleIndex === index && this.design.editType === 'module') {
            console.log('قبلاً ماژول فعلی در حال ویرایش است، پردازش تکراری رد شد', index);
            return;
          }
          
          this.design.moduleLoadCount = 0;
          this.design.editingModuleIndex = index;
          this.design.editType = 'module';
          this.design.editorInitialized = false; // بازنشانی وضعیت مقداردهی اولیه ویرایشگر
        }
      },

      saveButtonClicked() {
        this.saveStatus = 'saving';
        this.saveStatusText = 'در حال ذخیره...';
        
        const page = '{{ $page ?? "home" }}';
        const url = page === 'home' ? '{{ panel_route('pbuilder.modules.update', ['page' => 'home']) }}' : '{{ panel_route('pbuilder.modules.update', ['page' => ':page']) }}'.replace(':page', page);
        
        axios.put(url, this.form).then((res) => {
          this.saveStatus = 'saved';
          this.saveStatusText = 'ذخیره شده';
          this.lastSavedTime = new Date();
          layer.msg(res.message, {icon: 1});
        }).catch((error) => {
          this.saveStatus = 'unsaved';
          this.saveStatusText = 'ذخیره ناموفق';
          layer.msg('ذخیره ناموفق: ' + (error.response?.data?.message || error.message), {icon: 2});
        });
      },

      importDemoData() {
        const page = '{{ $page ?? "home" }}';
        if (page !== 'home') {
          layer.msg('داده‌های نمایشی فقط صفحه اصلی را پشتیبانی می‌کند');
          return;
        }
        
        if (confirm('آیا مطمئن هستید که می‌خواهید داده‌های نمایشی را وارد کنید؟ این کار طراحی فعلی صفحه را بازنویسی خواهد کرد.')) {
          const url = '{{ panel_route('pbuilder.demo.import', ['page' => 'home']) }}';
          axios.post(url).then((res) => {
            layer.msg(res.message);
            // بارگذاری مجدد صفحه برای نمایش داده‌های نمایشی
            setTimeout(() => {
              location.reload();
            }, 1000);
          }).catch((error) => {
            layer.msg('وارد کردن ناموفق: ' + (error.response?.data?.message || error.message));
          });
        }
      },

      viewHome() {
        location = '{{ front_route('home.index') }}';
      },

      isIcon(code) {
        // تشخیص اینکه آیا فرمت آیکون برچسب HTML است
        return typeof code === 'string' && (code.indexOf('<i') === 0 || code.indexOf('&#') === 0);
      },
      
      getCurrentModuleIcon() {
        if (!this.form.modules || 
            !this.form.modules.length || 
            this.design.editingModuleIndex < 0 || 
            !this.form.modules[this.design.editingModuleIndex]) {
          return null;
        }
        
        const currentModule = this.form.modules[this.design.editingModuleIndex];
        const sourceModule = this.source.modules.find(module => module.code === currentModule.code);
        
        return sourceModule ? sourceModule.icon : null;
      },
      
      getModuleCategory(code) {
        // تعریف نقشه‌برداری دسته‌بندی واحد ماژول
        const moduleCategories = {
          // ماژول‌های رسانه - تصاویر، ویدیوها و سایر محتوای رسانه‌ای
          'slideshow': 'media',
          'single-image': 'media',
          'four-image': 'media',
          'four-image-plus': 'media',
          'multi-row-images': 'media',
          'video': 'media',
          
          // ماژول‌های محصول - ماژول‌های مرتبط با محصولات
          'custom-products': 'product',
          'category-products': 'product',
          'latest-products': 'product',
          'brand-products': 'product',
          'card-slider': 'product',
          
          // ماژول‌های محتوا - متن، مقالات و سایر محتوا
          'rich-text': 'content',
          'article': 'content',
          'brands': 'content',
          
          // ماژول‌های چیدمان - ماژول‌های مرتبط با چیدمان و ساختار
          'left-image-right-text': 'layout',
          'image-text-list': 'layout'
        };
        
        // بازگرداندن دسته‌بندی ماژول، اگر یافت نشد 'layout' را برگردان
        return moduleCategories[code] || 'layout';
      },

      showAllModuleButtonClicked() {
        if (this.design) {
          this.design.editType = 'add';
          this.design.editingModuleIndex = 0;
        }
      },

      switchDevice(type) {
        if (this.design) {
          this.design.type = type;
        }
        const iframe = document.getElementById('preview-iframe');
        const previewContainer = document.querySelector('.preview-iframe');
        
        // بررسی اینکه آیا previewContainer وجود دارد
        if (!previewContainer) {
          console.warn('کانتینر پیش‌نمایش یافت نشد');
          return;
        }
        
        // حذف تمام کلاس‌های دستگاه
        previewContainer.classList.remove('device-pc', 'device-mobile');
        
        if (type === 'mobile') {
          previewContainer.classList.add('device-mobile');
          if (iframe) {
            iframe.style.width = '375px';
            iframe.style.height = '667px';
            iframe.style.maxWidth = '375px';
            iframe.style.maxHeight = '667px';
          }
        } else {
          // دستگاه PC
          previewContainer.classList.add('device-pc');
          if (iframe) {
            iframe.style.width = '100%';
            iframe.style.height = '100%';
            iframe.style.maxWidth = 'none';
            iframe.style.maxHeight = 'none';
          }
        }
      },

      // مقداردهی اولیه میانبرهای صفحه‌کلید
      initKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
          // فقط در غیر کادرهای ورودی اعمال شود
          if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
            return;
          }
          
          // Ctrl+S ذخیره
          if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            this.saveButtonClicked();
          }
          
          // Delete حذف ماژول انتخاب شده
          if (e.key === 'Delete' && this.design.editingModuleIndex >= 0) {
            e.preventDefault();
            this.deleteCurrentModule();
          }
          
          // Ctrl+Z واگرد (رزرو شده)
          if (e.ctrlKey && e.key === 'z') {
            e.preventDefault();
            // this.undo();
          }
          
          // Ctrl+Y انجام مجدد (رزرو شده)
          if (e.ctrlKey && e.key === 'y') {
            e.preventDefault();
            // this.redo();
          }
          
          // Esc خروج از حالت ویرایش
          if (e.key === 'Escape') {
            e.preventDefault();
            this.showAllModuleButtonClicked();
          }
        });
      },
      
      // حذف ماژول فعلی
      deleteCurrentModule() {
        if (this.design.editingModuleIndex >= 0 && this.form.modules[this.design.editingModuleIndex]) {
          if (confirm('آیا مطمئن هستید که می‌خواهید این ماژول را حذف کنید؟')) {
            this.design.editType = 'add';
            this.design.editingModuleIndex = 0;
            this.form.modules.splice(this.design.editingModuleIndex, 1);
            this.saveStatus = 'unsaved';
            this.saveStatusText = 'ذخیره نشده';
          }
        }
      }
    },
    
    created () {
      this.form = @json($design_settings ?: ['modules' => []]);
      this.source.modules = @json($source['modules'] ?? []);
    },
    
    mounted () {
      // مقداردهی اولیه نوع دستگاه
      this.switchDevice(this.design.type);
      
      // اطمینان از اینکه iframe پس از بارگذاری کامل وضعیت ready را تنظیم کند
      setTimeout(() => {
        if (this.design) {
          this.design.ready = true;
        }
      }, 1000);
      
      // افزودن میانبرهای صفحه‌کلید
      this.initKeyboardShortcuts();
    },
  })
</script>