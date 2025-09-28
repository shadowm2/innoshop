@extends('panel::layouts.app')

@section('title', 'جزئیات پلاگین')

@section('content')
  <div class="card h-min-600">
    <div class="card-body">
      <h6 class="border-bottom pb-3 mb-4">خطا</h6>

      @if (session()->has('errors'))
        <x-common-alert type="danger" msg="{{ session('errors')->first() }}" class="mt-4"/>
      @endif

      @if (session('success'))
        <x-common-alert type="success" msg="{{ session('success') }}" class="mt-4"/>
      @endif

      {{ $error }}

    </div>
  </div>
@endsection

@push('footer')
  <script></script>
@endpush
