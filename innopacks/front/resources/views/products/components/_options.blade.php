@if($productOptions && $productOptions->count() > 0)
  <div class="product-options">
    <h6 class="options-title">{{ __('front/product.custom_options') }}</h6>
    
    @foreach($productOptions as $productOption)
      @php
        $option = $productOption->option;
        $productOptionValues = $product->productOptionValues
          ->where('option_id', $option->id);
        $optionType = $option->type ?? 'select';
        $isRequired = $option->required ?? false;
      @endphp
      
      @if($option && $productOptionValues->count() > 0)
        <div class="option-group mb-3" data-option-id="{{ $option->id }}" data-option-type="{{ $optionType }}" data-required="{{ $isRequired ? 'true' : 'false' }}">
          <label class="option-label">
            {{ $option->currentName }}
            @if($isRequired)
              <span class="text-danger">*</span>
            @endif
          </label>
          
          @if($optionType === 'select')
            {{-- کادر انتخاب کشویی --}}
            <select class="form-select option-select mt-2" 
                    name="option_{{ $option->id }}" 
                    data-option-id="{{ $option->id }}">
              <option value="">{{ __('front/common.please_choose') }}</option>
              @foreach($productOptionValues as $productOptionValue)
                @php
                  $optionValue = $productOptionValue->optionValue;
                  $priceAdjustment = $productOptionValue->price_adjustment ?? 0;
                  $quantity = $productOptionValue->quantity ?? 0;
                  $isOutOfStock = $quantity <= 0;
                @endphp
                <option value="{{ $optionValue->id }}" 
                        data-price-adjustment="{{ $priceAdjustment }}"
                        data-quantity="{{ $quantity }}"
                        {{ $isOutOfStock ? 'disabled' : '' }}>
                  {{ $optionValue->currentName }}
                  @if($priceAdjustment != 0)
                    ({{ $priceAdjustment > 0 ? '+' : '' }}{{ currency_format($priceAdjustment) }})
                  @endif
                  @if($isOutOfStock)
                    - {{ __('front/product.out_stock') }}
                  @endif
                </option>
              @endforeach
            </select>
            
          @elseif($optionType === 'radio')
            {{-- دکمه‌های رادیویی --}}
            <div class="option-values radio-group mt-2 d-flex flex-wrap gap-2">
              @foreach($productOptionValues as $productOptionValue)
                @php
                  $optionValue = $productOptionValue->optionValue;
                  $priceAdjustment = $productOptionValue->price_adjustment ?? 0;
                  $quantity = $productOptionValue->quantity ?? 0;
                  $isOutOfStock = $quantity <= 0;
                @endphp
                <div class="form-check option-radio-item mobile-option-item {{ $isOutOfStock ? 'out-of-stock' : '' }}">
                  @if($optionValue->image)
                    <div class="option-image mb-1">
                      <img src="{{ image_resize($optionValue->image) }}" alt="{{ $optionValue->currentName }}" class="img-thumbnail">
                    </div>
                  @endif
                  
                  <input class="form-check-input" 
                         type="radio" 
                         name="option_{{ $option->id }}" 
                         id="option_{{ $option->id }}_{{ $optionValue->id }}"
                         value="{{ $optionValue->id }}"
                         data-option-id="{{ $option->id }}"
                         data-price-adjustment="{{ $priceAdjustment }}"
                         data-quantity="{{ $quantity }}"
                         {{ $isOutOfStock ? 'disabled' : '' }}>
                  <label class="form-check-label mobile-option-label" for="option_{{ $option->id }}_{{ $optionValue->id }}">
                    <span class="option-name">{{ $optionValue->currentName }}</span>
                    @if($priceAdjustment != 0)
                      <span class="price-adjustment d-block">
                        ({{ $priceAdjustment > 0 ? '+' : '' }}{{ currency_format($priceAdjustment) }})
                      </span>
                    @endif
                    @if($isOutOfStock)
                      <span class="out-of-stock-text d-block">{{ __('front/product.out_stock') }}</span>
                    @endif
                  </label>
                </div>
              @endforeach
            </div>
            
          @elseif($optionType === 'checkbox')
            {{-- چک‌باکس‌های چندگانه --}}
            <div class="option-values checkbox-group mt-2 d-flex flex-wrap gap-2">
              @foreach($productOptionValues as $productOptionValue)
                @php
                  $optionValue = $productOptionValue->optionValue;
                  $priceAdjustment = $productOptionValue->price_adjustment ?? 0;
                  $quantity = $productOptionValue->quantity ?? 0;
                  $isOutOfStock = $quantity <= 0;
                @endphp
                <div class="form-check option-checkbox-item mobile-option-item {{ $isOutOfStock ? 'out-of-stock' : '' }}">
                  @if($optionValue->image)
                    <div class="option-image mb-1">
                      <img src="{{ image_resize($optionValue->image) }}" alt="{{ $optionValue->currentName }}" class="img-thumbnail">
                    </div>
                  @endif
                  
                  <input class="form-check-input" 
                         type="checkbox" 
                         name="option_{{ $option->id }}[]" 
                         id="option_{{ $option->id }}_{{ $optionValue->id }}"
                         value="{{ $optionValue->id }}"
                         data-option-id="{{ $option->id }}"
                         data-price-adjustment="{{ $priceAdjustment }}"
                         data-quantity="{{ $quantity }}"
                         {{ $isOutOfStock ? 'disabled' : '' }}>
                  <label class="form-check-label mobile-option-label" for="option_{{ $option->id }}_{{ $optionValue->id }}">
                    <span class="option-name">{{ $optionValue->currentName }}</span>
                    @if($priceAdjustment != 0)
                      <span class="price-adjustment d-block">
                        ({{ $priceAdjustment > 0 ? '+' : '' }}{{ currency_format($priceAdjustment) }})
                      </span>
                    @endif
                    @if($isOutOfStock)
                      <span class="out-of-stock-text d-block">{{ __('front/product.out_stock') }}</span>
                    @endif
                  </label>
                </div>
              @endforeach
            </div>
          @endif
          
          {{-- توضیحات گزینه در زیر لیست مقادیر گزینه قرار می‌گیرد --}}
          @if($option->description && is_array($option->description))
            <div class="option-description mt-3">
              <small class="text-muted">
                {{ $option->description[app()->getLocale()] ?? $option->description['en'] ?? '' }}
              </small>
            </div>
          @endif
        </div>
      @endif
    @endforeach
    
    <!-- منطقه نمایش انتخاب فعلی و قیمت کل -->
    <div class="current-selection-summary mb-4" style="display: none;">
      <div class="card">
        <div class="card-body p-3">
          <h6 class="card-title mb-2">
            <i class="fas fa-check-circle text-success me-2"></i>{{ __('front/product.current_selection') }}
          </h6>
          <div class="selected-options-list mb-3">
            <!-- نمایش پویای گزینه‌های انتخاب شده -->
          </div>
          <div class="total-price-display">
            <div class="row align-items-center">
              <div class="col">
                <strong class="text-primary">{{ __('front/product.total_price') }}：</strong>
              </div>
              <div class="col-auto">
                <span class="badge bg-primary fs-6 current-total-price">
                  {{ currency_format($product->price) }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  @push('footer')
  <script>
    $(document).ready(function() {
      // دریافت قیمت پایه - اولویت با دریافت از SKU فعلی، در غیر این صورت از قیمت پیش‌فرض محصول استفاده می‌شود
      let basePrice = {{ $sku['price'] ?? 0 }};
      
      // تابع سراسری برای به‌روزرسانی قیمت پایه (هنگام تغییر مشخصات فراخوانی می‌شود)
      window.updateBasePrice = function(newPrice) {
        basePrice = parseFloat(newPrice);
        updateProductPrice(); // محاسبه مجدد قیمت کل
      };
      
      // ذخیره گزینه‌های انتخاب شده
      let selectedOptions = {};
      
      // تابع اعتبارسنجی سراسری برای فراخوانی خارجی
      window.validateRequiredOptions = function() {
        return validateRequiredOptions();
      };
      
      // رویداد کادر انتخاب کشویی
      $('.option-select').change(function() {
        const $this = $(this);
        const optionId = $this.data('option-id');
        const selectedValue = $this.val();
        const priceAdjustment = parseFloat($this.find('option:selected').data('price-adjustment')) || 0;
        
        if (selectedValue) {
          selectedOptions[optionId] = [selectedValue];
        } else {
          delete selectedOptions[optionId];
        }
        
        updateProductPrice();
        validateRequiredOptions();
      });
      
      // رویداد دکمه رادیویی - پشتیبانی از کلیک روی کل منطقه گزینه و متن برچسب
      $('.option-radio-item, .option-radio-item label').on('click', function(e) {
        e.preventDefault(); // جلوگیری از رفتار پیش‌فرض کلیک برچسب
        e.stopPropagation(); // جلوگیری از انتشار رویداد
        
        const $item = $(this).hasClass('option-radio-item') ? $(this) : $(this).closest('.option-radio-item');
        const $input = $item.find('input[type="radio"]');
        
        // بررسی غیرفعال بودن (ناموجود)
        if ($input.prop('disabled') || $item.hasClass('out-of-stock')) {
          return false; // اگر غیرفعال باشد هیچ عملیاتی انجام نمی‌دهد
        }
        
        const optionId = $input.data('option-id');
        const optionValue = $input.val();
        const priceAdjustment = parseFloat($input.data('price-adjustment')) || 0;
        
        // لغو حالت انتخاب سایر گزینه‌های همان گروه
        $item.siblings('.option-radio-item').removeClass('selected');
        $item.addClass('selected');
        
        // تنظیم انتخاب دکمه رادیویی
        $input.prop('checked', true);
        
        selectedOptions[optionId] = [optionValue];
        
        updateProductPrice();
        validateRequiredOptions();
      });
      
      // رویداد چک‌باکس چندگانه - پشتیبانی از کلیک روی کل منطقه گزینه و متن برچسب
      $('.option-checkbox-item, .option-checkbox-item label').on('click', function(e) {
        e.preventDefault(); // جلوگیری از رفتار پیش‌فرض کلیک برچسب
        e.stopPropagation(); // جلوگیری از انتشار رویداد
        
        const $item = $(this).hasClass('option-checkbox-item') ? $(this) : $(this).closest('.option-checkbox-item');
        const $input = $item.find('input[type="checkbox"]');
        
        // بررسی غیرفعال بودن (ناموجود)
        if ($input.prop('disabled') || $item.hasClass('out-of-stock')) {
          return false; // اگر غیرفعال باشد هیچ عملیاتی انجام نمی‌دهد
        }
        
        const optionId = $input.data('option-id');
        const optionValue = $input.val();
        const priceAdjustment = parseFloat($input.data('price-adjustment')) || 0;
        
        // تغییر حالت انتخاب
        if ($item.hasClass('selected')) {
          $item.removeClass('selected');
          $input.prop('checked', false);
          
          // حذف از گزینه‌های انتخاب شده
          if (selectedOptions[optionId]) {
            selectedOptions[optionId] = selectedOptions[optionId].filter(id => id !== optionValue);
            if (selectedOptions[optionId].length === 0) {
              delete selectedOptions[optionId];
            }
          }
        } else {
          $item.addClass('selected');
          $input.prop('checked', true);
          
          // اضافه کردن به گزینه‌های انتخاب شده
          if (!selectedOptions[optionId]) {
            selectedOptions[optionId] = [];
          }
          selectedOptions[optionId].push(optionValue);
        }
        
        updateProductPrice();
        validateRequiredOptions();
      });
      
      // به‌روزرسانی قیمت محصول و نمایش انتخاب
      function updateProductPrice() {
        let totalAdjustment = 0;
        
        // محاسبه تعدیل قیمت کادر انتخاب کشویی
        $('.option-select').each(function() {
          const selectedOption = $(this).find('option:selected');
          if (selectedOption.val()) {
            totalAdjustment += parseFloat(selectedOption.data('price-adjustment')) || 0;
          }
        });
        
        // محاسبه تعدیل قیمت دکمه رادیویی
        $('.option-radio-item input[type="radio"]:checked').each(function() {
          totalAdjustment += parseFloat($(this).data('price-adjustment')) || 0;
        });
        
        // محاسبه تعدیل قیمت چک‌باکس چندگانه
        $('.option-checkbox-item input[type="checkbox"]:checked').each(function() {
          totalAdjustment += parseFloat($(this).data('price-adjustment')) || 0;
        });
        
        const finalPrice = basePrice + totalAdjustment;
        
        // استفاده از تابع قالب‌بندی ارز سراسری
        const formattedPrice = window.inno.formatCurrency(finalPrice);
        $('.product-price .price').text(formattedPrice);
        $('.current-total-price').text(formattedPrice);
        
        // به‌روزرسانی نمایش انتخاب فعلی
        updateCurrentSelectionDisplay();
      }
      
      // به‌روزرسانی نمایش انتخاب فعلی
      function updateCurrentSelectionDisplay() {
        const $selectionList = $('.selected-options-list');
        const $summaryCard = $('.current-selection-summary');
        
        $selectionList.empty();
        let hasSelections = false;
        
        // نمایش انتخاب کادر انتخاب کشویی
        $('.option-select').each(function() {
          const $select = $(this);
          const selectedOption = $select.find('option:selected');
          const optionName = $select.closest('.option-group').find('.option-label').text().trim().replace('*', '');
          
          if (selectedOption.val()) {
            hasSelections = true;
            const priceAdjustment = parseFloat(selectedOption.data('price-adjustment')) || 0;
            const priceText = priceAdjustment !== 0 ? 
              ` (${priceAdjustment > 0 ? '+' : ''}${window.inno.formatCurrency(priceAdjustment)})` : '';
            
            $selectionList.append(`
              <div class="selected-option-item mb-2">
                <span class="badge bg-light text-dark me-2">${optionName}</span>
                <span class="option-value">${selectedOption.text().split('(')[0].trim()}${priceText}</span>
              </div>
            `);
          }
        });
        
        // نمایش انتخاب دکمه رادیویی
        $('.option-radio-item input[type="radio"]:checked').each(function() {
          const $input = $(this);
          const optionName = $input.closest('.option-group').find('.option-label').text().trim().replace('*', '');
          const optionValueName = $input.closest('.option-radio-item').find('.option-name').text() || 
                                  $input.closest('.option-radio-item').find('label').text();
          const priceAdjustment = parseFloat($input.data('price-adjustment')) || 0;
          const priceText = priceAdjustment !== 0 ? 
            ` (${priceAdjustment > 0 ? '+' : ''}${window.inno.formatCurrency(priceAdjustment)})` : '';

          hasSelections = true;
          $selectionList.append(`
            <div class="selected-option-item mb-2">
              <span class="badge bg-light text-dark me-2">${optionName}</span>
              <span class="option-value">${optionValueName}${priceText}</span>
            </div>
          `);
        });
        
        // نمایش انتخاب چک‌باکس چندگانه
        $('.option-checkbox-item input[type="checkbox"]:checked').each(function() {
          const $input = $(this);
          const optionName = $input.closest('.option-group').find('.option-label').text().trim().replace('*', '');
          const optionValueName = $input.closest('.option-checkbox-item').find('.option-name').text() || 
                                  $input.closest('.option-checkbox-item').find('label').text();
          const priceAdjustment = parseFloat($input.data('price-adjustment')) || 0;
          const priceText = priceAdjustment !== 0 ? 
            ` (${priceAdjustment > 0 ? '+' : ''}${window.inno.formatCurrency(priceAdjustment)})` : '';
          
          hasSelections = true;
          $selectionList.append(`
            <div class="selected-option-item mb-2">
              <span class="badge bg-light text-dark me-2">${optionName}</span>
              <span class="option-value">${optionValueName}${priceText}</span>
            </div>
          `);
        });
        
        // نمایش یا مخفی کردن کارت خلاصه انتخاب
        if (hasSelections) {
          $summaryCard.show();
        } else {
          $summaryCard.hide();
        }
      }
      
      // اعتبارسنجی گزینه‌های اجباری
      function validateRequiredOptions() {
        let allValid = true;
        let hasRequiredOptions = false;
        let missingOptions = [];
        
        $('.option-group').each(function() {
          const $group = $(this);
          const optionId = $group.data('option-id');
          const optionType = $group.data('option-type');
          const isRequired = $group.data('required');
          const optionName = $group.find('.option-label').text().trim().replace('*', '');
          
          // حذف پیام‌های خطای قبلی
          $group.find('.option-error-message').remove();
          
          if (isRequired) {
            hasRequiredOptions = true;
            let hasSelection = false;
            
            if (optionType === 'select') {
              const selectValue = $group.find('.option-select').val();
              hasSelection = selectValue !== '';
            } else if (optionType === 'radio') {
              const checkedRadios = $group.find('input[type="radio"]:checked');
              hasSelection = checkedRadios.length > 0;
            } else if (optionType === 'checkbox') {
              const checkedBoxes = $group.find('input[type="checkbox"]:checked');
              hasSelection = checkedBoxes.length > 0;
            }
            
            if (!hasSelection) {
              allValid = false;
              $group.addClass('has-error');
              missingOptions.push(optionName);
              
              // اضافه کردن پیام خطای راهنما
              const errorMessage = `<div class="option-error-message">
                <i class="bi bi-exclamation-circle"></i>
                لطفاً ${optionName} را انتخاب کنید
              </div>`;
              $group.append(errorMessage);
            } else {
              $group.removeClass('has-error');
            }
          } else {
            // حذف حالت خطا از گزینه‌های غیراجباری
            $group.removeClass('has-error');
          }
        });
        
        // اگر گزینه اجباری وجود نداشته باشد، همیشه true برمی‌گرداند
        if (!hasRequiredOptions) {
          allValid = true;
        }
        
        // به‌روزرسانی وضعیت دکمه خرید و راهنما
        if (allValid) {
          $('.add-cart, .buy-now').removeClass('disabled').attr('title', '');
        } else {
          $('.add-cart, .buy-now').addClass('disabled').attr('title', `لطفاً ابتدا انتخاب کنید: ${missingOptions.join('، ')}`);
        }
        
        return allValid;
      }
      
      // توجه: مدیریت رویداد افزودن به سبد خرید در show.blade.php تعریف شده است، اینجا دوباره تعریف نمی‌شود
    });
  </script>
  
  <style>
    /* استایل‌های بهینه‌سازی گزینه موبایل */
    .mobile-option-item {
      width: 120px;
      min-height: 60px;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 8px;
      margin: 0;
      position: relative;
      cursor: pointer;
      transition: all 0.2s ease;
      background: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      flex: 0 0 auto; /* جلوگیری از کوچک شدن آیتم‌های flex */
    }
    
    .mobile-option-item:hover {
      border-color: #007bff;
      box-shadow: 0 2px 4px rgba(0,123,255,0.1);
    }
    
    .mobile-option-item.selected {
      border-color: #007bff;
      background-color: #f8f9ff;
      box-shadow: 0 2px 8px rgba(0,123,255,0.2);
    }
    
    .mobile-option-item.out-of-stock {
      opacity: 0.5;
      cursor: not-allowed;
      background-color: #f8f9fa;
    }
    
    .mobile-option-item .form-check-input {
      position: absolute;
      top: 6px;
      right: 6px;
      margin: 0;
    }
    
    .mobile-option-label {
      width: 100%;
      margin: 0;
      padding: 0;
      cursor: pointer;
      font-size: 12px;
      line-height: 1.2;
    }
    
    .mobile-option-label .option-name {
      font-weight: 500;
      color: #333;
      display: block;
      margin-bottom: 2px;
      word-break: break-word;
    }
    
    .mobile-option-label .price-adjustment {
      font-size: 10px;
      color: #007bff;
      font-weight: 600;
    }
    
    .mobile-option-label .out-of-stock-text {
      font-size: 10px;
      color: #dc3545;
      font-weight: 500;
    }
    
    .mobile-option-item .option-image {
      width: 100%;
      margin-bottom: 4px;
    }
    
    .mobile-option-item .option-image img {
      width: 100%;
      height: 40px;
      object-fit: cover;
      border-radius: 4px;
    }
    
    /* تنظیمات واکنش‌گرا */
     @media (max-width: 576px) {
       .radio-group, .checkbox-group {
         gap: 6px !important;
         display: flex !important;
         flex-wrap: wrap !important;
       }
       
       .mobile-option-item {
         width: calc(33.333% - 4px) !important;
         min-width: 100px !important;
         font-size: 11px;
         padding: 6px;
         min-height: 50px;
         flex: 0 0 auto !important;
       }
       
       .mobile-option-label {
         font-size: 11px;
       }
       
       .mobile-option-label .price-adjustment {
         font-size: 9px;
       }
       
       .mobile-option-label .out-of-stock-text {
         font-size: 9px;
       }
       
       .mobile-option-item .option-image img {
         height: 30px;
       }
     }
    
    @media (min-width: 577px) and (max-width: 768px) {
      .mobile-option-item {
        width: calc(33.333% - 6px);
        min-width: 120px;
      }
    }
    
    @media (min-width: 769px) {
      .mobile-option-item {
        width: auto;
        min-width: 120px;
        max-width: 140px;
      }
    }
    
    /* استایل‌های حالت خطا */
    .option-group.has-error .mobile-option-item {
      border-color: #dc3545;
    }
    
    .option-error-message {
      color: #dc3545;
      font-size: 12px;
      margin-top: 8px;
      padding: 4px 8px;
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
      border-radius: 4px;
    }
    
    .option-error-message i {
      margin-right: 4px;
    }
  </style>
  @endpush
@endif