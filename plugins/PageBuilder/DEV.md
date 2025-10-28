# PageBuilder مستندات توسعه

## محیط توسعه

### نیازمندی‌های سیستم
- PHP >=8.1
- Laravel >= 10.0
- Node.js >= 16.0
- Composer >= 2

### ابزارهای توسعه
- **IDE**: PhpStorm / VS Code
- **دیباگ**: Laravel Debugbar
- **کنترل نسخه**: Git
- **مدیریت پکیج**: Composer / NPM

## ساختار پروژه

```
PageBuilder/
├── Controllers/                    # لایه کنترلر
│   └── Panel/
│       └── PageBuilderController.php
├── Services/                      # لایه سرویس
│   ├── PageBuilderService.php    # سرویس ساخت صفحه
│   ├── ModulePreviewService.php  # سرویس پیش‌نمایش ماژول
│   └── DesignService.php         # سرویس طراحی
├── Views/                         # لایه نمایش (جزئیات ساختار فرانت‌اند را ببینید)
├── Public/                       # منابع استاتیک
│   ├── css/                     # فایل‌های استایل
│   ├── js/                      # فایل‌های JavaScript
│   └── images/                  # منابع تصویری
├── Routes/                       # تعریف مسیرها
│   └── panel.php                # مسیرهای پنل مدیریت
├── config.json                  # پیکربندی پلاگین
└── README.md                    # توضیحات پلاگین
```

## ساختار فرانت‌اند

```
Views/                            # لایه نمایش
├── design/                       # رابط طراح
│   ├── index.blade.php          # صفحه اصلی
│   ├── layouts/                 # کامپوننت‌های لایه
│   │   ├── header.blade.php     # لایه هدر
│   │   └── sidebar.blade.php    # لایه نوار کناری
│   ├── scripts/                 # اسکریپت‌های JavaScript
│   │   ├── app.blade.php        # اسکریپت اصلی اپلیکیشن
│   │   ├── vue-app.blade.php    # اسکریپت اپلیکیشن Vue
│   │   └── iframe-events.blade.php # مدیریت رویدادهای iframe
│   ├── editors/                 # ویرایشگرهای ماژول
│   │   ├── slideshow.blade.php      # ویرایشگر اسلایدشو
│   │   ├── rich-text.blade.php      # ویرایشگر متن غنی
│   │   ├── left-image-right-text.blade.php # ویرایشگر تصویر چپ متن راست
│   │   ├── grid-square.blade.php    # ویرایشگر مربع شبکه‌ای
│   │   ├── card-slider.blade.php    # ویرایشگر اسلایدر کارت
│   │   ├── four-image.blade.php     # ویرایشگر چهار تصویر
│   │   ├── four-image-plus.blade.php # ویرایشگر چهار تصویر پیشرفته
│   │   ├── image-100.blade.php      # ویرایشگر تک تصویر
│   │   ├── latest.blade.php         # ویرایشگر جدیدترین محصولات
│   │   ├── product.blade.php        # ویرایشگر محصول
│   │   ├── category.blade.php       # ویرایشگر دسته‌بندی
│   │   └── article.blade.php        # ویرایشگر مقاله
│   └── components/              # کامپوننت‌های عمومی
│       ├── multi-image-selector.blade.php  # انتخابگر چند تصویر
│       ├── single-image-selector.blade.php # انتخابگر تک تصویر
│       ├── i18n.blade.php            # کامپوننت چندزبانه
│       └── link-selector.blade.php   # انتخابگر لینک
└── front/                        # نمایش فرانت
    ├── home.blade.php           # قالب صفحه اصلی
    ├── page.blade.php           # قالب صفحه
    ├── modules/                 # قالب‌های ماژول
    │   ├── slideshow.blade.php      # ماژول اسلایدشو
    │   ├── rich_text.blade.php      # ماژول متن غنی
    │   ├── left_image_right_text.blade.php # ماژول تصویر چپ متن راست
    │   ├── grid_square.blade.php    # ماژول مربع شبکه‌ای
    │   ├── card_slider.blade.php    # ماژول اسلایدر کارت
    │   ├── four_image.blade.php     # ماژول چهار تصویر
    │   ├── four_image-plus.blade.php # ماژول چهار تصویر پیشرفته
    │   ├── image10.blade.php       # ماژول تک تصویر
    │   ├── image20.blade.php       # ماژول دو تصویر
    │   ├── image41.blade.php       # ماژول چهار تصویر 1
    │   ├── image42.blade.php       # ماژول چهار تصویر 2
    │   ├── product.blade.php        # ماژول محصول
    │   └── article.blade.php        # ماژول مقاله
    └── partials/                 # کامپوننت‌های فرانت
        └── module-edit-buttons.blade.php # دکمه‌های ویرایش ماژول
```

## مفاهیم اصلی

### 🧩 سیستم ماژولی

PageBuilder از طراحی ماژولی استفاده می‌کند، هر ماژول یک واحد عملکردی مستقل است:

```
┌─────────────────────────────────────────────────────────────────┐
│                           معماری سیستم ماژولی                    │
├─────────────────┬─────────────────┬─────────────────────────────┤
│   تعریف ماژول    │   ویرایشگر ماژول │   قالب ماژول                 │
│  (ModuleRepo)   │  (کامپوننت Vue)  │  (قالب Blade)               │
│                 │                 │                             │
│ • پیکربندی ماژول │ • ویرایش پارامتر │ • نمایش فرانت                │
│ • داده پیش‌فرض   │ • تنظیم استایل   │ • لایه واکنش‌گرا              │
│ • شناسه آیکون    │ • پیش‌نمایش زنده │ • نوار ابزار ویرایش          │
└─────────────────┴─────────────────┴─────────────────────────────┘
```

**توضیح مفاهیم اصلی**:

- **تعریف ماژول**: در `ModuleRepo.php` اطلاعات پایه، پیکربندی پیش‌فرض و ساختار داده ماژول تعریف می‌شود
- **ویرایشگر ماژول**: کامپوننت Vue که رابط ویرایش بصری پارامترها را فراهم می‌کند
- **قالب ماژول**: فایل قالب Blade که مسئول نمایش فرانت و نوار ابزار ویرایش است

### 🎨 رابط طراح

