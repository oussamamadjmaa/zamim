@extends('backend.layouts.master', ['title' => __('Subscription')])

@section('content')
<div class="bg-white p-3 rounded-16 border col-md-10 mx-auto position-relative">
    @if ($errors->any())
        <ul class="alert alert-danger list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <h1 class="text-center py-5">@lang('Choose payment method')</h1>

    <form method="post" action="{{ route('school.subscription.checkout') }}" enctype="multipart/form-data" id="subCheckoutForm" >
        @csrf
        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
        <div class="row mx-0 justify-content-center">
            @foreach (config('payment-methods') as $paymentMethod)
            <div class="col-md-4">
                <div class="form-check payment-method h-100">
                    <input class="d-none" type="radio" name="payment_method" id="{{ $paymentMethod['key'] }}" value="{{ $paymentMethod['key'] }}" @checked(old('payment_method', $paymentMethod['is_default'] ?? false)) />
                    <label class="form-check-label" for="{{ $paymentMethod['key'] }}">
                    @if ($paymentMethod['logo'])
                        <img src="{{ $paymentMethod['logo'] }}" alt="">
                    @else
                        <h3>{{ __($paymentMethod['title']) }}</h3>
                    @endif
                    </label>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Bank --}}
        <div style="display: none" class="bank_transfer_content">
            <div class="bg-light p-3 mt-4 mb-4">
                <table width="100%">
                    <tr>
                        <td width="50%" class="text-secondary">{{ __('Bank name') }}</td>
                        <td>{{ config('services.bank_transfer.bank_name') }}</td>
                    </tr>
                    <tr>
                        <td width="50%" class="text-secondary">{{ __('Account holder') }}</td>
                        <td>{{ config('services.bank_transfer.account_holder') }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">{{ __('Account number') }}</td>
                        <td>{{ config('services.bank_transfer.account_number') }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">{{ __('IBAN number') }}</td>
                        <td>{{ config('services.bank_transfer.IBAN') }}</td>
                    </tr>
                </table>
            </div>
            <div class="mb-3 col-12">
                <div class="mb-3">
                    <label for="image" class="form-label">صورة تأكيد الدفع (إيصال بنكي)</label>
                    <input
                        type="file"
                        class="form-control"
                        name="image"
                        id="image"
                        placeholder="صورة تأكيد الدفع (إيصال بنكي)"
                        aria-describedby="bankTransferPicHelp"
                        accept="image/png,image/jpeg"
                    />
                    <div id="bankTransferPicHelp" class="form-text">الدفع لمعلومات الحساب أعلاه</div>
                </div>

            </div>
        </div>

        <div class="text-center py-5">
            <button class="primary-button py-3 fs-5" type="submit" style="min-width: 270px;">@lang('Continue')</button>
        </div>
    </form>

    <div class="is-proccessing sub-checkout-submited" style="display: none">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        if($('input[name=payment_method]:checked').val() == 'bank_transfer') {
            $('.bank_transfer_content').show()
        }
        $(document).on('input change', 'input[name=payment_method]', function() {
            if($(this).val() == 'bank_transfer') {
                $('.bank_transfer_content').slideDown()
            }else {
                $('.bank_transfer_content').hide()
            }
        })

        $(document).on('submit', '#subCheckoutForm', function(e) {
            $(this).find('button[type=submit]').prop('disabled', true).text('{{ __("Please wait") }}');
            $('.sub-checkout-submited').show();
        })
    })
</script>
@endpush
