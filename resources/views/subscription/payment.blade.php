@extends('header')
@section('content')
{{--    <script src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>--}}
<script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <button id="checkout-button">Checkout</button>
    <input type="text" id="pagseguro-session-id" value="{{ $sessionId }}">
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <script>
        var sessionId = $('#pagseguro-session-id').val();
        console.log(sessionId);
        PagSeguroDirectPayment.setSessionId(sessionId);

        $('#checkout-button').click(function(e) {
            e.preventDefault();

            console.log('pay start...')

            // Set buyer data
            var senderName = 'John Doe';
            var senderEmail = 'john.doe@example.com';
            var senderPhone = '11 999999999';

            // Get device hash
            PagSeguroDirectPayment.onSenderHashReady(function(response){
                if(response.status == 'error') {
                    console.log(response.message);
                    return false;
                }
                var senderHash = response.senderHash;

                // Send buyer data and senderHash to your server
                $.ajax({
                    url: '/create-payment-with-pre-approval',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        senderName: senderName,
                        senderEmail: senderEmail,
                        senderPhone: senderPhone,
                        senderHash: senderHash,
                    },
                    success: function(data) {
                        console.log(data);
                        console.log(data.paymentLink)
                       // if (data.success) {
                            window.location.href = data.paymentLink;
                        // } else {
                        //     alert('An error occurred while creating the payment.');
                        // }
                    },
                    error: function (e) {
                        console.log(e)
                    }
                });
            });
        });
    </script>

@endsection



