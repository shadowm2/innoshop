<form class="needs-validation address-form mb-4" novalidate>
  <input type="hidden" name="id" value="">

  @if(current_customer_id())
    <div class="form-group mb-4">
      <label class="form-label" for="name">
        <span class="text-danger">*</span>
        {{ __('common/address.name') }}
      </label>
      <input type="text" class="form-control" name="name" value="" required
             placeholder="{{ __('common/address.name') }}"/>
      <span class="invalid-feedback" role="alert">{{ __('front/common.error_required', ['name' => __('common/address.name')]) }}</span>
    </div>
  @else
    <div class="row gx-2">
      <div class="col-6">
        <div class="form-group mb-4">
          <label class="form-label" for="name">
            <span class="text-danger">*</span>
            // Choose state to select: system setting or default
            var stateToSelect = settingStateCode || defaultStateCode;
          <input type="text" class="form-control" name="name" value="" required
                 placeholder="{{ __('common/address.name') }}"/>
          <span class="invalid-feedback" role="alert">{{ __('front/common.error_required', ['name' => __('common/address.name')]) }}</span>
        </div>
              // ensure cities get loaded (handle race/re-render cases)
              ensureCitiesLoaded(5);
            }
      <div class="col-6">
        <div class="form-group mb-4">
          <label class="form-label" for="email">
            <span class="text-danger">*</span>
            {{ __('common/address.email') }}
          </label>

      // Ensure states are loaded after pre-selecting country
      function ensureStatesLoaded(attempts) {
        var $stateSelect = $('select[name="state_code"]');
        if ($stateSelect.length && !$stateSelect.prop('disabled') && $stateSelect.find('option').length > 1) {
          return;
        }
        if (attempts <= 0) return;
        // re-trigger country change to force reload
        var $countrySelect = $('select[name="country_code"]');
        if ($countrySelect.length && $countrySelect.val()) {
          $countrySelect.trigger('change');
        }
        setTimeout(function () { ensureStatesLoaded(attempts - 1); }, 200);
      }

      // Ensure cities are loaded after pre-selecting state
      function ensureCitiesLoaded(attempts) {
        var $citySelect = $('select[name="city_id"]');
        if ($citySelect.length && !$citySelect.prop('disabled') && $citySelect.find('option').length > 1) {
          return;
        }
        if (attempts <= 0) return;
        // re-trigger state change to force reload
        var $stateSelect = $('select[name="state_code"]');
        if ($stateSelect.length && $stateSelect.val()) {
          $stateSelect.trigger('change');
        }
        setTimeout(function () { ensureCitiesLoaded(attempts - 1); }, 200);
      }
          <input type="text" class="form-control" name="email" value="" required
                 placeholder="{{ __('common/address.email') }}"/>
          <span class="invalid-feedback" role="alert">{{ __('front/common.error_required', ['name' => __('common/address.email')]) }}</span>
        </div>
      </div>
    </div>
  @endif

  <div class="form-group mb-4">
    <label class="form-label" for="email">
      <span class="text-danger">*</span>
      {{ __('common/address.address_1') }}</label>
    <input type="text" class="form-control" name="address_1" value="" required
           placeholder="{{ __('common/address.address_1') }}"/>
    <span class="invalid-feedback" role="alert">{{ __('front/common.error_required', ['name' => __('common/address.address_1')]) }}</span>
  </div>

  <div class="row gx-2">
    <div class="col-6">
      <div class="form-group mb-4">
        <label class="form-label" for="Address_1">{{ __('common/address.address_2') }}</label>
        <input type="text" class="form-control" name="address_2" value=""
               placeholder="{{ __('common/address.address_2') }}"/>
      </div>
    </div>

    <div class="col-6">
      <div class="form-group mb-4">
        <label class="form-label" for="zipcode">
          <span class="text-danger">*</span>
          {{ __('common/address.zipcode') }}
        </label>
        <input type="text" class="form-control" name="zipcode" value="" required
               placeholder="{{ __('common/address.zipcode') }}"/>
        <span class="invalid-feedback" role="alert">{{ __('front/common.error_required', ['name' => __('common/address.zipcode')]) }}</span>
      </div>
    </div>

    <div class="col-6">
      <div class="form-group mb-4">
        <label class="form-label" for="country_code">
          <span class="text-danger">*</span>
          {{ __('common/address.country') }}
        </label>
        <select class="form-select" name="country_code" required>
          <option value="">{{ __('front/common.please_choose') }}</option>
        </select>
        <span class="invalid-feedback" role="alert">{{ __('front/common.error_required', ['name' => __('common/address.country')]) }}</span>
      </div>
    </div>

    <div class="col-6">
      <div class="form-group mb-4">
        <label class="form-label" for="state">
          <span class="text-danger">*</span>
          {{ __('common/address.state') }}
        </label>
        <select class="form-select" name="state_code" required disabled>
          <option value="">{{ __('front/common.please_choose') }}</option>
        </select>
        <span class="invalid-feedback" role="alert">{{ __('front/common.error_required', ['name' => __('common/address.state')]) }}</span>
      </div>
    </div>

    <div class="col-6">
      <div class="form-group mb-4">
        <label class="form-label" for="city">
          <span class="text-danger">*</span>
          {{ __('common/address.city') }}
        </label>
        <select class="form-select" name="city_id" required disabled>
          <option value="">{{ __('front/common.please_choose') }}</option>
        </select>
        <span class="invalid-feedback" role="alert">{{ __('front/common.error_required', ['name' => __('common/address.city')]) }}</span>
      </div>
    </div>

    <div class="col-6">
      <div class="form-group mb-4">
        <label class="form-label" for="phone">
          <span class="text-danger">*</span>
          {{ __('common/address.phone') }}
        </label>
        <input type="text" class="form-control" name="phone" value="" required
               placeholder="{{ __('common/address.phone') }}"/>
        <span class="invalid-feedback" role="alert">{{ __('front/common.error_required', ['name' => __('common/address.phone')]) }}</span>
      </div>
    </div>

    <div class="col-6">
      <div class="form-group mb-4 d-flex gap-3">
        <label class="form-label" for="default">{{__('front/common.default')}}</label>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="default" name="default" value="1">
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <button type="button" class="btn btn-primary btn-lg form-submit w-50">{{ __('front/common.submit') }}</button>
  </div>
