@extends('layouts.app')
@section('body-class', 'page-wallet')
@section('content')
  <x-front-breadcrumb type="route" value="account.wallet.recharge.form" title="افزایش موجودی کیف پول"/>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-6">
        <div class="wallet-card-box mt-4">
          <div class="wallet-card-title mb-3">
            <span class="fw-bold">افزودن موجودی به کیف پول</span>
          </div>
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger">
              @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
              @endforeach
            </div>
          @endif
          <form method="POST" action="{{ account_route('wallet.recharge.pay') }}" class="mt-3">
            @csrf
            <div class="mb-3">
              <label for="amount" class="form-label required">مبلغ (ریال)</label>
              <input type="number" name="amount" id="amount" class="form-control" min="1000" value="{{ old('amount', 10000) }}" required>
            </div>
            <button type="submit" class="btn btn-success w-100 py-2">پرداخت و شارژ کیف پول</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
