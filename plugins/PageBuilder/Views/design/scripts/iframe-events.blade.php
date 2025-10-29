<script>
  // عملیات iframe
  var previewWindow = null;
  $('#preview-iframe').on('load', function(event) {
    previewWindow = document.getElementById("preview-iframe").contentWindow;
    if (typeof app !== 'undefined' && app.design) {
      app.design.ready = true;
    }

    // ویرایش ماژول
    $(previewWindow.document).on('click', '.module-edit .edit', function(event) {
      // if (typeof app === 'undefined' || !app.form || !app.form.modules) return;
      const module_id = $(this).parents('.module-item').prop('id').replace('module-', '');
      const modules = app.form.modules;
      const editingModuleIndex = modules.findIndex(e => e.module_id == module_id);
      if (editingModuleIndex >= 0) {
        app.editModuleButtonClicked(editingModuleIndex);
      }
    });

    // حذف ماژول
    $(previewWindow.document).on('click', '.module-edit .delete', function(event) {
      if (typeof app === 'undefined' || !app.form || !app.form.modules) return;
      const module_id = $(this).parents('.module-item').prop('id').replace('module-', '');
      const editingModuleIndex = app.form.modules.findIndex(e => e.module_id == module_id);
      if (editingModuleIndex >= 0) {
        if (confirm('آیا مطمئن هستید که می‌خواهید این ماژول را حذف کنید؟')) {
          app.design.editType = 'add';
          app.design.editingModuleIndex = 0;
          $(previewWindow.document).find('.tooltip').remove();
          $(this).parents('.module-item').remove();
          app.form.modules.splice(editingModuleIndex, 1);
        }
      }
    });

    // انتقال ماژول به بالا
    $(previewWindow.document).on('click', '.module-edit .up', function(event) {
      if (typeof app === 'undefined' || !app.form || !app.form.modules) return;
      const module_id = $(this).parents('.module-item').prop('id').replace('module-', '');
      const modules = app.form.modules;
      const editingModuleIndex = modules.findIndex(e => e.module_id == module_id);
      if (editingModuleIndex > 0) {
        const module = modules[editingModuleIndex];
        modules.splice(editingModuleIndex, 1);
        modules.splice(editingModuleIndex - 1, 0, module);
        $(this).parents('.module-item').insertBefore($(this).parents('.module-item').prev());
        app.form.modules = modules;
      }
    });

    // انتقال ماژول به پایین
    $(previewWindow.document).on('click', '.module-edit .down', function(event) {
      if (typeof app === 'undefined' || !app.form || !app.form.modules) return;
      const module_id = $(this).parents('.module-item').prop('id').replace('module-', '');
      const modules = app.form.modules;
      const editingModuleIndex = modules.findIndex(e => e.module_id == module_id);
      if (editingModuleIndex < modules.length - 1) {
        const module = modules[editingModuleIndex];
        modules.splice(editingModuleIndex, 1);
        modules.splice(editingModuleIndex + 1, 0, module);
        $(this).parents('.module-item').insertAfter($(this).parents('.module-item').next());
        app.form.modules = modules;
      }
    });

    new Sortable(document.getElementById('module-list-wrap'), {
        group: {
          name: 'shared',
          pull: 'clone',
          put: false // اجازه کشیدن و رها کردن در این لیست داده نمی‌شود
        },
        // ghostClass: 'iframe-modules-sortable-ghost',
        animation: 150,
        sort: false, // تنظیم بر false، غیرفعال کردن مرتب‌سازی
        onEnd: function (evt) {
          if (evt.to.id != 'home-modules-box') {
            return;
          }

          // دریافت موقعیت فعلی در modules-box که چندمین است
          const index = $(previewWindow.document).find('.modules-box').children().index(evt.item);
          const moduleCode = $(evt.item).find('.module-list').data('code');

          app.addModuleButtonClicked(moduleCode, index, () => {
            evt.item.parentNode.removeChild(evt.item);
          });
        }
      });

      new Sortable(previewWindow.document.getElementById('home-modules-box'), {
        group: {
          name: 'shared',
          pull: 'clone',
        },
        animation: 150,
        onUpdate: function (evt) {
          const modules = app.form.modules;
          const module = modules.splice(evt.oldIndex, 1)[0];
          modules.splice(evt.newIndex, 0, module);
          app.form.modules = modules;
        }
      });
  });
</script> 