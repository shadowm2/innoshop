<?php
/**
 * Copyright (c) Since 2024 InnoShop - All Rights Reserved
 *
 * @link       https://www.innoshop.com
 * @author     InnoShop <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace Plugin\PageBuilder\Controllers\Panel;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InnoShop\Panel\Controllers\BaseController;
use Plugin\PageBuilder\Services\DesignService;
use Plugin\PageBuilder\Services\PageBuilderService;

class PageBuilderController extends BaseController
{
    protected PageBuilderService $pageBuilderService;

    public function __construct()
    {
        $this->pageBuilderService = new PageBuilderService;
    }

    /**
     * صفحه اصلی ویرایش صفحه - پردازش یکپارچه صفحه اصلی و صفحات تکی
     *
     * @param  string|null  $page  شناسه صفحه، 'home' نشان‌دهنده صفحه اصلی، سایر موارد ID یا slug صفحه، null به معنای صفحه اصلی
     * @return mixed
     * @throws Exception
     */
    public function index(?string $page = null): mixed
    {
        $data           = $this->pageBuilderService->getPageData($page);
        $data['plugin'] = plugin('PageBuilder');

        return view('PageBuilder::design.index', $data);
    }

    /**
     * پیش‌نمایش HTML ماژول
     *
     * @param  Request  $request
     * @param  string|null  $page  شناسه صفحه، null به معنای صفحه اصلی
     * @return string
     * @throws Exception
     */
    public function previewModule(Request $request, ?string $page = null): string
    {
        $module = json_decode($request->getContent(), true);
        $design = (bool) $request->get('design');

        $moduleId   = $module['module_id'] ?? '';
        $moduleCode = $module['code'] ?? '';
        $content    = $module['content'] ?? '';
        $viewPath   = $module['view_path'] ?? '';

        if (empty($viewPath)) {
            $viewPath = "PageBuilder::front.modules.{$moduleCode}";
        }

        // استفاده از DesignService برای پردازش یکپارچه داده‌های ماژول، اطمینان از سازگاری با صفحات جلویی
        $processedContent = DesignService::getInstance()->handleModuleContent($moduleCode, $content);

        $viewData = [
            'code'      => $moduleCode,
            'module_id' => $moduleId,
            'view_path' => $viewPath,
            'content'   => $processedContent,
            'design'    => $design,
        ];

        // بازگرداندن HTML کامل بخش، شامل دکمه ویرایش
        return view('PageBuilder::front.partials.module-section', [
            'module'    => $module,
            'content'   => $viewData['content'],
            'module_id' => $viewData['module_id'],
            'code'      => $viewData['code'],
        ])->render();
    }

    /**
     * ذخیره داده‌های ماژول صفحه
     *
     * @param  Request  $request
     * @param  string|null  $page  شناسه صفحه، null به معنای صفحه اصلی
     * @return JsonResponse
     */
    public function update(Request $request, ?string $page = null): JsonResponse
    {
        try {
            $modules = $request->input('modules', []);
            $this->pageBuilderService->savePageModules($modules, $page);

            return json_success('ذخیره با موفقیت انجام شد');
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * وارد کردن داده‌های نمونه
     *
     * @param  string|null  $page  شناسه صفحه، null به معنای صفحه اصلی
     * @return JsonResponse
     */
    public function importDemo(?string $page = null): JsonResponse
    {
        try {
            $moduleData = $this->pageBuilderService->importDemoData($page);

            return json_success('داده‌های نمونه با موفقیت وارد شد', $moduleData);
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }
}
