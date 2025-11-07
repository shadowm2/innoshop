<?php

/**
 * Copyright (c) Since 2024 InnoShop - All Rights Reserved
 *
 * @link       https://www.innoshop.com
 * @author     InnoShop <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use InnoShop\Common\Models\Page;

class PageSeeder extends Seeder
{
  public function run(): void
  {
    $items = $this->getPages();
    if ($items) {
      Page::query()->truncate();
      foreach ($items as $item) {
        Page::query()->create($item);
      }
    }

    $items = $this->getPageTranslations();
    if ($items) {
      Page\Translation::query()->truncate();
      foreach ($items as $item) {
        Page\Translation::query()->create($item);
      }
    }
  }

  /**
   * @return array[]
   */
  private function getPages(): array
  {
    return [
      [
        'id'     => 1,
        'slug'   => 'creations',
        'viewed' => 666,
        'active' => 1,
      ],
      [
        'id'     => 2,
        'slug'   => 'services',
        'viewed' => 888,
        'active' => 1,
      ],
      [
        'id'     => 3,
        'slug'   => 'about',
        'viewed' => 999,
        'active' => 1,
      ],
      [
        'id'     => 4,
        'slug'   => 'privacy-policy',
        'viewed' => 0,
        'active' => 1,
      ],
    ];
  }

  /**
   * @return array[]
   */
  private function getPageTranslations(): array
  {
    return [
      [
        'page_id'  => 1,
        'locale'   => 'zh-cn',
        'title'    => 'محصولات',
        'content'  => '',
        'template' => '<div class="page-product-content">
    <div class="container">
      <div class="title-box">
        <div class="title">محصولات ما</div>
        <div class="sub-title">Our Creations</div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="product-item">
            <div class="top">
              <div class="left"><i class="bi bi-box-seam-fill"></i></div>
              <div class="name">InnoShop</div>
            </div>
            <div class="content">
              InnoShop یک پلتفرم تجارت الکترونیک برای کسب‌وکارهای کوچک و متوسط است که راه‌حل جامع فروشگاه آنلاین ارائه می‌دهد. این پلتفرم به دلیل رابط کاربری دوستانه و قابلیت‌های قدرتمند مدیریت پشتیبان شناخته شده است و به فروشندگان کمک می‌کند تا به راحتی محصولات، سفارشات و روابط مشتریان را مدیریت کنند. InnoShop از روش‌های مختلف پرداخت پشتیبانی می‌کند و ابزارهای بازاریابی رسانه‌های اجتماعی را ادغام کرده است تا به فروشندگان در گسترش تأثیر بازار کمک کند.
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="product-item">
            <div class="top">
              <div class="left"><i class="bi bi-box-seam-fill"></i></div>
              <div class="name">InnoShop Pro</div>
            </div>
            <div class="content">
              InnoShop Pro نسخه پیشرفته InnoShop است که برای شرکت‌هایی که به قابلیت‌های پیشرفته‌تر و خدمات سفارشی نیاز دارند، طراحی شده است. علاوه بر تمام قابلیت‌های نسخه پایه، نسخه Pro تحلیل داده‌های پیشرفته، موتور توصیه شخصی‌سازی شده و ادغام API ارائه می‌دهد تا نیازهای تجاری پیچیده‌تر را برآورده کند. همچنین شامل پشتیبانی حرفه‌ای مشتری و خدمات به‌روزرسانی اولویت‌دار است تا اطمینان حاصل شود که فروشندگان بتوانند به طور کامل از پتانسیل پلتفرم استفاده کنند.
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="product-item">
            <div class="top">
              <div class="left"><i class="bi bi-wechat"></i></div>
              <div class="name">مینی اپلیکیشن</div>
            </div>
            <div class="content">
              مینی اپلیکیشن ما تجربه خرید راحتی را برای کاربران موبایل فراهم می‌کند. این اپلیکیشن سبک و قابل دسترس است و به ویژه برای مرور و خرید سریع مناسب است. مینی اپلیکیشن به طور یکپارچه با رسانه‌های اجتماعی اصلی و ابزارهای ارتباطی ادغام شده است، از اشتراک‌گذاری یک کلیکه و دعوت دوستان پشتیبانی می‌کند، و از طریق شبکه‌های اجتماعی به سرعت گسترش می‌یابد و چسبندگی کاربر و نمایش برند را افزایش می‌دهد.
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="product-item">
            <div class="top">
              <div class="left"><i class="bi bi-phone-fill"></i></div>
              <div class="name">اپلیکیشن موبایل</div>
            </div>
            <div class="content">
              اپلیکیشن ما یک برنامه بهینه‌سازی شده برای دستگاه‌های موبایل است که تجربه کاربری غنی‌تر و شخصی‌سازی شده‌ای ارائه می‌دهد. این اپلیکیشن نه تنها شامل تمام قابلیت‌های مینی اپلیکیشن است، بلکه اعلان‌های شخصی‌سازی شده، قابلیت جستجوی پیشرفته و عناصر تعامل کاربری پیشرفته‌تری را نیز اضافه کرده است. طراحی اپلیکیشن بر روی روانی و تعاملی بودن تمرکز دارد تا اطمینان حاصل شود که کاربران در دستگاه‌های موبایل نیز بتوانند از تجربه خرید و خدمات با کیفیت بالا لذت ببرند.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>',
        'meta_title'       => 'محصولات',
        'meta_description' => 'محصولات',
        'meta_keywords'    => 'محصولات',
      ],
      [
        'page_id'  => 2,
        'locale'   => 'zh-cn',
        'title'    => 'خدمات',
        'content'  => '',
        'template' => "<div class=\"page-service-content\">
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-12 col-md-5\">
          <div class=\"service-icon\"><img src=\"{{ asset('images/front/service/bg-1.png') }}\" class=\"img-fluid\"></div>
        </div>
        <div class=\"col-12 col-md-7\">
          <div class=\"row\">
            <div class=\"col-12\">
              <div class=\"title-box\">
                <div class=\"title\">خدمات ما</div>
                <div class=\"sub-title\">ما نه تنها راه‌حل‌های سفارشی ارائه می‌دهیم، بلکه با دانش فنی حرفه‌ای، تفکر نوآورانه و پشتیبانی جامع، اطمینان حاصل می‌کنیم که شما بتوانید از تجربه خدمات عالی و کارآمد لذت ببرید. ما متعهد هستیم که صرف نظر از تغییرات نیازهای شما، بتوانیم مناسب‌ترین خدمات حرفه‌ای را برای شما ارائه دهیم.</div>
              </div>
            </div>
            <div class=\"col-12 col-md-6\">
              <div class=\"service-item\">
                <div class=\"icon\"><i class=\"bi bi-house-door-fill\"></i></div>
                <div class=\"title\">سیستم متن‌باز</div>
                <div class=\"sub-title\">متعهد به ارائه راه‌حل‌های بسیار انعطاف‌پذیر و قابل سفارشی‌سازی هستیم. با استفاده از مزایای کد منبع باز، ما به شرکت‌ها کمک می‌کنیم تا سیستم‌های مقیاس‌پذیر بسازند، در حالی که شفافیت و پشتیبانی جامعه را تضمین می‌کنیم.</div>
              </div>
            </div>
            <div class=\"col-12 col-md-6\">
              <div class=\"service-item\">
                <div class=\"icon\"><i class=\"bi bi-house-door-fill\"></i></div>
                <div class=\"title\">بازار افزونه‌ها</div>
                <div class=\"sub-title\">از طریق بازار افزونه‌های ما، کاربران می‌توانند به راحتی قابلیت‌های سیستم خود را گسترش دهند. ما انتخاب غنی از افزونه‌ها ارائه می‌دهیم تا نیازهای مختلف تجاری را برآورده کند و خدمات سفارشی‌سازی را در دسترس قرار دهد.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class=\"row\">
        <div class=\"col-12 col-md-1\"></div>
        <div class=\"col-12 col-md-11 service-row-2\">
          <div class=\"row\">
            <div class=\"col-12 col-md-4\">
              <div class=\"service-item\">
                <div class=\"icon\"><i class=\"bi bi-house-door-fill\"></i></div>
                <div class=\"title\">توسعه سفارشی</div>
                <div class=\"sub-title\">بر ایجاد راه‌حل‌های نرم‌افزاری منحصر به فرد بر اساس نیازهای خاص شما تمرکز داریم. از مفهوم تا پیاده‌سازی، ما با شما به طور نزدیک همکاری می‌کنیم تا اطمینان حاصل کنیم که محصول نهایی از انتظارات شما فراتر رود.</div>
              </div>
            </div>
            <div class=\"col-12 col-md-4\">
              <div class=\"service-item\">
                <div class=\"icon\"><i class=\"bi bi-house-door-fill\"></i></div>
                <div class=\"title\">نصب و نگهداری</div>
                <div class=\"sub-title\">خدمات نصب و نگهداری ما اطمینان حاصل می‌کند که سیستم شما به طور روان اجرا شود. از طریق به‌روزرسانی‌های منظم و رفع اشکال، ما پشتیبانی فنی بدون دردسر ارائه می‌دهیم تا شما بتوانید روی کسب‌وکار اصلی خود تمرکز کنید.</div>
              </div>
            </div>
            <div class=\"col-12 col-md-4\">
              <div class=\"service-item\">
                <div class=\"icon\"><i class=\"bi bi-house-door-fill\"></i></div>
                <div class=\"title\">آموزش فنی</div>
                <div class=\"sub-title\">از طریق خدمات آموزش فنی ما، تیم شما مهارت‌ها و دانش لازم را به دست خواهد آورد. دوره‌های آموزشی ما برای افزایش کارایی، ترویج نوآوری و تضمین خودکفایی فنی بلندمدت طراحی شده‌اند.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>",
        'meta_title'       => 'خدمات',
        'meta_description' => 'خدمات',
        'meta_keywords'    => 'خدمات',
      ],
      [
        'page_id'  => 3,
        'locale'   => 'zh-cn',
        'title'    => 'درباره ما',
        'content'  => '',
        'template' => "<div class=\"page-about-content\">
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-12 col-md-6\">
        <div class=\"about-img\">
          <img src=\"{{ asset('images/front/about/bg-2.png') }}\" class=\"img-fluid\">
        </div>
      </div>
      <div class=\"col-12 col-md-6\">
        <div class=\"about-text\">
          <div class=\"main-title\">نوآوری محور، تیم حرفه‌ای، فناوری برتر، آینده‌سازی مشترک.</div>
          <div class=\"about-text-item\">
            <div class=\"left\"><i class=\"bi bi-check-circle\"></i></div>
            <div class=\"right\">
              <div class=\"title\">تیم ما</div>
              <div class=\"sub-title\">
                تیم ما متشکل از گروهی از متخصصان پرشور و خلاق است که از پیشینه‌های مختلف می‌آیند، اما همگی اشتراک در علاقه به فناوری و تعقیب تعالی دارند. ما همکاری و تبادل نظر بین اعضای تیم را تشویق می‌کنیم تا برخورد تفکرات نوآورانه و تسهیم دانش را ترویج دهیم.
              </div>
            </div>
          </div>
          <div class=\"about-text-item\">
            <div class=\"left\"><i class=\"bi bi-check-circle\"></i></div>
            <div class=\"right\">
              <div class=\"title\">محیط کاری</div>
              <div class=\"sub-title\">
                فضای کاری ما مدرن و راحت طراحی شده است تا خلاقیت کارکنان را تحریک کند و بهره‌وری کار را افزایش دهد. مناطق کاری باز ارتباط و همکاری بین اعضای تیم را ترویج می‌کند، در عین حال، ما مناطق آرام استراحت نیز فراهم کرده‌ایم تا کارکنان در فواصل کار فشرده بتوانند آرامش یابند.
              </div>
            </div>
          </div>
          <div class=\"about-text-item\">
            <div class=\"left\"><i class=\"bi bi-check-circle\"></i></div>
            <div class=\"right\">
              <div class=\"title\">توانایی‌های فنی</div>
              <div class=\"sub-title\">
                ما دارای قدرت فنی قوی هستیم، اعضای تیم نه تنها در جدیدترین زبان‌های برنامه‌نویسی و ابزارهای توسعه مهارت دارند، بلکه درک عمیق و تجربه عملی در فناوری‌های پیشرو مانند هوش مصنوعی، یادگیری ماشین و تحلیل داده نیز دارند. ما متعهد به استفاده از این فناوری‌ها برای ایجاد راه‌حل‌های کارآمد و هوشمند برای کاربران هستیم.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>",
        'meta_title'       => 'درباره ما',
        'meta_description' => 'درباره ما',
        'meta_keywords'    => 'درباره ما',
      ],
      [
        'page_id'          => 1,
        'locale'           => 'en',
        'title'            => 'Creations',
        'content'          => 'This is Creations page for English',
        'meta_title'       => 'Creations',
        'meta_description' => 'Creations',
        'meta_keywords'    => 'Creations',
      ],
      [
        'page_id'          => 1,
        'locale'           => 'en',
        'title'            => 'محصولات',
        'content'          => 'صفحه محصولات به فارسی',
        'meta_title'       => 'محصولات',
        'meta_description' => 'محصولات',
        'meta_keywords'    => 'محصولات',
      ],
      [
        'page_id'          => 2,
        'locale'           => 'en',
        'title'            => 'Services',
        'content'          => 'This is Services page for English',
        'meta_title'       => 'Services',
        'meta_description' => 'Services',
        'meta_keywords'    => 'Services',
      ],
      [
        'page_id'          => 2,
        'locale'           => 'fa',
        'title'            => 'خدمات',
        'content'          => 'صفحه خدمات به فارسی',
        'meta_title'       => 'خدمات',
        'meta_description' => 'خدمات',
        'meta_keywords'    => 'خدمات',
      ],
      [
        'page_id'          => 3,
        'locale'           => 'en',
        'title'            => 'About',
        'content'          => 'This is About page for English',
        'meta_title'       => 'About Us',
        'meta_description' => 'About Us',
        'meta_keywords'    => 'About Us',
      ],
      [
        'page_id'          => 3,
        'locale'           => 'fa',
        'title'            => 'درباره ما',
        'content'          => 'صفحه درباره ما فارسی',
        'meta_title'       => 'درباره ما',
        'meta_description' => 'درباره ما',
        'meta_keywords'    => 'درباره ما',
      ],
      [
        'page_id' => 4,
        'locale'  => 'zh-cn',
        'title'   => 'سیاست حفظ حریم خصوصی',
        'content' => '<p>InnoShop بسیار به حفاظت از حریم خصوصی کاربران اهمیت می‌دهد. این سیاست حفظ حریم خصوصی نحوه جمع‌آوری، استفاده و حفاظت از اطلاعات شخصی شما را توضیح می‌دهد.</p>

<h3>۱. جمع‌آوری اطلاعات</h3>
<p>اطلاعاتی که ما جمع‌آوری می‌کنیم شامل:</p>
<ul>
    <li>اطلاعات حساب کاربری: ایمیل، نام کاربری و غیره</li>
    <li>اطلاعات دستگاه: آدرس IP، نوع مرورگر و غیره</li>
    <li>داده‌های استفاده: سوابق دسترسی، گزارش‌های عملیات و غیره</li>
</ul>

<h3>۲. استفاده از اطلاعات</h3>
<p>ما از اطلاعات جمع‌آوری شده برای موارد زیر استفاده می‌کنیم:</p>
<ul>
    <li>ارائه و بهبود خدمات</li>
    <li>ارسال اطلاعیه‌های مهم</li>
    <li>جلوگیری از کلاهبرداری و سوءاستفاده</li>
</ul>

<h3>۳. حفاظت از اطلاعات</h3>
<p>ما اقدامات امنیتی سختگیرانه‌ای برای حفاظت از اطلاعات شما اتخاذ می‌کنیم، از جمله:</p>
<ul>
    <li>ذخیره‌سازی رمزگذاری شده داده‌ها</li>
    <li>کنترل دسترسی</li>
    <li>ممیزی امنیتی منظم</li>
</ul>

<h3>۴. اشتراک‌گذاری اطلاعات</h3>
<p>ما اطلاعات شخصی شما را نمی‌فروشیم. تنها در موارد زیر ممکن است اطلاعات را به اشتراک بگذاریم:</p>
<ul>
    <li>دریافت رضایت صریح شما</li>
    <li>الزامات قانونی</li>
    <li>حفاظت از منافع قانونی ما</li>
</ul>

<h3>۵. حقوق شما</h3>
<p>شما حق دارید:</p>
<ul>
    <li>به اطلاعات شخصی خود دسترسی داشته باشید</li>
    <li>اطلاعات نادرست را تصحیح کنید</li>
    <li>درخواست حذف اطلاعات خود کنید</li>
    <li>پردازش اطلاعات را محدود کنید</li>
</ul>

<h3>۶. تماس با ما</h3>
<p>اگر سوالی درباره سیاست حفظ حریم خصوصی دارید، لطفاً با ما تماس بگیرید:</p>
<p>ایمیل: privacy@innoshop.com</p>',
        'meta_title'       => 'سیاست حفظ حریم خصوصی - InnoShop',
        'meta_description' => 'توضیح سیاست حفظ حریم خصوصی InnoShop',
        'meta_keywords'    => 'سیاست حفظ حریم خصوصی,حفاظت از داده‌ها,اطلاعات شخصی',
      ],
      [
        'page_id' => 4,
        'locale'  => 'fa',
        'title'   => 'سیاست حفظ حریم خصوصی',
        'content' => '<p>InnoShop بسیار به حفاظت از حریم خصوصی کاربران اهمیت می‌دهد. این سیاست حفظ حریم خصوصی نحوه جمع‌آوری، استفاده و حفاظت از اطلاعات شخصی شما را توضیح می‌دهد.</p>

<h3>۱. جمع‌آوری اطلاعات</h3>
<p>اطلاعاتی که ما جمع‌آوری می‌کنیم شامل:</p>
<ul>
    <li>اطلاعات حساب کاربری: ایمیل، نام کاربری و غیره</li>
    <li>اطلاعات دستگاه: آدرس IP، نوع مرورگر و غیره</li>
    <li>داده‌های استفاده: سوابق دسترسی، گزارش‌های عملیات و غیره</li>
</ul>

<h3>۲. استفاده از اطلاعات</h3>
<p>ما از اطلاعات جمع‌آوری شده برای موارد زیر استفاده می‌کنیم:</p>
<ul>
    <li>ارائه و بهبود خدمات</li>
    <li>ارسال اطلاعیه‌های مهم</li>
    <li>جلوگیری از کلاهبرداری و سوءاستفاده</li>
</ul>

<h3>۳. حفاظت از اطلاعات</h3>
<p>ما اقدامات امنیتی سختگیرانه‌ای برای حفاظت از اطلاعات شما اتخاذ می‌کنیم، از جمله:</p>
<ul>
    <li>ذخیره‌سازی رمزگذاری شده داده‌ها</li>
    <li>کنترل دسترسی</li>
    <li>ممیزی امنیتی منظم</li>
</ul>

<h3>۴. اشتراک‌گذاری اطلاعات</h3>
<p>ما اطلاعات شخصی شما را نمی‌فروشیم. تنها در موارد زیر ممکن است اطلاعات را به اشتراک بگذاریم:</p>
<ul>
    <li>دریافت رضایت صریح شما</li>
    <li>الزامات قانونی</li>
    <li>حفاظت از منافع قانونی ما</li>
</ul>

<h3>۵. حقوق شما</h3>
<p>شما حق دارید:</p>
<ul>
    <li>به اطلاعات شخصی خود دسترسی داشته باشید</li>
    <li>اطلاعات نادرست را تصحیح کنید</li>
    <li>درخواست حذف اطلاعات خود کنید</li>
    <li>پردازش اطلاعات را محدود کنید</li>
</ul>

<h3>۶. تماس با ما</h3>
<p>اگر سوالی درباره سیاست حفظ حریم خصوصی دارید، لطفاً با ما تماس بگیرید:</p>
<p>ایمیل: privacy@innoshop.com</p>',
        'meta_title'       => 'سیاست حفظ حریم خصوصی - InnoShop',
        'meta_description' => 'توضیح سیاست حفظ حریم خصوصی InnoShop',
        'meta_keywords'    => 'سیاست حفظ حریم خصوصی,حفاظت از داده‌ها,اطلاعات شخصی',
      ],
      [
        'page_id' => 4,
        'locale'  => 'en',
        'title'   => 'Privacy Policy',
        'content' => '<p>InnoShop takes your privacy seriously. This Privacy Policy explains how we collect, use, and protect your personal information.</p>

<h3>1. Information Collection</h3>
<p>We collect the following information:</p>
<ul>
    <li>Account information: email, username, etc.</li>
    <li>Device information: IP address, browser type, etc.</li>
    <li>Usage data: access records, operation logs, etc.</li>
</ul>

<h3>2. Information Usage</h3>
<p>We use the collected information to:</p>
<ul>
    <li>Provide and improve services</li>
    <li>Send important notifications</li>
    <li>Prevent fraud and abuse</li>
</ul>

<h3>3. Information Protection</h3>
<p>We implement strict security measures to protect your information, including:</p>
<ul>
    <li>Data encryption</li>
    <li>Access control</li>
    <li>Regular security audits</li>
</ul>

<h3>4. Information Sharing</h3>
<p>We do not sell your personal information. We may share information only in the following cases:</p>
<ul>
    <li>With your explicit consent</li>
    <li>When required by law</li>
    <li>To protect our legal rights</li>
</ul>

<h3>5. Your Rights</h3>
<p>You have the right to:</p>
<ul>
    <li>Access your personal information</li>
    <li>Correct inaccurate information</li>
    <li>Request deletion of your information</li>
    <li>Restrict information processing</li>
</ul>

<h3>6. Contact Us</h3>
<p>If you have any questions about our Privacy Policy, please contact us:</p>
<p>Email: privacy@innoshop.com</p>',
        'meta_title'       => 'Privacy Policy - InnoShop',
        'meta_description' => 'InnoShop Privacy Policy',
        'meta_keywords'    => 'Privacy Policy, Data Protection, Personal Information',
      ],
    ];
  }
}
