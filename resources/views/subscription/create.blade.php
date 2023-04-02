@extends('header')
@section('content')
    <style>
        .form-group {
            margin-bottom: 12px;
        }
    </style>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-4">Payment Details</h4>
                        <form id="payment_form">
                            @csrf
                            <input type="hidden" id="_fgty" name="_encrypted">
                            <div class="form-group">
                                <label for="cardNumber">Card Number*</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="cardNumber" placeholder="Enter card number" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col form-group">
                                    <label for="expiryDate">Expiry Date*</label>
                                    <input type="text" class="form-control" id="expiryDate" placeholder="MM/YYYY" required>
                                </div>
                                <div class="col form-group">
                                    <label for="cvv">CVV*</label>
                                    <input type="text" class="form-control" name="cvv" id="cvv" placeholder="Enter CVV" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cardHolder">Cardholder Name*</label>
                                <input type="text" class="form-control" name="cardHolder" id="cardHolder" placeholder="Enter cardholder name" required>
                            </div>
                            <div class="form-group">
                                <label for="cardHolder">Tax ID*</label>
                                <input type="text" class="form-control" name="tax" id="tax" placeholder="Enter your tax id" required>
                            </div>
                            <div class="d-grid gap-2 mx-auto col-5 mt-3">
                                <button type="submit" id="_paybtn" class="btn btn-dark btn-block btn-lg">Pay R$100</button>
                                <small class="fw-bold text-black-50 text-center">We will charge you every month.</small>
                                <p class="mt-3 fw-bold text-black text-uppercase fs-6 text-center d-none" id="pay_proc_msg">
                                    Please wait... Do not close the browser. We are processing your payment...
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>

@endsection
