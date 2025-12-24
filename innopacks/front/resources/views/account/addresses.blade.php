@extends('layouts.app')
@section('body-class', 'page-addresses')

@section('content')
    <x-front-breadcrumb type="route" value="account.addresses.index" title="{{ __('front/account.addresses') }}" />

    @hookinsert('account.addresses.top')

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('shared.account-sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <div class="account-card-box addresses-box">
                    <div class="account-card-title d-flex justify-content-between align-items-center">
                        <span class="fw-bold">{{ __('common/address.address') }}</span>
                        <button type="button"
                            class="btn btn-primary add-address">{{ __('common/address.add_new_address') }}</button>
                    </div>
                    <div class="row">
                        @foreach ($addresses as $index => $address)
                            <div class="col-12 col-md-6">
                                <div class="address-card" data-id="{{ $address['id'] }}">
                                    <div class="address-card-header">
                                        <h5 class="address-card-title">{{ sub_string($address['name']) }}</h5>
                                        <div class="address-card-actions">
                                            @if ($address['default'])
                                                <div class="bg-success text-white p-1 required rounded">
                                                    {{ __('front/common.default') }}
                                                </div>
                                            @endif
                                            <button type="button"
                                                class="btn btn-link edit-address">{{ __('front/common.edit') }}</button>
                                            <button type="button"
                                                class="btn btn-link delete-address">{{ __('front/common.delete') }}</button>
                                        </div>
                                    </div>
                                    <div class="address-card-body">
                                        <p>{{ __('common/address.name') }}: {{ $address['name'] }}</p>
                                        <p>{{ __('common/address.phone') }}: {{ $address['phone'] }}</p>
                                        <p>{{ __('common/address.zipcode') }}: {{ $address['zipcode'] }}</p>
                                        <p>{{ __('common/address.address_1') }}: {{ $address['address_1'] }}</p>
                                        @if ($address['address_2'])
                                            <p>{{ __('common/address.address_2') }}: {{ $address['address_2'] }}</p>
                                        @endif
                                        <p>{{ __('common/address.region') }}: {{ $address['city'] }},
                                            {{ $address['state'] }}
                                            , {{ $address['country_name'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">{{ __('common/address.address') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('shared.address-form')
                </div>
            </div>
        </div>
    </div>

    @hookinsert('account.addresses.bottom')

@endsection

@push('footer')
    <script>
        const addresses = @json($addresses);
        const isDefault = $('#default');

        $('.add-address').on('click', function() {
            $('.address-form').find('input, select').each(function() {
                $(this).val('')
            })
            isDefault.val(1);

            $('#addressModal').modal('show');
        });

        // Use event delegation to bind edit button events
        $(document).on('click', '.edit-address', function() {
            const id = $(this).closest('.address-card').data('id');
            const address = addresses.find(address => address.id === id);

            // Show the modal first
            $('#addressModal').modal('show');

            // Wait for modal to be shown and form to be ready
            $('#addressModal').on('shown.bs.modal', function() {
                // Reset form fields first
                $('.address-form').find('input, select').each(function() {
                    $(this).val('');
                });

                // Set all form values except country/state/city which need special handling
                $('.address-form input[name="name"]').val(address.name);
                $('.address-form input[name="address_1"]').val(address.address_1);
                $('.address-form input[name="address_2"]').val(address.address_2);
                $('.address-form input[name="zipcode"]').val(address.zipcode);
                $('.address-form input[name="phone"]').val(address.phone);

                // Set default checkbox
                if (address.default === 1) {
                    $('.address-form input[name="default"]').prop('checked', true);
                } else {
                    $('.address-form input[name="default"]').prop('checked', false);
                }

                // Set the ID for update operation
                $('.address-form input[name="id"]').val(address.id);

                // Set country first, then trigger change to load states
                const $countrySelect = $('.address-form select[name="country_code"]');
                if ($countrySelect.length && address.country_code) {
                    $countrySelect.val(address.country_code);
                    $countrySelect.trigger('change');

                    // After country loads, set state
                    setTimeout(function() {
                        const $stateSelect = $('.address-form select[name="state_code"]');
                        if ($stateSelect.length && address.state_code) {
                            $stateSelect.val(address.state_code);
                            $stateSelect.trigger('change');

                            // After state loads, set city
                            setTimeout(function() {
                                const $citySelect = $(
                                    '.address-form select[name="city_id"]');
                                if ($citySelect.length && address.city_id) {
                                    $citySelect.val(address.city_id);
                                } else if ($citySelect.length && address.city) {
                                    // Fallback to city name if city_id is not available
                                    $citySelect.find('option').filter(function() {
                                        return $(this).text() === address.city;
                                    }).first().prop('selected', true);
                                }
                            }, 300);
                        }
                    }, 300);
                }
            });
        });

        // Use event delegation to bind delete button events
        $(document).on('click', '.delete-address', function() {
            const id = $(this).closest('.address-card').data('id');

            layer.confirm('{{ __('front/common.delete_confirm') }}', {
                btn: ['{{ __('front/common.confirm') }}', '{{ __('front/common.cancel') }}']
            }, function() {
                axios.delete(`{{ account_route('addresses.index') }}/${id}`).then(function(res) {
                    if (res.success) {
                        layer.msg(res.message, {
                            icon: 1,
                            time: 1000
                        }, function() {
                            window.location.reload()
                        });
                    }
                })
            });
        });

        function updateAddress(params) {
            const id = new URLSearchParams(params).get('id');
            const href = @json(account_route('addresses.index'));
            const method = id ? 'put' : 'post'
            const url = id ? `${href}/${id}` : href

            axios[method](url, params).then(function(res) {
                if (res.success) {
                    $('#addressModal').modal('hide');
                    inno.msg(res.message);
                    window.location.reload();
                }
            }).catch(function(error) {
                console.error('Error updating address:', error);
                if (error.response && error.response.data && error.response.data.message) {
                    inno.msg(error.response.data.message, {
                        icon: 2
                    });
                } else {
                    inno.msg('An error occurred while updating the address', {
                        icon: 2
                    });
                }
            });
        }
    </script>
@endpush
