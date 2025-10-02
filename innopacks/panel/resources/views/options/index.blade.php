@extends('panel::layouts.app')
@section('body-class', 'page-product-option-group')
@section('title', 'مدیریت گزینه‌ها')

@section('content')
  <div class="card h-min-600" id="app">
    <div class="card-body">
      <!-- لینک‌های ناوبری -->
      <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
          <a class="nav-link active" href="{{ panel_route('options.index') }}">
            <i class="bi bi-collection"></i> مدیریت گروه گزینه‌ها
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ panel_route('option_values.index') }}">
            <i class="bi bi-list-ul"></i> مدیریت مقادیر گزینه‌ها
          </a>
        </li>
      </ul>

      <!-- محتوای مدیریت گروه گزینه‌ها -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">مدیریت گروه گزینه‌ها</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#optionGroupModal" onclick="openCreateModal()">
          <i class="bi bi-plus-square"></i> {{ __('panel/common.create') }}
        </button>
      </div>

      <x-panel-data-criteria :criteria="$criteria ?? []" :action="panel_route('options.index')" />

      <!-- لیست گروه گزینه‌ها -->
      @if ($option_groups->count())
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
            <tr>
              <th>{{ __('panel/common.id') }}</th>
              <th>{{ __('panel/common.name') }}</th>
              <th>توضیحات</th>
              <th>نوع</th>
              <th>اجباری بودن</th>
              <th>ترتیب</th>
              <th>{{ __('panel/common.active') }}</th>
              <th>{{ __('panel/common.created_at') }}</th>
              <th>{{ __('panel/common.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($option_groups as $optionGroup)
              <tr>
                <td>{{ $optionGroup->id }}</td>
                <td>{{ $optionGroup->currentName }}</td>
                <td>
                  <div class="text-muted small" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" 
                       title="{{ $optionGroup->getLocalizedDescription() }}">
                    {{ $optionGroup->getLocalizedDescription() ?: 'بدون توضیحات' }}
                  </div>
                </td>
                <td>
                  @switch($optionGroup->type)
                    @case('select')
                      <span class="badge bg-primary">انتخاب کشویی</span>
                      @break
                    @case('radio')
                      <span class="badge bg-info">دکمه رادیویی</span>
                      @break
                    @case('checkbox')
                      <span class="badge bg-success">چک باکس</span>
                      @break
                    @case('text')
                      <span class="badge bg-warning">ورودی متن</span>
                      @break
                    @case('textarea')
                      <span class="badge bg-secondary">ناحیه متن</span>
                      @break
                    @default
                      <span class="badge bg-light text-dark">{{ $optionGroup->type }}</span>
                  @endswitch
                </td>
                <td>
                  @if($optionGroup->required)
                    <span class="badge bg-danger">اجباری</span>
                  @else
                    <span class="badge bg-secondary">اختیاری</span>
                  @endif
                </td>
                <td>{{ $optionGroup->position }}</td>
                <td>
                  @include('panel::shared.list_switch', [
                    'value' => $optionGroup->active, 
                    'url' => panel_route('options.active', $optionGroup->id)
                  ])
                </td>
                <td>{{ $optionGroup->created_at }}</td>
                <td>
                  <div class="d-flex gap-2">
                    <div>
                      <button type="button" class="btn btn-sm btn-outline-primary" 
                              data-bs-toggle="modal" data-bs-target="#optionGroupModal" 
                              onclick="openEditModal({{ $optionGroup->id }})">
                        {{ __('panel/common.edit') }}
                      </button>
                    </div>
                    <div>
                      <form action="{{ panel_route('options.destroy', [$optionGroup->id]) }}"
                            method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                onclick="return confirm('آیا مطمئن هستید که می‌خواهید این گروه گزینه را حذف کنید؟')">
                          {{ __('panel/common.delete') }}
                        </button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

        {{ $option_groups->withQueryString()->links('panel::vendor/pagination/bootstrap-4') }}
      @else
        <x-common-no-data />
      @endif
    </div>
  </div>

  <!-- مودال ویرایش گروه گزینه -->
  <div class="modal fade" id="optionGroupModal" tabindex="-1" aria-labelledby="optionGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="optionGroupModalLabel">ایجاد گروه گزینه</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="optionGroupForm" method="POST">
          @csrf
          <input type="hidden" name="_method" value="POST" id="form-method">
          <div class="modal-body">
            <div class="row">
              <!-- اطلاعات پایه -->
              <div class="col-12">
                <h6 class="mb-3">اطلاعات پایه</h6>
              </div>
              
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label for="type" class="form-label">نوع گزینه <span class="text-danger">*</span></label>
                  <select class="form-select" id="type" name="type" required>
                    <option value="select" selected>انتخاب کشویی</option>
                    <option value="radio">دکمه رادیویی</option>
                    <option value="checkbox">چک باکس</option>
                  </select>
                </div>
              </div>

              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label for="position" class="form-label">ترتیب</label>
                  <input type="number" class="form-control" id="position" name="position" value="0">
                </div>
              </div>

              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label class="form-label">اجباری بودن</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="required" name="required" value="1">
                  </div>
                </div>
              </div>

              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label class="form-label">فعال بودن</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="active" name="active" value="1" checked>
                  </div>
                </div>
              </div>

              <!-- اطلاعات چندزبانه -->
              <div class="col-12">
                <h6 class="mb-3 mt-3">اطلاعات چندزبانه</h6>
                
                <!-- ناوبری تب‌های چندزبانه -->
                <ul class="nav nav-tabs mb-3" id="languageTab" role="tablist">
                  @foreach (locales() as $locale)
                    <li class="nav-item" role="presentation">
                      <button class="nav-link d-flex align-items-center {{ $loop->first ? 'active' : '' }}" 
                              id="lang-{{ $locale['code'] }}-tab" 
                              data-bs-toggle="tab" 
                              data-bs-target="#lang-{{ $locale['code'] }}-pane" 
                              type="button" role="tab" 
                              aria-controls="lang-{{ $locale['code'] }}-pane" 
                              aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        <div class="wh-20 me-2">
                          <img src="{{ asset('images/flag/'. $locale['code'].'.png') }}" 
                               class="img-fluid" 
                               alt="{{ $locale['name'] }}">
                        </div>
                        {{ $locale['name'] }}
                      </button>
                    </li>
                  @endforeach
                </ul>
                
                <!-- محتوای تب‌های چندزبانه -->
                <div class="tab-content" id="languageTabContent">
                  @foreach (locales() as $locale)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                         id="lang-{{ $locale['code'] }}-pane" 
                         role="tabpanel" 
                         aria-labelledby="lang-{{ $locale['code'] }}-tab">
                      <div class="row">
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="name_{{ $locale['code'] }}" class="form-label">
                              نام گروه گزینه 
                              <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" 
                                   id="name_{{ $locale['code'] }}" 
                                   name="translations[{{ $locale['code'] }}][name]"
                                   required>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="description_{{ $locale['code'] }}" class="form-label">توضیحات گروه گزینه</label>
                            <textarea class="form-control" 
                                      id="description_{{ $locale['code'] }}" 
                                      name="translations[{{ $locale['code'] }}][description]"
                                      rows="3" 
                                      placeholder="لطفاً توضیحات گروه گزینه را وارد کنید تا کاربرد این گزینه را توضیح دهد"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">لغو</button>
            <button type="submit" class="btn btn-primary">ذخیره</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('footer')
<script>
// خروجی داده‌های گروه گزینه به عنوان متغیر جاوااسکریپت
const optionGroupsData = @json($option_groups_data);
// استخراج آرایه داده‌های واقعی (مدیریت ساختار صفحه‌بندی)
const optionGroups = optionGroupsData.data || optionGroupsData;

$(document).ready(function() {
    let isEditMode = false;
    let currentOptionId = null;

    /**
     * باز کردن مودال ایجاد گروه گزینه
     */
    window.openCreateModal = function() {
        isEditMode = false;
        currentOptionId = null;
        
        // بازنشانی فرم
        $('#optionGroupForm')[0].reset();
        $('#optionGroupModalLabel').text('ایجاد گروه گزینه');
        $('#optionGroupForm').attr('action', '{{ panel_route("options.store") }}');
        $('#form-method').val('POST'); // تنظیم متد POST
        
        // پاک کردن تمام فیلدهای فرم
        $('#product_id').val('');
        $('#type').val('select');
        $('#position').val('0');
        $('#required').prop('checked', false);
        $('#active').prop('checked', true);
        
        // پاک کردن فیلدهای چندزبانه
        $('[id^="name_"]').val('');
        $('[id^="description_"]').val('');
        
        // نمایش مودال
        $('#optionGroupModal').modal('show');
    };

    /**
     * باز کردن مودال ویرایش گروه گزینه
     */
    window.openEditModal = function(optionId) {
        isEditMode = true;
        currentOptionId = optionId;
        
        // دریافت اطلاعات گروه گزینه از داده‌های محلی (استفاده از آرایه داده‌های تصحیح شده)
        const optionGroup = optionGroups.find(group => group.id == optionId);
        
        // تنظیم عمل فرم - استفاده از فرمت پارامتر مسیر صحیح
        $('#optionGroupForm').attr('action', `/panel/options/${optionId}`);
        $('#form-method').val('PUT'); // تنظیم متد PUT برای به‌روزرسانی
        
        // پر کردن اطلاعات پایه
        $('#product_id').val(optionGroup.product_id || '');
        $('#type').val(optionGroup.type || 'select');
        $('#position').val(optionGroup.position || 0);
        $('#required').prop('checked', optionGroup.required == 1);
        $('#active').prop('checked', optionGroup.active == 1);
        
        // پر کردن اطلاعات چندزبانه - نام و توضیحات فیلدهای JSON در پایگاه داده هستند
        if (optionGroup.name) {
            try {
                const names = typeof optionGroup.name === 'string' ? JSON.parse(optionGroup.name) : optionGroup.name;
                Object.keys(names).forEach(locale => {
                    $(`#name_${locale}`).val(names[locale] || '');
                });
            } catch (e) {
                console.error('خطا در تجزیه JSON نام:', e);
            }
        }
        
        if (optionGroup.description) {
            try {
                const descriptions = typeof optionGroup.description === 'string' ? JSON.parse(optionGroup.description) : optionGroup.description;
                Object.keys(descriptions).forEach(locale => {
                    $(`#description_${locale}`).val(descriptions[locale] || '');
                });
            } catch (e) {
                console.error('خطا در تجزیه JSON توضیحات:', e);
            }
        }
        
        $('#optionGroupModalLabel').text('ویرایش گروه گزینه');
        // نمایش مودال
        $('#optionGroupModal').modal('show');
    };

    // مدیریت ارسال فرم
    $('#optionGroupForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // اگر در حالت ویرایش است، متد PUT اضافه کنید
        if (isEditMode) {
            formData.append('_method', 'PUT');
        }
        
        // اضافه کردن شناسه AJAX
        formData.append('_ajax', '1');
        
        // نمایش حالت بارگذاری
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text('در حال پردازش...');
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // بستن حالت بارگذاری
                submitBtn.prop('disabled', false).text(originalText);
                
                // بستن مودال
                $('#optionGroupModal').modal('hide');
                
                // استفاده از layer برای نمایش پیام موفقیت
                layer.msg(response.message || 'عملیات موفقیت‌آمیز بود', {
                    icon: 1,
                    time: 2000
                }, function() {
                    // تازه‌سازی صفحه
                    window.location.reload();
                });
            },
            error: function(xhr) {
                // بستن حالت بارگذاری (اگر عملیات ناموفق باشد اما خطایی پرتاب نشود)
                submitBtn.prop('disabled', false).text(originalText);
                
                let errorMessage = 'عملیات ناموفق بود';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('<br>');
                }
                
                // بستن حالت بارگذاری
                layer.msg(errorMessage, {
                    icon: 2,
                    time: 3000
                });
            }
        });
    });
});
</script>
@endpush