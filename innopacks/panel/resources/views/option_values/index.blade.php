@extends('panel::layouts.app')
@section('body-class', 'page-product-option-value')
@section('title', 'مدیریت مقادیر گزینه')

@section('content')
  <div class="card h-min-600" id="app">
    <div class="card-body">
      <!-- پیوندهای ناوبری -->
      <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
          <a class="nav-link" href="{{ panel_route('options.index') }}">
            <i class="bi bi-collection"></i> مدیریت گروه گزینه‌ها
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ panel_route('option_values.index') }}">
            <i class="bi bi-list-ul"></i> مدیریت مقادیر گزینه
          </a>
        </li>
      </ul>

      <!-- محتوای مدیریت مقادیر گزینه -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">مدیریت مقادیر گزینه</h5>
        <button type="button" class="btn btn-primary" onclick="openCreateModal()">
          <i class="bi bi-plus-square"></i> {{ __('panel/common.create') }}
        </button>
      </div>

      <x-panel-data-criteria :criteria="$criteria ?? []" :action="panel_route('option_values.index')" />

      <!-- فهرست مقادیر گزینه -->
      @if ($optionValues->count())
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
            <tr>
              <th>{{ __('panel/common.id') }}</th>
              <th>{{ __('panel/common.name') }}</th>
              <th>گروه گزینه</th>
              <th>تصویر</th>
              <th>ترتیب</th>
              <th>{{ __('panel/common.active') }}</th>
              <th>{{ __('panel/common.created_at') }}</th>
              <th>{{ __('panel/common.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($optionValues as $optionValue)
              <tr>
                <td>{{ $optionValue->id }}</td>
                <td>{{ $optionValue->currentName }}</td>
                <td>
                  @if($optionValue->option)
                    <span class="badge bg-secondary">{{ $optionValue->option->currentName }}</span>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>
                  @if($optionValue->image)
                    <img src="{{ $optionValue->getImageUrl() }}" alt="تصویر مقدار گزینه" class="img-thumbnail" style="width: 40px; height: 40px;">
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>{{ $optionValue->position }}</td>
                <td>
                  @if ($optionValue->active)
                    <span class="badge bg-success">{{ __('panel/common.active') }}</span>
                  @else
                    <span class="badge bg-secondary">{{ __('panel/common.inactive') }}</span>
                  @endif
                </td>
                <td>{{ $optionValue->created_at }}</td>
                <td>
                  <button type="button" class="btn btn-outline-primary btn-sm" onclick="openEditModal({{ $optionValue->id }})">
                    <i class="bi bi-pencil-square"></i> {{ __('panel/common.edit') }}
                  </button>
                  <button type="button" class="btn btn-outline-danger btn-sm" onclick="if(confirm('آیا مطمئن هستید که می‌خواهید این مقدار گزینه را حذف کنید؟')) { document.getElementById('delete-form-{{ $optionValue->id }}').submit(); }">
                    <i class="bi bi-trash"></i> {{ __('panel/common.delete') }}
                  </button>
                  <form id="delete-form-{{ $optionValue->id }}" action="{{ panel_route('option_values.destroy', $optionValue) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                  </form>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-center">
          {{ $optionValues->withQueryString()->links('panel::vendor/pagination/bootstrap-4') }}
        </div>
      @else
        <x-common-no-data />
      @endif
    </div>
  </div>

  <!-- مودال ویرایش مقدار گزینه -->
  <div class="modal fade" id="optionValueModal" tabindex="-1" aria-labelledby="optionValueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="optionValueModalLabel">افزودن مقدار گزینه</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="optionValueForm" method="POST">
          @csrf
          <input type="hidden" name="_method" value="POST" id="form-method">
          
          <!-- ناحیه نمایش پیام‌های خطا -->
          <div id="form-errors" class="alert alert-danger d-none mx-3 mt-3" role="alert">
            <ul class="mb-0" id="error-list"></ul>
          </div>
          
          <div class="modal-body">
            <div class="row">
              <!-- اطلاعات پایه -->
              <div class="col-12">
                <h6 class="mb-3">اطلاعات پایه</h6>
              </div>
              
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label for="option_id" class="form-label">گروه گزینه <span class="text-danger">*</span></label>
                  <select name="option_id" id="option_id" class="form-select" required>
                    @foreach($allOptionGroups as $group)
                      <option value="{{ $group->id }}">{{ $group->currentName }} ({{ $group->type }})</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label for="image" class="form-label">تصویر</label>
                  <div class="is-up-file" data-type="image">
                    <div class="img-upload-item bg-light wh-80 rounded border d-flex justify-content-center align-items-center me-2 mb-2 position-relative cursor-pointer overflow-hidden">
                      <div class="position-absolute tool-wrap d-none d-flex top-0 start-0 w-100 bg-primary bg-opacity-75">
                        <div class="show-img w-100 text-center"><i class="bi bi-eye text-white"></i></div>
                        <div class="w-100 delete-img text-center"><i class="bi bi-trash text-white"></i></div>
                      </div>
                      <div class="img-info rounded h-100 w-100 d-flex justify-content-center align-items-center">
                        <i class="bi bi-plus fs-1 text-secondary opacity-75"></i>
                      </div>
                      <input type="hidden" value="" name="image" id="image">
                    </div>
                  </div>
                  <div class="form-text">اختیاری، تصویر مقدار گزینه</div>
                </div>
              </div>
              
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label for="position" class="form-label">ترتیب</label>
                  <input type="number" name="position" id="position" class="form-control" value="0">
                </div>
              </div>
              
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label class="form-label">وضعیت</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" checked>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- اطلاعات چند زبانه -->
            <div class="mt-4">
              <h6 class="mb-3">اطلاعات چند زبانه</h6>
              <ul class="nav nav-tabs" id="languageTab" role="tablist">
                @foreach (locales() as $index => $locale)
                  <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center {{ $index === 0 ? 'active' : '' }}" 
                            id="lang-{{ $locale['code'] }}-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#lang-{{ $locale['code'] }}-pane"
                            type="button" role="tab">
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
              
              <div class="tab-content mt-3" id="languageTabContent">
                @foreach (locales() as $index => $locale)
                  <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                       id="lang-{{ $locale['code'] }}-pane" 
                       role="tabpanel">
                    <div class="mb-3">
                      <label for="name_{{ $locale['code'] }}" class="form-label">
                        نام گزینه ({{ $locale['name'] }})
                        @if($locale['code'] == locale_code())
                          <span class="text-danger">*</span>
                        @endif
                      </label>
                      <input type="text" 
                             name="name[{{ $locale['code'] }}]" 
                             id="name_{{ $locale['code'] }}" 
                             class="form-control"
                             {{ $locale['code'] == locale_code() ? 'required' : '' }}>
                    </div>
                  </div>
                @endforeach
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
  let isEditMode = false;
  let currentOptionValueId = null;

  /**
   * باز کردن مودال ایجاد مقدار گزینه
   */
  function openCreateModal() {
    isEditMode = false;
    currentOptionValueId = null;
    
    // بازنشانی فرم
    $('#optionValueForm')[0].reset();
    
    // تنظیم عنوان مودال
    $('#optionValueModalLabel').text('ایجاد مقدار گزینه');
    
    // تنظیم action و method فرم
    $('#optionValueForm').attr('action', '{{ panel_route("option_values.store") }}');
    $('#form-method').val('POST'); // تنظیم به روش POST
    
    // پاک کردن فیلدهای فرم
    $('#option_group_id').val('');
    $('#price').val('');
    $('#position').val('0');
    $('#active').prop('checked', true);
    
    // پاک کردن فیلدهای چند زبانه
    @foreach (locales() as $locale)
      $('#name_{{ $locale['code'] }}').val('');
    @endforeach
    
    // نمایش مودال
    $('#optionValueModal').modal('show');
  }

  /**
   * باز کردن مودال ویرایش مقدار گزینه
   * @param {number} optionValueId - شناسه مقدار گزینه
   */
  function openEditModal(optionValueId) {
    isEditMode = true;
    currentOptionValueId = optionValueId;
    
    // تنظیم عنوان مودال
    $('#optionValueModalLabel').text('ویرایش مقدار گزینه');
    
    // تنظیم action و method فرم
    $('#optionValueForm').attr('action', '{{ panel_route("option_values.update", ":id") }}'.replace(':id', optionValueId));
    $('#form-method').val('PUT'); // تنظیم به روش PUT
    
    // نمایش وضعیت بارگذاری
    $('#optionValueModal').modal('show');
    
    // دریافت داده‌های مقدار گزینه
    $.get('{{ panel_route("option_values.show", ":id") }}'.replace(':id', optionValueId))
      .done(function(data) {
        // دیباگ: چاپ داده‌های دریافت شده
        console.log('داده‌های مقدار گزینه دریافت شده:', data);
        
        // پر کردن اطلاعات پایه
        $('#option_id').val(data.option_id);
        $('#position').val(data.position);
        $('#active').prop('checked', data.active == 1);
        
        // پر کردن فیلد تصویر
        if (data.image) {
          const imageContainer = $('.is-up-file .img-upload-item');
          const imageUrl = data.image.indexOf('http') === 0 ? data.image : '{{ asset("") }}' + data.image;
          imageContainer.find('input[name="image"]').val(data.image);
          imageContainer.find('.tool-wrap').removeClass('d-none');
          imageContainer.find('.img-info').html('<img src="' + imageUrl + '" class="img-fluid" data-origin-img="' + imageUrl + '">');
        } else {
          // بازنشانی کامپوننت تصویر به حالت پیش‌فرض
          const imageContainer = $('.is-up-file .img-upload-item');
          imageContainer.find('input[name="image"]').val('');
          imageContainer.find('.tool-wrap').addClass('d-none');
          imageContainer.find('.img-info').html('<i class="bi bi-plus fs-1 text-secondary opacity-75"></i>');
        }
        
        // پر کردن داده‌های چند زبانه
        if (data.name) {
          console.log('داده‌های چند زبانه:', data.name);
          @foreach (locales() as $locale)
            $('#name_{{ $locale['code'] }}').val(data.name['{{ $locale['code'] }}'] || '');
          @endforeach
        }
      })
      .fail(function() {
        layer.msg('دریافت داده‌های مقدار گزینه ناموفق بود', {icon: 2});
        $('#optionValueModal').modal('hide');
      });
  }

  /**
   * پردازش ارسال فرم
   */
  $('#optionValueForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = $(this).find('button[type="submit"]');
    const originalText = submitBtn.text();
    
    // نمایش وضعیت بارگذاری
    submitBtn.prop('disabled', true).text('در حال ذخیره...');
    
    $.ajax({
      url: $(this).attr('action'),
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        layer.msg(isEditMode ? 'مقدار گزینه با موفقیت به‌روزرسانی شد' : 'مقدار گزینه با موفقیت ایجاد شد', {icon: 1});
        $('#optionValueModal').modal('hide');
        
        // تازه‌سازی صفحه
        setTimeout(function() {
          window.location.reload();
        }, 1000);
      },
      error: function(xhr) {
        // پاک کردن پیام‌های خطای قبلی
        $('#form-errors').addClass('d-none');
        $('#error-list').empty();
        
        let errorMessage = 'عملیات ناموفق بود';
        let hasErrors = false;
        
        if (xhr.responseJSON && xhr.responseJSON.errors) {
          const errors = xhr.responseJSON.errors;
          hasErrors = true;
          
          // نمایش تمام خطاهای اعتبارسنجی
          Object.keys(errors).forEach(function(field) {
            const fieldErrors = errors[field];
            if (Array.isArray(fieldErrors)) {
              fieldErrors.forEach(function(error) {
                $('#error-list').append('<li>' + error + '</li>');
              });
            }
          });
          
          $('#form-errors').removeClass('d-none');
        } else if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
          $('#error-list').append('<li>' + errorMessage + '</li>');
          $('#form-errors').removeClass('d-none');
          hasErrors = true;
        }
        
        // اگر اطلاعات خطای خاصی وجود ندارد، از layer.msg برای نمایش خطای عمومی استفاده کن
        if (!hasErrors) {
          layer.msg(errorMessage, {icon: 2});
        }
      },
      complete: function() {
        // بازگرداندن وضعیت دکمه
        submitBtn.prop('disabled', false).text(originalText);
      }
    });
  });

  /**
   * بازنشانی فرم هنگام بسته شدن مودال
   */
  $('#optionValueModal').on('hidden.bs.modal', function() {
    $('#optionValueForm')[0].reset();
    $('#form-errors').addClass('d-none');
    $('#error-list').empty();
    isEditMode = false;
    currentOptionValueId = null;
    
    // بازنشانی کامپوننت تصویر
    $('.is-up-file .img-upload-item .img-info').html('<i class="bi bi-plus fs-1 text-secondary opacity-75"></i>');
    $('.is-up-file .img-upload-item .tool-wrap').addClass('d-none');
    $('.is-up-file input[name="image"]').val('');
  });

  /**
   * پردازش رویدادهای کامپوننت مدیر فایل
   */
  $(document).on('click', '.is-up-file .img-upload-item', function () {
    const _self = $(this);

    // فراخوانی مدیر فایل
    window.inno.fileManagerIframe((file) => {
      // پردازش فایل انتخاب شده
      let val = file.path;
      let url = file.url;
      _self.find('input').val(val);
      _self.find('.tool-wrap').removeClass('d-none');
      _self.find('.img-info').html('<img src="' + url + '" class="img-fluid" data-origin-img="' + url + '">');
      
      // فعال‌سازی دستی رویداد change
      _self.find('input').trigger('change');
    }, {
      multiple: false,
      type: 'image'
    });
  });

  // حذف تصویر
  $(document).on('click', '.is-up-file .delete-img', function (e) {
    e.stopPropagation();
    let _self = $(this).parent().parent();
    _self.find('input').val('');
    _self.find('.tool-wrap').addClass('d-none');
    _self.find('.img-info').html('<i class="bi bi-plus fs-1 text-secondary opacity-75"></i>');
  });

  // پیش‌نمایش تصویر
  $(document).on('click', '.is-up-file .show-img', function (e) {
    e.stopPropagation();
    let src = $(this).parent().siblings('.img-info').find('img').data('origin-img');
    if (src) {
      let img = '<img src="' + src + '" class="img-fluid">';
      // ایجاد مودال پیش‌نمایش (اگر وجود ندارد)
      if ($('#modal-show-img').length === 0) {
        $('body').append(`
          <div class="modal fade" id="modal-show-img">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
              </div>
            </div>
          </div>
        `);
      }
      $('#modal-show-img .modal-body').html(img);
      $('#modal-show-img').modal('show');
    }
  });
</script>
@endpush