@extends('header')
@section('content')
    <style>
        .form-group {
            margin-bottom: 12px;
        }
    </style>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-4">Payment Details</h4>
                        <form id="payment_form">
                            @csrf
                            <input type="hidden" id="_fgty" name="_encrypted">
                            <div class="form-group">
                                <label for="cardNumber">Card Number*</label>
                                <div class="input-group">
                                    <input type="text" value="4111111111111111" class="form-control" id="cardNumber" placeholder="Enter card number" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col form-group">
                                    <label for="expiryDate">Expiry Date*</label>
                                    <input type="text" value="10/2026" class="form-control" id="expiryDate" placeholder="MM/YYYY" required>
                                </div>
                                <div class="col form-group">
                                    <label for="cvv">CVV*</label>
                                    <input type="text" value="234" class="form-control" name="cvv" id="cvv" placeholder="Enter CVV" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cardHolder">Cardholder Name*</label>
                                <input type="text" value="John doe" class="form-control" name="cardHolder" id="cardHolder" placeholder="Enter cardholder name" required>
                            </div>
                            <div class="form-group">
                                <label for="cardHolder">Tax ID*</label>
                                <input type="text" value="12345678909" class="form-control" name="tax" id="tax" placeholder="Enter your tax id" required>
                            </div>
                            <div class="d-grid gap-2 mx-auto col-5">
                                <button type="submit" class="btn btn-dark btn-block btn-lg">Pay Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>

@endsection