طراح هسته رابط عملیاتی PageBuilder است که شامل سه ناحیه اصلی می‌باشد:

```
┌─────────────────────────────────────────────────────────────────┐
│                        چیدمان رابط طراح                         │
├─────────────────┬─────────────────┬─────────────────────────────┤
│   نوار کناری     │   ناحیه پیش‌نمایش│   نوار ابزار بالا           │
│  (نمایش متناوب)  │  (ناحیه مرکزی)  │  (ناحیه بالا)               │
│                 │                 │                             │
│ • کتابخانه ماژول │ • پیش‌نمایش زنده │ • انتخاب صفحه               │
│ • پنل ویرایشگر   │ • نوار ابزار ویرایش • تغییر دستگاه              │
│ • تغییر متقابل   │ • پیش‌نمایش واکنش‌گرا • ذخیره و انتشار         │
└─────────────────┴─────────────────┴─────────────────────────────┘
```

**توضیح کامپوننت‌های رابط**:

- **نوار کناری**: شامل کتابخانه ماژول و پنل ویرایشگر که بر اساس وضعیت عملیات به صورت متناوب نمایش داده می‌شوند
  - **کتابخانه ماژول**: نمایش تمام ماژول‌های موجود، پشتیبانی از کشیدن و رها کردن به ناحیه پیش‌نمایش
  - **پنل ویرایشگر**: رابط ویرایش پارامترهای ماژول انتخاب شده فعلی
- **ناحیه پیش‌نمایش**: صفحه فرانت تعبیه شده در iframe که اثرات طراحی را به صورت زنده نمایش می‌دهد
- **نوار ابزار بالا**: دکمه‌های عملیاتی مانند انتخاب صفحه، تغییر دستگاه، ذخیره و انتشار

### 🔄 مکانیزم گردش داده

گردش داده PageBuilder مسیر زیر را دنبال می‌کند:

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│   تعریف ماژول │───▶│   طراح      │───▶│   سرویس پیش‌نمایش│───▶│   نمایش فرانت│
│  (هاردکد)    │    │  (Vue App)  │    │  (Laravel)  │    │  (Blade)    │
└─────────────┘    └─────────────┘    └─────────────┘    └─────────────┘
       │                   │                   │                   │
       ▼                   ▼                   ▼                   ▼
┌─────────────┐    ┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│   پیکربندی ماژول│    │   داده ماژول  │    │   داده رندر   │    │   داده نمایش  │
│  (JSON)     │    │  (Array)    │    │  (Array)    │    │  (HTML)     │
└─────────────┘    └─────────────┘    └─────────────┘    └─────────────┘
```

**توضیح گردش داده**:

1. **تعریف ماژول** → **طراح**: بارگذاری پیکربندی ماژول به اپلیکیشن Vue
2. **طراح** → **سرویس پیش‌نمایش**: ارسال داده به بک‌اند هنگام ویرایش کاربر
3. **سرویس پیش‌نمایش** → **نمایش فرانت**: رندر HTML ماژول و بازگشت به فرانت‌اند
4. **نمایش فرانت** → **طراح**: به‌روزرسانی نمایش ناحیه پیش‌نمایش با جدیدترین اثرات

### 🎯 مکانیزم‌های کلیدی

#### 1. مکانیزم پیش‌نمایش زنده
- **ارتباط iframe**: عملیات DOM ناحیه پیش‌نمایش از طریق `previewWindow`
- **به‌روزرسانی AJAX**: ارسال درخواست برای دریافت HTML جدید هنگام تغییر داده
- **جایگزینی HTML**: جایگزینی مستقیم محتوای ماژول در ناحیه پیش‌نمایش
- **بهینه‌سازی debounce**: استفاده از `inno.debounce` برای جلوگیری از درخواست‌های مکرر

#### 2. کنترل حالت طراحی
- **پارامتر design**: کنترل نمایش نوار ابزار ویرایش از طریق پارامتر URL
- **نوار ابزار ویرایش**: دکمه‌های ویرایش، حذف و مرتب‌سازی که هنگام hover نمایش داده می‌شوند
- **پیش‌نمایش واکنش‌گرا**: پشتیبانی از پیش‌نمایش سه نوع دستگاه PC، تبلت و موبایل

#### 3. چرخه حیات ماژول
- **ایجاد**: کشیدن از کتابخانه ماژول به ناحیه پیش‌نمایش
- **ویرایش**: کلیک روی ماژول برای ورود به حالت ویرایش
- **به‌روزرسانی**: تغییر پارامتر باعث فعال شدن پیش‌نمایش زنده می‌شود
- **ذخیره**: ماندگار کردن داده در پایگاه داده
- **حذف**: حذف ماژول از صفحه

#### 4. مکانیزم ارتباط کامپوننت

PageBuilder از مکانیزم ارتباط کامپوننت Vue.js استفاده می‌کند تا همگام‌سازی داده بین ویرایشگر ماژول و اپلیکیشن اصلی را پیاده‌سازی کند:

**ثبت و اتصال کامپوننت**:
```javascript
// 1. ثبت کامپوننت ویرایشگر ماژول (slideshow.blade.php)
Vue.component('module-editor-slideshow', {
  template: '#module-editor-slideshow',
  props: ['module'],
  methods: {
    onChange() {
      // پردازش debounce
      if (this.debounceTimer) {
        clearTimeout(this.debounceTimer);
      }
      this.debounceTimer = setTimeout(() => {
        // کلیدی: ارسال رویداد به کامپوننت والد
        this.$emit('on-changed', this.module);
      }, 300);
    }
  }
});
```

**رندر کامپوننت پویا**:
```html
<!-- 2. رندر کامپوننت پویا (sidebar.blade.php) -->
<div class="module-edit" v-if="form.modules.length > 0 && design.editType == 'module'">
  <component
    :is="editingModuleComponent"           <!-- تصمیم‌گیری پویا برای رندر کدام ویرایشگر -->
    :key="design.editingModuleIndex"       <!-- اجبار رندر مجدد -->
    :module="form.modules[design.editingModuleIndex].content"  <!-- انتقال داده -->
    @on-changed="moduleUpdated"            <!-- گوش دادن به تغییرات داده -->
  ></component>
