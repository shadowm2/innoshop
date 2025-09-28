@extends('panel::layouts.blank')

@section('title', __('panel/menu.file_manager'))

@prepend('header')
  <meta name="api-token" content="{{ auth()->user()->api_token }}">
  <script>
    window.fileManagerConfig = Object.freeze({
      driver: '{{ $config['driver'] }}',
      endpoint: '{{ $config['endpoint'] }}',
      bucket: '{{ $config['bucket'] }}',
      baseUrl: '{{ $config['baseUrl'] }}',
      multiple: {{ $multiple ? 'true' : 'false' }},
      type: '{{ $type }}',
      uploadMaxFileSize: '{{ $uploadMaxFileSize ?? "unknown" }}',
      postMaxSize: '{{ $postMaxSize ?? "unknown" }}'
    });
    console.log('File manager config initialized in iframe:', window.fileManagerConfig);
  </script>
@endprepend

@section('page-bottom-btns')
  <div class="page-bottom-btns" id="bottom-btns">
    <button class="btn btn-primary" @click="handleConfirm">{{ __('panel/file_manager.confirm_selection') }}</button>
  </div>
@endsection

@push('header')
  <style>
    body {
      display: flex;
      flex-direction: column;
      height: 100vh;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    /* Main content area */
    .content-wrapper {
      overflow: hidden;
      position: relative;
    }

    /* File manager content area */
    .file-manager {
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    /* File list area */
    .file-list {
      flex: 1;
      overflow-y: auto;
      padding: 20px;
    }

    /* Bottom buttons fixed at bottom */
    .page-bottom-btns {
      height: 60px;
      padding: 10px;
      background: #fff;
      border-top: 1px solid #EBEEF5;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      z-index: 10;
    }

    /* Left folder tree */
    .folder-tree {
      height: 100%;
      border-right: 1px solid #EBEEF5;
      overflow-y: auto;
    }

    /* Toolbar styles */
    .file-toolbar {
      padding: 15px 20px;
      border-bottom: 1px solid #EBEEF5;
      background: #fff;
      position: relative;
      z-index: 10;
    }
  </style>
@endpush

@push('footer')
  <script>
    // 创建底部按钮的 Vue 实例
    new Vue({
      el: '#bottom-btns',
      methods: {
        handleConfirm() {
          // Get main Vue instance and call its method
          const mainApp = document.querySelector('#app').__vue__;
          if (mainApp && typeof mainApp.confirmSelection === 'function') {
            mainApp.confirmSelection();
          }
        }
      }
    });

    // Get token from parent window
    window.getApiToken = () => {
      const token = window.parent?.document.querySelector('meta[name="api-token"]')?.getAttribute('content');
      console.log('Parent token:', token);
      return token;
    };
  </script>
@endpush

<div class="content-wrapper">
  @include('panel::file_manager.main')
</div>