@push('header')
  <script src="{{ asset('vendor/vue/3.5/vue.global.prod.js') }}"></script>
@endpush

<div class="tab-pane fade mt-4" id="options-tab-pane" role="tabpanel"
     aria-labelledby="options-tab" tabindex="3">
  <div class="row">
    <div class="col-12">
      <div class="card" id="product-options-app">
        <div class="card-header">
          <h5 class="card-title mb-0">{{ __('panel/product.product_options') }}</h5>
          <small class="text-muted">{{ __('panel/product.product_options_description') }}</small>
        </div>
        <div class="card-body">
          <!-- فیلدهای پنهان برای ارسال فرم -->
          <input type="hidden" name="product_options" :value="JSON.stringify(getFormData())">
          
          <div class="row">
            <!-- ستون سمت چپ: گزینه‌های در دسترس -->
            <div class="col-md-6">
              <div class="border rounded p-3 h-100">
                <h6 class="mb-3">
                  <i class="bi bi-list-ul me-2"></i>گزینه‌های در دسترس
                  <span class="badge bg-secondary ms-2">@{{ availableOptionsFiltered.length }}</span>
                </h6>
                
                <!-- جعبه جستجو -->
                <div class="mb-3">
                  <div class="input-group">
                    <span class="input-group-text">
                      <i class="bi bi-search"></i>
                    </span>
          <input type="text" class="form-control" v-model="searchTerm" 
            placeholder="جستجوی گزینه...">
                  </div>
                </div>

                <!-- فهرست گزینه‌های در دسترس -->
                <div style="max-height: 500px; overflow-y: auto;">
                  <div v-if="loading" class="text-center py-4">
                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                    <span>در حال بارگذاری...</span>
                  </div>
                  
                  <div v-else-if="availableOptionsFiltered.length === 0" class="text-center py-4 text-muted">
                    <i class="bi bi-inbox display-6 d-block mb-2"></i>
                    <p class="mb-0">هیچ گزینه‌ای در دسترس نیست</p>
                  </div>
                  
                  <div v-else>
                    <div v-for="option in availableOptionsFiltered" :key="option.id" class="option-card mb-2">
                      <div class="card">
                        <div class="card-body p-3">
                          <div class="d-flex align-items-center">
                            <input type="checkbox" class="form-check-input me-3" 
                                   :id="`available-${option.id}`" 
                                   @change="selectOption(option)">
                            <div class="flex-grow-1">
                              <label class="form-check-label fw-medium" :for="`available-${option.id}`">
                                @{{ option.name }}
                              </label>
                              <div class="text-muted small">
                                @{{ option.type }} • @{{ option.option_values_count || 0 }} مقدار
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- ستون سمت راست: گزینه‌های انتخاب‌شده -->
            <div class="col-md-6">
              <div class="border rounded p-3 h-100">
                <h6 class="mb-3">
                  <i class="bi bi-check-square me-2"></i>گزینه‌های انتخاب‌شده
                  <span class="badge bg-primary ms-2">@{{ selectedOptions.length }}</span>
                </h6>

                <!-- فهرست گزینه‌های انتخاب‌شده -->
                <div style="max-height: 500px; overflow-y: auto;">
                  <div v-if="selectedOptions.length === 0" class="text-center py-4 text-muted">
                    <i class="bi bi-inbox display-6 d-block mb-2"></i>
                    <p class="mb-0">هیچ گزینه‌ای وجود ندارد</p>
                    <small>از ستون سمت چپ گزینه‌ها را انتخاب کنید</small>
                  </div>
                  
                  <div v-else>
                    <div v-for="option in selectedOptions" :key="option.id" class="selected-option-card mb-3">
                      <div class="card border-primary">
                        <div class="card-header bg-light py-2">
                          <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">@{{ option.name }}</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    @click="removeOption(option.id)">
                              <i class="bi bi-trash"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body p-3">
                          <div class="option-values-config">
                            <div class="table-responsive">
                              <table class="table table-sm mb-0">
                                <thead>
                                  <tr>
                                    <th width="40">
                                      <input type="checkbox" class="form-check-input" 
                                             :checked="isAllValuesSelected(option)"
                                             :indeterminate="isSomeValuesSelected(option)"
                                             @change="toggleAllValues(option)">
                                    </th>
                                    <th>مقادیر گزینه</th>
                                    <th width="120">افزایش قیمت</th>
                                    <th width="100">موجودی</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="value in option.values" :key="value.id">
                                    <td>
                                      <input type="checkbox" class="form-check-input" 
                                             v-model="value.selected"
                                             @change="toggleValueInputs(value)">
                                    </td>
                                    <td>
                                      <div class="d-flex align-items-center">
                                        <img v-if="value.image_url" :src="value.image_url" :alt="value.name" 
                                             class="me-2" style="width: 24px; height: 24px; object-fit: cover; border-radius: 3px;">
                                        <span>@{{ value.name }}</span>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="input-group input-group-sm">
                                        <input type="number" step="0.01" 
                                               class="form-control" 
                                               v-model="value.price_adjustment"
                                               placeholder="0.00"
                                               :disabled="!value.selected">
                                        <span class="input-group-text">{{ system_setting('base.currency', 'USD') }}</span>
                                      </div>
                                    </td>
                                    <td>
                                      <input type="number" 
                                             class="form-control form-control-sm" 
                                             v-model="value.stock_quantity"
                                             placeholder="0"
                                             :disabled="!value.selected">
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('footer')
<script>
// برنامه Vue برای صفحه گزینه‌های محصول - از نام اپلیکیشن یکتا برای جلوگیری از تداخل استفاده می‌شود
const { 
  createApp: createOptionsApp, 
  ref: optionsRef, 
  computed: optionsComputed, 
  onMounted: optionsOnMounted 
} = Vue;