</div>
```

**محاسبه نام کامپوننت**:
```javascript
// 3. محاسبه نام کامپوننت پویا (vue-app.blade.php)
computed: {
  editingModuleComponent() {
    const module = this.form.modules[this.design.editingModuleIndex];
    // تولید نام کامپوننت بر اساس کد ماژول، مثال: slideshow → module-editor-slideshow
    return 'module-editor-' + module.code.replace('_', '-');
  }
}
```

**مدیریت رویداد و به‌روزرسانی AJAX**:
```javascript
// 4. مدیریت رویداد و به‌روزرسانی پیش‌نمایش (vue-app.blade.php)
moduleUpdated: inno.debounce(function(val) {
  // به‌روزرسانی داده ماژول
  this.form.modules[this.design.editingModuleIndex].content = val;
  const data = this.form.modules[this.design.editingModuleIndex];
  
  // ارسال درخواست AJAX برای به‌روزرسانی پیش‌نمایش
  axios.post(url + '?design=1', data).then((res) => {
    // جایگزینی HTML ماژول مربوطه در iframe
    $(previewWindow.document).find('#module-' + data.module_id).replaceWith(res);
  });
}, 300)
```

**جریان کامل داده**:
```
کاربر محتوای ماژول را تغییر می‌دهد
    ↓
متد onChange() فراخوانی می‌شود
    ↓
setTimeout debounce 300ms
    ↓
this.$emit('on-changed', this.module)  ← ارسال رویداد
    ↓
کامپوننت والد رویداد را دریافت می‌کند
    ↓
moduleUpdated(this.module) فراخوانی می‌شود
    ↓
inno.debounce دوباره debounce 300ms
    ↓
ارسال درخواست AJAX به بک‌اند
    ↓
بک‌اند HTML ماژول را رندر می‌کند
    ↓
بازگشت HTML و جایگزینی ماژول در iframe
    ↓