</form>

@push('footer')
  <script>
  const settingCountryCode = @json(system_setting('country_code') ?? '');
  const settingStateCode = @json(system_setting('state_code') ?? '');
  // Optional stored city id (if system setting exists)
  const settingCityId = @json(system_setting('city_id') ?? null);

  // Defaults to apply when no system setting is present
  const defaultCountryCode = 'IR'; // ایران
  const defaultStateCode = '09'; // خراسان رضوی (code in your DB)
  const defaultCityName = 'مشهد'; // fallback city name to select

    inno.validateAndSubmitForm('.address-form', function (data) {
      if (typeof updateAddress === 'function') {
        updateAddress(data);
      }
    });

  // Debug: log environment and start
  console.log('[address-form] init - jQuery:', typeof $, ' axios:', typeof axios);

    // Event handlers for dropdowns
    $(document).on('change', 'select[name="country_code"]', function () {
      var countryCode = $(this).val();
      if (countryCode) {
        loadStates(countryCode);
      } else {
        resetStateAndCity();
      }
    });

    $(document).on('change', 'select[name="state_code"]', function () {
      var stateCode = $(this).val();
      if (stateCode) {
        loadCities(stateCode);
      } else {
        resetCity();
      }
    });

    // Now that handlers are registered, initialize when the form is actually present in the DOM.
    // Vue may render this form after our script runs, so poll for the select element and then init.
    (function initWhenReady(retries = 20, delay = 200) {
      var $countrySelect = $('select[name="country_code"]');
      if ($countrySelect.length && !$countrySelect.data('inno-init')) {
        $countrySelect.data('inno-init', true);
        console.log('[address-form] form found, initializing...');
        loadInitialData();
        return;
      }

      if (retries <= 0) {
        console.warn('[address-form] form not found after retries, giving up');
        return;
      }

      setTimeout(function () { initWhenReady(retries - 1, delay); }, delay);
    })();

    // Load initial country and state data
    function loadInitialData() {
      var $countrySelect = $('select[name="country_code"]');
      enableSelect($countrySelect);

      // If axios is available use it, otherwise fallback to fetch
      if (typeof axios !== 'undefined') {
          console.log('[address-form] Loading countries...');
          axios.get('/api/location/countries')
          .then(function (response) {
            console.log('[address-form] /api/location/countries response (axios):', response);
            var payload = normalizeResponse(response);
            console.log('[address-form] Normalized payload:', payload);
            populateCountries(payload);
            // Always leave country unselected by default (show 'please choose')
            // Do NOT pre-select from system settings here to avoid auto-loading states/cities.
            var countryToSelect = '';
          })
          .catch(function (error) {
            console.error('Error loading countries (axios):', error);
            disableSelect($countrySelect);
          });
      } else if (typeof fetch !== 'undefined') {
        // fallback to fetch
        fetch('/api/countries', { credentials: 'same-origin' })
          .then(function (res) { return res.json(); })
          .then(function (body) {
            console.log('[address-form] /api/countries response (fetch):', body);
            var payload = Array.isArray(body) ? body : (Array.isArray(body.data) ? body.data : []);
            populateCountries(payload);
            // Only pre-select country if a system setting exists
            if (settingCountryCode) {
              $countrySelect.val(settingCountryCode);
              if ($countrySelect.val() === settingCountryCode) {
                $countrySelect.trigger('change');
              }
            }
          })
          .catch(function (error) {
            console.error('Error loading countries (fetch):', error);
            disableSelect($countrySelect);
          });
      } else {
        console.error('[address-form] No HTTP client available (axios/fetch)');
        disableSelect($countrySelect);
      }
    }

    // Load states for a country
    function loadStates(countryCode) {
      var $stateSelect = $('select[name="state_code"]');
      $stateSelect.empty().append($('<option value="">{{ __('front/common.please_choose') }}</option>'));
      console.log('[address-form] loadStates called for', countryCode);

      // Try axios if available, otherwise fallback to fetch
      if (typeof axios !== 'undefined') {
        axios.get('/api/location/countries/' + countryCode + '/states')
          .then(function (response) {
            console.log('[address-form] /states response (axios):', response);
            var payload = normalizeResponse(response);
            populateStates(payload);
            // Choose state to select: system setting or default
            var stateToSelect = settingStateCode || defaultStateCode;
            if (stateToSelect) {
              $stateSelect.val(stateToSelect);
              // trigger change to load cities
              $stateSelect.trigger('change');
              // ensure cities get loaded (handle race/re-render cases)
              ensureCitiesLoaded(5);
            }
          })
          .catch(function (error) {
            console.error('[address-form] Error loading states (axios):', error);
            fetchStatesFallback(countryCode);
          });
      } else {
        fetchStatesFallback(countryCode);
      }
    }

    // Load cities for a state
    function loadCities(stateCode) {
      var $citySelect = $('select[name="city_id"]');
      $citySelect.empty().append($('<option value="">{{ __('front/common.please_choose') }}</option>'));
      console.log('[address-form] loadCities called for', stateCode);
      if (typeof axios !== 'undefined') {
        axios.get('/api/location/states/' + stateCode + '/cities')
          .then(function (response) {
            console.log('[address-form] /cities response (axios):', response);
            var payload = normalizeResponse(response);
            populateCities(payload);
          })
          .catch(function (error) {
            console.error('[address-form] Error loading cities (axios):', error);
            fetchCitiesFallback(stateCode);
          });
      } else {
        fetchCitiesFallback(stateCode);
      }
    }

    // Normalize API response: accept resource-wrapped {data: [...]} or raw array
    function normalizeResponse(response) {
      if (!response) return [];
      const body = response.data || response;
      if (Array.isArray(body)) return body;
      if (body && Array.isArray(body.data)) return body.data;
      if (body && Array.isArray(body.items)) return body.items;
      return [];
    }    // Populate country dropdown
    function populateCountries(countries) {
      var select = $('select[name="country_code"]');
      select.find('option:not(:first)').remove();

      if (countries.length === 0) {
        disableSelect(select);
        resetStateAndCity();
      } else {
        enableSelect(select);
        countries.forEach(function (country) {
          select.append(
              $('<option></option>')
                .val(country.code)
                .text(country.name)
            );
        });
      }
    }

    // Populate state dropdown
    function populateStates(states) {
      var select = $('select[name="state_code"]');
      select.find('option:not(:first)').remove();
      
      if (states.length === 0) {
        disableSelect(select);
        resetCity();
      } else {
        enableSelect(select);
        states.forEach(function (state) {
          select.append(
            $('<option></option>')
              .val(state.code)
              .text(state.name)
          );
        });
      }
    }

    // Populate city dropdown
    function populateCities(cities) {
      var select = $('select[name="city_id"]');
      select.find('option:not(:first)').remove();
      
      if (!cities || cities.length === 0) {
        disableSelect(select);
      } else {
        enableSelect(select);
        cities.forEach(function (city) {
          select.append(
            $('<option></option>')
              .val(city.id)
              .text(city.name)
          );
        });

        // Auto-select a city: first try stored city id, otherwise match by name fallback
        if (settingCityId) {
          select.val(settingCityId);
        } else {
          // match by displayed text (city name) to support non-numeric ids
          var matched = select.find('option').filter(function () {
            return $(this).text().trim() === defaultCityName;
          }).first();
          if (matched && matched.length) {
            select.val(matched.val());
          }
        }
      }
    }

    // Enable a select element
    function enableSelect(select) {
      select.prop('disabled', false)
           .prop('required', true)
           .removeClass('bg-light');
    }

    // Disable a select element
    function disableSelect(select) {
      select.prop('disabled', true)
           .prop('required', false)
           .addClass('bg-light')
           .val('');
    }

    // Reset state and city dropdowns
    function resetStateAndCity() {
      var stateSelect = $('select[name="state_code"]');
      stateSelect.find('option:not(:first)').remove();
      disableSelect(stateSelect);
      resetCity();
    }

    // Reset city dropdown
    function resetCity() {
      var citySelect = $('select[name="city_id"]');
      citySelect.find('option:not(:first)').remove();
      disableSelect(citySelect);
    }



    function clearForm() {
      const addressForm = $('.address-form');
      addressForm[0].reset();
      addressForm.removeClass('was-validated');

      addressForm.find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
    }
  </script>
@endpush