createOptionsApp({
  setup() {
  // داده‌های پاسخگو
    const availableOptions = optionsRef([]);
    const selectedOptions = optionsRef([]);
    const searchTerm = optionsRef('');
    const loading = optionsRef(false);

  // خصوصیات محاسباتی
    const availableOptionsFiltered = optionsComputed(() => {
      const selectedIds = selectedOptions.value.map(opt => opt.id);
      // فیلتر کردن گزینه‌های انتخاب‌شده و گزینه‌هایی که مقدار ندارند
      const filtered = availableOptions.value.filter(opt => 
        !selectedIds.includes(opt.id) && 
        opt.option_values_count > 0  // فقط گزینه‌هایی که مقدار دارند نمایش داده می‌شوند
      );
      
      if (!searchTerm.value) {
        return filtered;
      }
      
      return filtered.filter(opt => 
        opt.name.toLowerCase().includes(searchTerm.value.toLowerCase())
      );
    });

  // مقداردهی اولیه داده‌ها
    optionsOnMounted(() => {
      loadAvailableOptions();
      loadSelectedOptions();
    });

  // بارگذاری گزینه‌های در دسترس
  const loadAvailableOptions = async () => {
      loading.value = true;
      try {
        const response = await fetch(urls.base_url + '/options/available', {
          method: 'GET',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        });
        
        const data = await response.json();
        if (data.success) {
          availableOptions.value = data.data.options || [];
        } else {
          showError('بارگذاری گزینه‌ها ناموفق بود');
        }
      } catch (error) {
        console.error('Error loading options:', error);
        showError('بارگذاری گزینه‌ها ناموفق بود');
      } finally {
        loading.value = false;
      }
    };

  // آماده‌سازی اولیه گزینه‌های محصول موجود (داده‌شده از کنترلر)
  const existingProductOptions = @json($existingProductOptions ?? []);

  // بارگذاری گزینه‌های انتخاب‌شده (از داده‌های محصول موجود)
    const loadSelectedOptions = async () => {
      for (const productOption of existingProductOptions) {
        const option = {
          id: productOption.option_id,
          name: productOption.name,
          type: productOption.type,
          option_values_count: productOption.option_values_count,
          values: []
        };
        
  // بارگذاری مقادیر گزینه
        await loadOptionValues(option);
        selectedOptions.value.push(option);
      }
    };

  // آماده‌سازی اولیه تنظیمات مقادیر گزینه‌ای موجود (از کنترلر)
  const existingOptionValues = @json($existingOptionValues ?? []);

  // بارگذاری مقادیر مربوط به یک گزینه
  const loadOptionValues = async (option) => {
      try {
        const response = await fetch(urls.base_url + '/options/' + option.id + '/values', {
          method: 'GET',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        });
        
        const data = await response.json();
        if (data.success) {
          option.values = data.data.option_values.map(value => {
            // بررسی وجود پیکربندی مقدار گزینه در محصول
            const existingValue = existingOptionValues.find(pov => 
              pov.option_value_id === value.id && pov.option_id === option.id
            );
            
            if (existingValue) {
              return {
                ...value,
                selected: true,
                price_adjustment: parseFloat(existingValue.price_adjustment),
                stock_quantity: parseInt(existingValue.stock_quantity)
              };
            }
            
            return {
              ...value,
              selected: false,
              price_adjustment: 0,
              stock_quantity: 0
            };
          });
        }
      } catch (error) {
        console.error('Error loading option values:', error);
      }
    };

  // انتخاب یک گزینه
    const selectOption = async (option) => {
      const newOption = { ...option, values: [] };
      await loadOptionValues(newOption);
      selectedOptions.value.push(newOption);
    };

  // حذف یک گزینه
    const removeOption = (optionId) => {
      selectedOptions.value = selectedOptions.value.filter(opt => opt.id !== optionId);
    };

  // تغییر حالت فیلدهای ورودی مقادیر گزینه
    const toggleValueInputs = (value) => {
      if (!value.selected) {
        value.price_adjustment = 0;
        value.stock_quantity = 0;
      }
    };

  // بررسی اینکه آیا همه مقادیر گزینه انتخاب شده‌اند
    const isAllValuesSelected = (option) => {
      return option.values.length > 0 && option.values.every(value => value.selected);
    };

  // بررسی اینکه آیا بخشی از مقادیر گزینه انتخاب شده‌اند
    const isSomeValuesSelected = (option) => {
      const selectedCount = option.values.filter(value => value.selected).length;
      return selectedCount > 0 && selectedCount < option.values.length;
    };

  // انتخاب همه/لغو انتخاب همه مقادیر گزینه
    const toggleAllValues = (option) => {
      const allSelected = isAllValuesSelected(option);
      option.values.forEach(value => {
        value.selected = !allSelected;
        if (!value.selected) {
          value.price_adjustment = 0;
          value.stock_quantity = 0;
        }
      });
    };

  // گرفتن داده‌های فرم
    const getFormData = () => {
      return selectedOptions.value.map(option => ({
        option_id: option.id,
        values: option.values.filter(value => value.selected).map(value => ({
          option_value_id: value.id,
          price_adjustment: value.price_adjustment || 0,
          stock_quantity: value.stock_quantity || 0
        }))
      }));
    };

  // نمایش پیام خطا
    const showError = (message) => {
      if (typeof inno !== 'undefined' && inno.msg) {
        inno.msg(message, 'error');
      } else {
        alert(message);
      }
    };

    return {
      availableOptions,
      selectedOptions,
      searchTerm,
      loading,
      availableOptionsFiltered,
      selectOption,
      removeOption,
      toggleValueInputs,
      isAllValuesSelected,
      isSomeValuesSelected,
      toggleAllValues,
      getFormData
    };
  }
}).mount('#product-options-app');
</script>
@endpush