کاربر اثر پیش‌نمایش زنده را می‌بیند
```

**مکانیزم debounce**:
```javascript
// پیاده‌سازی تابع debounce (app.blade.php)
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const context = this; // حفظ کانتکست this
    
    const later = () => {
      clearTimeout(timeout);
      func.apply(context, args); // استفاده از apply برای حفظ کانتکست this
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// آبجکت سراسری inno
window.inno = window.inno || {};
window.inno.debounce = debounce;
```

**روابط نگاشت کامپوننت**:
| نوع ماژول | نام کامپوننت | فایل مربوطه | توضیح عملکرد |
|---------|--------|----------|----------|
| slideshow | module-editor-slideshow | slideshow.blade.php | ویرایشگر اسلایدشو |
| product | module-editor-product | product.blade.php | ویرایشگر محصول |
| category | module-editor-category | category.blade.php | ویرایشگر دسته‌بندی |
| article | module-editor-article | article.blade.php | ویرایشگر مقاله |

**مزایای طراحی**:
- **تغییر پویا**: یک ناحیه می‌تواند انواع مختلف ویرایشگر را نمایش دهد
- **استفاده مجدد از کد**: نیازی به نوشتن کد تکراری کانتینر برای هر ماژول نیست
- **جداسازی وضعیت**: وضعیت ویرایشگرهای ماژول‌های مختلف تداخلی ندارند
- **رابط یکپارچه**: تمام ویرایشگرها از طریق props و events یکسان با کامپوننت والد ارتباط برقرار می‌کنند
- **debounce دوگانه**: debounce داخل کامپوننت + debounce نمونه Vue، جلوگیری از درخواست‌های مکرر
- **حفظ کانتکست**: `inno.debounce` اطمینان از صحت کانتکست `this`

### 📋 ساختار داده اصلی

#### ساختار داده ماژول
```php
$module = [
    'code' => 'slideshow',           // کد ماژول
    'module_id' => 'unique_id',      // شناسه یکتای ماژول
    'name' => 'ماژول اسلایدشو',      // نام ماژول
    'title' => 'اسلایدشو',          // عنوان ماژول
    'content' => [                   // محتوای ماژول
        'title' => 'عنوان ماژول',
        'images' => [
            [
                'image' => 'path/to/image.jpg',
                'link' => 'https://example.com',
                'type' => 'product'
            ]
        ]
    ],
    'view_path' => 'PageBuilder::front.modules.slideshow'
];
```

#### ساختار داده صفحه
```php
$pageData = [
    'modules' => [                   // لیست ماژول‌های صفحه
        $module1,
        $module2,
        // ...
    ],
    'page' => 'home',               // شناسه صفحه
    'design' => true                // آیا حالت طراحی است
];
```

## جریان کلی معماری

### 🏗️ نمای کلی چارچوب سیستم

PageBuilder یک سازنده صفحه بصری مبتنی بر Vue.js + Laravel است که از الگوی طراحی جداسازی فرانت‌اند و بک‌اند استفاده می‌کند:

```
┌─────────────────────────────────────────────────────────────────┐
│                         معماری سیستم PageBuilder                  │
├─────────────────┬─────────────────┬─────────────────────────────┤
│   رابط طراح      │   ناحیه پیش‌نمایش│   سرویس بک‌اند              │
│  (Vue App)      │  (iframe)       │  (Laravel API)              │
│                 │                 │                             │
│ • ویرایشگر ماژول │ • پیش‌نمایش زنده │ • سرویس پیش‌نمایش ماژول     │
│ • مرتب‌سازی کشیدنی• نوار ابزار ویرایش • سرویس ذخیره داده          │
│ • تنظیم استایل   │ • پیش‌نمایش واکنش‌گرا • سرویس مدیریت فایل       │
└─────────────────┴─────────────────┴─────────────────────────────┘
         │                 │                       │
         ▼                 ▼                       ▼
┌─────────────────┐ ┌─────────────────┐ ┌─────────────────────────┐
│   کامپوننت فرانت │ │   قالب ماژول     │ │   ذخیره داده             │
│  (کامپوننت Vue) │ │  (قالب Blade)    │ │  (پایگاه داده/پیکربندی)  │
└─────────────────┘ └─────────────────┘ └─────────────────────────┘
```

### 🔄 نمای کلی جریان عملیات

جریان کامل عملیات کاربر در استفاده از PageBuilder:

```
1. ورود به طراح → 2. انتخاب صفحه → 3. کشیدن ماژول → 4. ویرایش محتوا → 5. پیش‌نمایش زنده → 6. ذخیره و انتشار
     ↓              ↓              ↓              ↓              ↓              ↓
  بارگذاری کتابخانه  دریافت داده صفحه  افزودن ماژول به    تغییر پارامتر ماژول به‌روزرسانی ناحیه   ذخیره در پایگاه داده
  مقداردهی رابط     تنظیم حالت ویرایش  ناحیه پیش‌نمایش   فعال‌سازی به‌روزرسانی پیش‌نمایش        پاک کردن کش
```

### 📊 نمای کلی جریان داده

فرآیند گردش داده درون سیستم:

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│   تعریف ماژول │───▶│   طراح      │───▶│   سرویس پیش‌نمایش│───▶│   نمایش فرانت│
│  (config)   │    │  (Vue App)  │    │  (Laravel)  │    │  (Blade)    │
└─────────────┘    └─────────────┘    └─────────────┘    └─────────────┘
       │                   │                   │                   │
       ▼                   ▼                   ▼                   ▼
┌─────────────┐    ┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│   پیکربندی ماژول│    │   داده ماژول  │    │   داده رندر   │    │   داده نمایش  │
│  (JSON)     │    │  (Array)    │    │  (Array)    │    │  (HTML)     │
└─────────────┘    └─────────────┘    └─────────────┘    └─────────────┘
```

### 🎯 توضیح مکانیزم‌های اصلی

#### 1. طراحی ماژولی
- **تعریف ماژول**: هر ماژول در `ModuleRepo.php` به صورت هاردکد تعریف می‌شود
- **قالب ماژول**: فایل‌های قالب Blade مستقل
- **ویرایشگر ماژول**: کامپوننت‌های Vue مستقل
- **داده ماژول**: فرمت ساختار داده یکپارچه

#### 2. مکانیزم پیش‌نمایش زنده
- **ارتباط iframe**: عملیات ناحیه پیش‌نمایش از طریق `previewWindow`
- **به‌روزرسانی AJAX**: ارسال درخواست برای دریافت HTML جدید هنگام تغییر داده
- **جایگزینی HTML**: جایگزینی مستقیم محتوای ماژول در ناحیه پیش‌نمایش
- **بهینه‌سازی debounce**: جلوگیری از درخواست‌های مکرر، بهبود عملکرد

#### 3. کنترل حالت طراحی
- **پارامتر design**: کنترل حالت نمایش از طریق پارامتر URL
- **نوار ابزار ویرایش**: نمایش دکمه‌های عملیاتی در حالت طراحی
- **نمایش فرانت**: مخفی کردن عملکرد ویرایش در حالت عادی
- **پیش‌نمایش واکنش‌گرا**: پشتیبانی از پیش‌نمایش اندازه‌های مختلف دستگاه

---

## توضیح جریان تفصیلی

### 📋 1. تعریف و ثبت ماژول

**تعریف ماژول** (`ModuleRepo.php`):
```php
// تعریف ماژول به صورت هاردکد در ModuleRepo.php
public static function getModules(): array
{
    return [
        [
            'title'   => 'ماژول اسلایدشو',
            'code'    => 'slideshow',
            'icon'    => '<i class="bi bi-images"></i>',
            'content' => [
                'images' => [
                    [
                        'image' => 'images/demo/banner/banner-1-en.jpg',
                        'show'  => true,
                        'link'  => '',
                        'type'  => 'product',
                        'value' => ''
                    ],
                ],
            ],
        ],
        // ... تعریف ماژول‌های بیشتر
    ];
}
```

**جریان ثبت ماژول**:
```php
// PageBuilderService بارگذاری ماژول
public function getPageData(?string $page = null): array
{
    $data = [
        'source' => [
            'modules' => ModuleRepo::getModules(), // دریافت ماژول از ModuleRepo
        ],
    ];
    return $data;
}
```

### 📋 2. مکانیزم ناحیه پیش‌نمایش

**جریان بارگذاری iframe**:
```javascript
// iframe بارگذاری صفحه فرانت
<iframe src="{{ front_route('home.index') }}?design=1" id="preview-iframe">

// صفحه فرانت تشخیص پارامتر design
if (request()->get('design')) {
    return view('front.home', ['design' => true]);  // نمایش نوار ابزار ویرایش
} else {
    return view('front.home', ['design' => false]); // نمایش عادی فرانت
}
```

### 📋 3. دکمه‌های عملیات Hover

**کنترل نمایش CSS**:
```css
/* کنترل نمایش CSS */
.module-edit { display: none; }
.module-item:hover .module-edit { display: flex; }
```

**اتصال رویداد**:
```javascript
// اتصال رویداد
$(previewWindow.document).on('click', '.module-edit .edit', function(event) {
    const module_id = $(this).parents('.module-item').prop('id').replace('module-', '');
    const editingModuleIndex = app.form.modules.findIndex(e => e.module_id == module_id);
    app.editModuleButtonClicked(editingModuleIndex);
});
```

### 📋 4. جریان داده ویرایشگر

**تغییر داده کامپوننت Vue**:
```javascript
// تغییر داده کامپوننت Vue
Vue.component('slideshow-editor', {
    props: ['content'],
    watch: {
        content: {
            handler: function(val) {
                this.$emit('update', val);  // ارسال به‌روزرسانی به کامپوننت والد
            },
            deep: true
        }
    }
});

// دریافت به‌روزرسانی کامپوننت والد
moduleUpdated: inno.debounce(function(val) {
    this.form.modules[this.design.editingModuleIndex].content = val;
    this.updatePreview(val);  // ارسال AJAX برای به‌روزرسانی پیش‌نمایش
}, 300)
```

### 📋 5. به‌روزرسانی پیش‌نمایش

**ارسال درخواست فرانت‌اند**:
```javascript
// ارسال درخواست فرانت‌اند
axios.post(url + '?design=1', data).then((res) => {
    $(previewWindow.document).find('#module-' + data.module_id).replaceWith(res);
});
```

**پردازش بک‌اند**:
```php
// پردازش بک‌اند
public function previewModule(Request $request, ?string $page = null): View
{
    $module = json_decode($request->getContent(), true);
    $design = (bool) $request->get('design');
    
    $viewData = $this->modulePreviewService->getPreviewData($module, $design);
    return view($viewData['view_path'], $viewData);
}
```

### 📋 6. جریان ذخیره

**ذخیره فرانت‌اند**:
```javascript
// ذخیره فرانت‌اند
saveButtonClicked() {
    axios.put(url, this.form).then((res) => {
        this.saveStatus = 'saved';
    });
}
```

**ذخیره بک‌اند**:
```php
// ذخیره بک‌اند
public function update(Request $request, ?string $page = null): JsonResponse
{
    $modules = $request->input('modules', []);
    $this->pageBuilderService->savePageModules($modules, $page);
    return json_success('ذخیره موفق');
}
```

### 📋 7. نمایش فرانت

**بارگذاری صفحه فرانت**:
```php
// بارگذاری صفحه فرانت
public function index() {
    $designData = $pageBuilderService->getPageData('home');
    return view('front.home', [
        'modules' => $designData['modules'] ?? [],
        'design' => false  // حالت فرانت
    ]);
}
```

**رندر قالب فرانت**:
```blade
{{-- رندر قالب فرانت --}}
@foreach($modules as $module)
    @include($module['view_path'], [
        'module_id' => $module['module_id'],
        'content' => $module['content'],
        'design' => false  // عدم نمایش نوار ابزار ویرایش
    ])
@endforeach
```

### 🔑 نکات فنی کلیدی

| نکته فنی | توضیح | روش پیاده‌سازی |
|--------|------|----------|
| **ارتباط iframe** | عملیات محتوای ناحیه پیش‌نمایش | `previewWindow.document` |
| **واکنش‌گرایی Vue** | به‌روزرسانی خودکار با تغییر داده | `v-model` + `watch` |
| **پردازش debounce** | جلوگیری از درخواست‌های مکرر | `inno.debounce` |
| **حالت طراحی** | کنترل نوار ابزار ویرایش | پارامتر `design` |
| **ماژولی سازی** | قالب و ویرایشگر مستقل | توسعه کامپوننتی |
| **پیش‌نمایش زنده** | آنچه می‌بینید همان چیزی است که دریافت می‌کنید | AJAX + جایگزینی HTML |

### 🎯 مزایای اصلی
1. **طراحی ماژولی**: هر ماژول مستقل، آسان برای توسعه
2. **پیش‌نمایش زنده**: ویرایش همزمان با پیش‌نمایش، تجربه کاربری عالی
3. **پشتیبانی واکنش‌گرا**: تطبیق با چندین دستگاه
4. **عملیات بصری**: طراحی کشیدنی، بدون نیاز به برنامه‌نویسی
5. **جداسازی داده**: جداسازی داده طراحی از منطق نمایش

## معماری اصلی

### معماری MVC
```
Controller (PageBuilderController)
    ↓
Service (PageBuilderService)
    ↓
Repository (ModuleRepository)
    ↓
Model (Module)
```

### معماری فرانت‌اند
```
Vue App (vue-app.blade.php)
    ↓
Component System
    ├── Module Editors
    ├── Image Selectors
    └── Layout Components
    ↓
AJAX Communication
    ↓
Backend API
```

## مستندات API

### تعریف مسیرها

#### صفحه اصلی سازنده صفحه
```php
Route::get('/pbuilder', [PageBuilderController::class, 'index'])
    ->name('pbuilder.index');
Route::get('/pbuilder/{page}', [PageBuilderController::class, 'index'])
    ->name('pbuilder.page.index');
```

#### پیش‌نمایش ماژول
```php
Route::post('/pbuilder/{page}/modules/preview', [PageBuilderController::class, 'previewModule'])
    ->name('pbuilder.modules.preview');
```

#### ذخیره داده صفحه
```php
Route::put('/pbuilder/{page}/modules', [PageBuilderController::class, 'update'])
    ->name('pbuilder.modules.update');
```

### متدهای کنترلر

#### PageBuilderController

```php
/**
 * صفحه اصلی ویرایش صفحه
 * @param string|null $page شناسه صفحه
 * @return mixed
 */
public function index(?string $page = null): mixed

/**
 * پیش‌نمایش HTML ماژول
 * @param Request $request
 * @param string|null $page شناسه صفحه
 * @return View
 */
public function previewModule(Request $request, ?string $page = null): View

/**
 * ذخیره داده ماژول‌های صفحه
 * @param Request $request
 * @param string|null $page شناسه صفحه
 * @return JsonResponse
 */
public function update(Request $request, ?string $page = null): JsonResponse
```

### رابط لایه سرویس

#### PageBuilderService

```php
/**
 * دریافت داده صفحه
 * @param string|null $page شناسه صفحه
 * @return array
 */
public function getPageData(?string $page = null): array

/**
 * ذخیره ماژول‌های صفحه
 * @param array $modules داده ماژول
 * @param string|null $page شناسه صفحه
 * @return void
 */
public function savePageModules(array $modules, ?string $page = null): void

/**
 * وارد کردن داده نمونه
 * @param string|null $page شناسه صفحه
 * @return array
 */
public function importDemoData(?string $page = null): array
```

## راهنمای توسعه ماژول

### ایجاد ماژول جدید

#### 1. تعریف پیکربندی ماژول
در `ModuleRepo.php` تعریف ماژول را اضافه کنید:

```php
// در متد ModuleRepo::getModules() ماژول جدید را اضافه کنید
[
    'title'   => 'ماژول سفارشی',
    'code'    => 'custom_module',
    'icon'    => '<i class="bi bi-grid"></i>',
    'content' => [
        'title'    => self::languagesFill('عنوان ماژول'),
        'subtitle' => self::languagesFill('زیرعنوان ماژول'),
        // سایر فیلدهای سفارشی
    ],
],
```

#### 2. ایجاد قالب ماژول
در دایرکتوری `Views/front/modules/` قالب ماژول را ایجاد کنید:

```blade
{{-- custom_module.blade.php --}}
<div id="module-{{ $module_id }}" class="module-item custom-module">
  <div class="module-content">
    {{-- محتوای ماژول --}}
    <div class="custom-content">
      @if($content['title'])
        <h2>{{ $content['title'] }}</h2>
      @endif
      @if($content['description'])
        <p>{{ $content['description'] }}</p>
      @endif
    </div>
  </div>
  
  @if($design)
    <div class="module-edit">
      <div class="edit"><i class="bi bi-pencil"></i></div>
      <div class="delete"><i class="bi bi-trash"></i></div>
      <div class="up"><i class="bi bi-arrow-up"></i></div>
      <div class="down"><i class="bi bi-arrow-down"></i></div>
    </div>
  @endif
</div>
```

#### 3. ایجاد ویرایشگر ماژول
در دایرکتوری `Views/design/editors/` ویرایشگر را ایجاد کنید:

```blade
{{-- custom_module.blade.php --}}
<script type="text/x-template" id="custom-module-editor">
  <div class="module-editor">
    <div class="editor-header">
      <h5>تنظیمات ماژول سفارشی</h5>
    </div>
    
    <div class="editor-content">
      <div class="form-group">
        <label>عنوان</label>
        <input type="text" v-model="content.title" class="form-control">
      </div>
      
      <div class="form-group">
        <label>توضیحات</label>
        <textarea v-model="content.description" class="form-control"></textarea>
      </div>
    </div>
  </div>
</script>

<script>
Vue.component('custom-module-editor', {
  template: '#custom-module-editor',
  props: ['content'],
  watch: {
    content: {
      handler: function(val) {
        this.$emit('update', val);
      },
      deep: true
    }
  }
});
</script>
```

#### 4. ثبت ماژول
در صفحه اصلی ماژول جدید را ثبت کنید:

```blade
{{-- در index.blade.php اضافه کنید --}}
@include('PageBuilder::design.editors.custom_module')
```

### ساختار داده ماژول

```php
$module = [
    'code' => 'custom_module',           // کد ماژول
    'module_id' => 'unique_id',          // شناسه یکتای ماژول
    'name' => 'ماژول سفارشی',              // نام ماژول
    'title' => 'ماژول سفارشی',            // عنوان ماژول
    'content' => [                       // محتوای ماژول
        'title' => 'عنوان ماژول',
        'description' => 'توضیحات ماژول',
        // سایر فیلدهای سفارشی
    ],
    'view_path' => 'PageBuilder::front.modules.custom_module'
];
```

## توسعه فرانت‌اند

### سیستم کامپوننت Vue

#### کامپوننت‌های سراسری
- `module-editor`: کانتینر ویرایشگر ماژول
- `single-image-selector`: انتخابگر تک تصویر
- `multi-image-selector`: انتخابگر چند تصویر
- `link-selector`: انتخابگر لینک

#### ارتباط کامپوننت
```javascript
// ارسال به‌روزرسانی از کامپوننت فرزند به والد
this.$emit('update', newContent);

// گوش دادن به به‌روزرسانی در کامپوننت والد
<module-editor @update="moduleUpdated" />
```

### ارتباط AJAX

#### به‌روزرسانی ماژول
```javascript
// ارسال داده ماژول به بک‌اند
axios.post(url + '?design=1', moduleData)
  .then((res) => {
    // به‌روزرسانی ناحیه پیش‌نمایش
    $(previewWindow.document).find('#module-' + moduleId).replaceWith(res);
  });
```

#### پردازش debounce
```javascript
// استفاده از inno.debounce برای جلوگیری از درخواست‌های مکرر
moduleUpdated: inno.debounce(function(val) {
  // منطق به‌روزرسانی
}, 300)
```

### توسعه استایل

#### معماری CSS
```scss
// استایل طراح
.design-box {
  .sidebar { /* استایل نوار کناری */ }
  .preview-iframe { /* استایل ناحیه پیش‌نمایش */ }
}

// استایل ماژول
.module-item {
  .module-content { /* محتوای ماژول */ }
  .module-edit { /* نوار ابزار ویرایش */ }
}

// طراحی واکنش‌گرا
.device-mobile { /* استایل موبایل */ }
.device-pc { /* استایل دسکتاپ */ }
```

## راهنمای توسعه ماژول

### 🚀 جریان کامل افزودن ماژول سفارشی

این راهنما به تفصیل نحوه ایجاد یک ماژول سفارشی کامل از صفر را شرح می‌دهد، شامل تمام فایل‌ها و پیکربندی‌های لازم.

#### 1. تعیین نیازمندی‌های ماژول

قبل از شروع توسعه، باید عملکرد ماژول را مشخص کنید:

- **نوع ماژول**: ماژول رسانه، ماژول محصول، ماژول محتوا، ماژول چیدمان
- **شرح عملکرد**: عملکرد اصلی و اثر نمایشی ماژول
- **ساختار داده**: چه فیلدها و گزینه‌های پیکربندی نیاز دارد
- **نحوه تعامل**: آیا نیاز به تعامل کاربر، اثرات انیمیشن و غیره دارد

#### 2. ایجاد ساختار فایل ماژول

```
Views/
├── design/
│   └── editors/
│       └── custom_module.blade.php    # ویرایشگر ماژول
└── front/
    └── modules/
        └── custom_module.blade.php    # قالب ماژول فرانت
```

#### 3. تعریف پیکربندی ماژول

در `ModuleRepo.php` تعریف ماژول را اضافه کنید:

```php
// در متد ModuleRepo::getModules() اضافه کنید
[
    'title'   => 'ماژول سفارشی',
    'code'    => 'custom_module',
    'icon'    => '<i class="bi bi-grid"></i>',
    'content' => [
        'title'    => self::languagesFill('عنوان ماژول'),
        'subtitle' => self::languagesFill('زیرعنوان ماژول'),
        'images'   => [
            [
                'image' => 'images/demo/custom/custom-1.jpg',
                'link'  => '',
                'type'  => 'product'
            ]
        ],
        'settings' => [
            'show_title'    => true,
            'show_subtitle' => true,
            'layout'        => 'grid'
        ]
    ],
],
```

#### 4. ایجاد ویرایشگر ماژول

ایجاد `Views/design/editors/custom_module.blade.php`:

```blade
<script type="text/x-template" id="custom-module-editor">
    <div class="module-editor">
        <div class="editor-header">
            <h5>تنظیمات ماژول سفارشی</h5>
        </div>
        
        <div class="editor-content">
            <!-- تنظیمات پایه -->
            <div class="editor-section">
                <h6>تنظیمات پایه</h6>
                
                <div class="form-group">
                    <label>عنوان ماژول</label>
                    <input type="text" v-model="content.title" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>زیرعنوان ماژول</label>
                    <input type="text" v-model="content.subtitle" class="form-control">
                </div>
            </div>
            
            <!-- تنظیمات تصویر -->
            <div class="editor-section">
                <h6>تنظیمات تصویر</h6>
                
                <multi-image-selector 
                    v-model="content.images"
                    :max="4"
                    :show-link="true"
                    :show-type="true">
                </multi-image-selector>
            </div>
            
            <!-- تنظیمات استایل -->
            <div class="editor-section">
                <h6>تنظیمات استایل</h6>
                
                <div class="form-group">
                    <label>نمایش عنوان</label>
                    <div class="btn-group" role="group">
                        <button type="button" 
                                class="btn btn-sm" 
                                :class="content.settings.show_title ? 'btn-primary' : 'btn-outline-primary'"
                                @click="content.settings.show_title = true">
                            نمایش
                        </button>
                        <button type="button" 
                                class="btn btn-sm" 
                                :class="!content.settings.show_title ? 'btn-primary' : 'btn-outline-primary'"
                                @click="content.settings.show_title = false">
                            مخفی
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>نحوه چیدمان</label>
                    <select v-model="content.settings.layout" class="form-control">
                        <option value="grid">چیدمان شبکه‌ای</option>
                        <option value="list">چیدمان لیستی</option>
                        <option value="slider">چیدمان اسلایدری</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</script>

<script>
Vue.component('custom-module-editor', {
    template: '#custom-module-editor',
    props: ['content'],
    watch: {
        content: {
            handler: function(val) {
                this.$emit('update', val);
            },
            deep: true
        }
    },
    mounted() {
        // مقداردهی اولیه پیش‌فرض
        if (!this.content.settings) {
            this.$set(this.content, 'settings', {
                show_title: true,
                show_subtitle: true,
                layout: 'grid'
            });
        }
    }
});
</script>
```

#### 5. ایجاد قالب ماژول فرانت

ایجاد `Views/front/modules/custom_module.blade.php`:

```blade
<div id="module-{{ $module_id }}" class="module-item custom-module">
    <div class="module-content">
        @if($content['settings']['show_title'] && $content['title'])
            <div class="module-title">
                <h2>{{ $content['title'] }}</h2>
                @if($content['subtitle'])
                    <p class="subtitle">{{ $content['subtitle'] }}</p>
                @endif
            </div>
        @endif
        
        @if(!empty($content['images']))
            <div class="custom-content layout-{{ $content['settings']['layout'] }}">
                @foreach($content['images'] as $image)
                    <div class="custom-item">
                        <div class="image-wrapper">
                            @if($image['link'])
                                <a href="{{ $image['link'] }}" 
                                   @if($image['type'] == 'product') target="_blank" @endif>
                                    <img src="{{ $image['image'] }}" alt="تصویر سفارشی">
                                </a>
                            @else
                                <img src="{{ $image['image'] }}" alt="تصویر سفارشی">
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    
    @if($design)
        <div class="module-edit">
            <div class="edit"><i class="bi bi-pencil"></i></div>
            <div class="delete"><i class="bi bi-trash"></i></div>
            <div class="up"><i class="bi bi-arrow-up"></i></div>
            <div class="down"><i class="bi bi-arrow-down"></i></div>
        </div>
    @endif
</div>

<style>
.custom-module {
    padding: 20px 0;
}

.custom-module .module-title {
    text-align: center;
    margin-bottom: 30px;
}

.custom-module .module-title h2 {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
}

.custom-module .subtitle {
    font-size: 16px;
    color: #666;
}

.custom-content.layout-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.custom-content.layout-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.custom-content.layout-slider {
    position: relative;
    overflow: hidden;
}

.custom-item {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.custom-item .image-wrapper img {
    width: 100%;
    height: auto;
    display: block;
}

/* طراحی واکنش‌گرا */
@media (max-width: 768px) {
    .custom-content.layout-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .custom-module .module-title h2 {
        font-size: 24px;
    }
}
</style>
```

#### 6. ثبت ماژول در صفحه اصلی

در `Views/design/index.blade.php` ویرایشگر ماژول را وارد کنید:

```blade
{{-- پس از وارد کردن سایر ویرایشگرهای ماژول اضافه کنید --}}
@include('PageBuilder::design.editors.custom_module')
```

#### 7. تست عملکرد ماژول
1. **دسترسی به طراح**: پنل مدیریت → طراحی → سازنده صفحه
2. **افزودن ماژول**: از کتابخانه ماژول سمت چپ کشیدن "ماژول سفارشی" به ناحیه پیش‌نمایش
3. **ویرایش ماژول**: کلیک روی ماژول برای ورود به حالت ویرایش، تست تمام عملکردها
4. **بررسی اثر**: بررسی اثر نمایش فرانت و چیدمان واکنش‌گرا
5. **تست ذخیره**: ذخیره صفحه و بررسی صحت ذخیره داده

#### 8. توضیح ساختار داده ماژول

```php
// ساختار کامل داده ماژول
$module = [
    'code' => 'custom_module',           // کد ماژول
    'module_id'  => 'custom_123456',     // شناسه یکتای ماژول
    'name'       => 'ماژول سفارشی',               // نام ماژول
    'title'      => 'ماژول سفارشی',               // عنوان ماژول
    'content' => [                       // محتوای ماژول
        'title'    => 'عنوان ماژول',               // عنوان چندزبانه
        'subtitle' => 'زیرعنوان ماژول',            // زیرعنوان چندزبانه
        'images' => [                    // آرایه تصاویر
            [
                'image' => 'path/to/image.jpg', // مسیر تصویر
                'link'  => 'https://example.com', // آدرس لینک
                'type'  => 'product'            // نوع لینک
            ]
        ],
        'settings' => [                  // گزینه‌های تنظیم
            'show_title'    => true,           // آیا نمایش عنوان
            'show_subtitle' => true,           // آیا نمایش زیرعنوان
            'layout'        => 'grid'          // نحوه چیدمان
        ]
    ],
    'view_path' => 'PageBuilder::front.modules.custom_module' // مسیر قالب
];
```

#### 9. نکات مهم توسعه

1. **استانداردهای نام‌گذاری**:
   - کد ماژول از حروف کوچک و خط زیر استفاده کند
   - نام فایل از حروف کوچک و خط زیر استفاده کند
   - نام کامپوننت Vue از خط تیره استفاده کند

2. **اعتبارسنجی داده**:
   - در ویرایشگر اعتبارسنجی لازم را اضافه کنید
   - مقادیر پیش‌فرض منطقی تنظیم کنید
   - حالت داده خالی را مدیریت کنید

3. **طراحی استایل**:
   - از طراحی واکنش‌گرا استفاده کنید
   - استانداردهای طراحی را رعایت کنید
   - اثر نمایش در دستگاه‌های مختلف را در نظر بگیرید

4. **بهینه‌سازی عملکرد**:
   - از computed و watch Vue به صورت منطقی استفاده کنید
   - از عملیات DOM غیرضروری جلوگیری کنید
   - بارگذاری تصویر را بهینه کنید

#### 10. حل مشکلات رایج

**س: ویرایشگر ماژول نمایش داده نمی‌شود؟**
ج: بررسی کنید که کامپوننت Vue به درستی ثبت شده، تأیید کنید که ID قالب مطابقت دارد.

**س: قالب فرانت رندر نمی‌شود؟**
ج: مسیر قالب را بررسی کنید، فرمت داده را تأیید کنید.

**س: استایل اعمال نمی‌شود؟**
ج: انتخابگر CSS را بررسی کنید، بارگذاری فایل استایل را تأیید کنید.

**س: چندزبانه نمایش داده نمی‌شود؟**
ج: استفاده از متد `self::languagesFill()` را تأیید کنید، پیکربندی بسته زبان را بررسی کنید.

## توسعه گسترش

### سیستم Hook

#### Hook داده
```php
// ثبت hook داده
listen_hook_filter('admin.design.preview.data', function ($viewData) {
    // تغییر داده پیش‌نمایش
    return $viewData;
});
```

#### Hook جریان
```php
// ثبت hook جریان
listen_hook_action('admin.design.module.saved', function ($module) {
    // پردازش پس از ذخیره ماژول
});
```

### سرویس سفارشی

#### ایجاد کلاس سرویس
```php
<?php
namespace Plugin\PageBuilder\Services;

class CustomService
{
    public function processModule($module)
    {
        // منطق پردازش سفارشی
        return $module;
    }
}
```

#### ثبت سرویس
```php
// ثبت در Boot.php
$this->app->singleton(CustomService::class);
```

## راهنمای دیباگ

### دیباگ فرانت‌اند
```javascript
// فعال کردن دیباگ Vue
Vue.config.devtools = true;

// دیباگ به‌روزرسانی ماژول
console.log('Module updated:', val);

// دیباگ درخواست AJAX
axios.interceptors.request.use(config => {
    console.log('Request:', config);
    return config;
});
```

### دیباگ بک‌اند
```php
// دیباگ داده ماژول
Log::info('Module data:', $module);

// دیباگ داده پیش‌نمایش
dd($viewData);
```

### بهینه‌سازی عملکرد

#### بهینه‌سازی فرانت‌اند
- استفاده از `v-show` به جای `v-if` برای کاهش عملیات DOM
- استفاده منطقی از `computed` و `watch`
- بارگذاری تنبل و فشرده‌سازی تصویر

#### بهینه‌سازی بک‌اند
- بهینه‌سازی کوئری پایگاه داده
- مکانیزم کش
- پردازش ناهمزمان

## راهنمای تست

### تست واحد
```php
<?php
namespace Tests\Unit\PageBuilder;

use Tests\TestCase;
use Plugin\PageBuilder\Services\PageBuilderService;

class PageBuilderServiceTest extends TestCase
{
    public function test_get_page_data()
    {
        $service = new PageBuilderService();
        $data = $service->getPageData('home');
        
        $this->assertIsArray($data);
        $this->assertArrayHasKey('modules', $data);
    }
}
```

### تست عملکردی
```php
<?php
namespace Tests\Feature\PageBuilder;

use Tests\TestCase;

class PageBuilderTest extends TestCase
{
    public function test_preview_module()
    {
        $response = $this->post('/panel/pbuilder/home/modules/preview', [
            'code' => 'slideshow',
            'module_id' => 'test_123'
        ]);
        
        $response->assertStatus(200);
    }
}
```

## راهنمای استقرار

### پیکربندی محیط تولید
```php
// خاموش کردن حالت دیباگ
APP_DEBUG=false

// فعال کردن کش
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### کامپایل منابع استاتیک
```bash
# کامپایل منابع فرانت‌اند
npm run build

# فشرده‌سازی CSS و JS
npm run production
```

## مشکلات رایج

### س: پیش‌نمایش ماژول به‌روزرسانی نمی‌شود؟
ج: درخواست AJAX موفق بودن را بررسی کنید، وجود آبجکت `previewWindow` را تأیید کنید.

### س: عملکرد کشیدن کار نمی‌کند؟
ج: بارگذاری صحیح Sortable.js را تأیید کنید، وجود عنصر DOM را بررسی کنید.

### س: استایل اعمال نمی‌شود؟
ج: بارگذاری صحیح فایل CSS را بررسی کنید، اولویت انتخابگر را تأیید کنید.

### س: چندزبانه نمایش داده نمی‌شود؟
ج: استفاده از فایل بسته زبان را تأیید کنید، منطق تغییر زبان را بررسی کنید.

## راهنمای مشارکت

### استانداردهای کد
- رعایت استاندارد کدنویسی PSR-12
- استفاده از نشانه نوع و نوع مقدار بازگشتی
- نوشتن مستندات کامل توضیحات

### استانداردهای ارسال
```
feat: افزودن عملکرد جدید
fix: رفع باگ
docs: به‌روزرسانی مستندات
style: تنظیم فرمت کد
refactor: بازسازی کد
test: افزودن تست
chore: تغییر فرآیند ساخت یا ابزارهای کمکی
```

### مدیریت شاخه
- `main`: شاخه اصلی، نسخه پایدار
- `develop`: شاخه توسعه
- `feature/*`: شاخه عملکرد
- `hotfix/*`: شاخه رفع سریع

---

**تیم توسعه PageBuilder** - توسعه را کارآمدتر کنید! 