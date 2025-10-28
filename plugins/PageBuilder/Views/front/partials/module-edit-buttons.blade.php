{{-- دکمه‌های ویرایش --}}
@if (request()->get('design'))
  <div class="module-edit">
    <div class="edit-wrap">
      <div class="up" title="{{ __('PageBuilder::modules.move_up') }}" data-action="move-up" data-module-id="{{ $module['module_id'] ?? $loop->index }}">
        ↑
      </div>
      <div class="down" title="{{ __('PageBuilder::modules.move_down') }}" data-action="move-down" data-module-id="{{ $module['module_id'] ?? $loop->index }}">
        ↓
      </div>
      <div class="edit" title="{{ __('PageBuilder::modules.edit') }}" data-action="edit" data-module-id="{{ $module['module_id'] ?? $loop->index }}">
        ✎
      </div>
      <div class="delete" title="{{ __('PageBuilder::modules.delete') }}" data-action="delete" data-module-id="{{ $module['module_id'] ?? $loop->index }}">
        ✕
      </div>
    </div>
  </div>
@endif