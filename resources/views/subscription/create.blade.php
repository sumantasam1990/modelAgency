@extends('header')
@section('content')
    <style>
        .form-group {
            margin-bottom: 12px;
        }
    </style>
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-between">
                            <h4 class="card-title fw-bold mb-4">Payment Details</h4>
                            <p class="">
                                <img src="{{asset('images/logo.png')}}" alt="Eumodelo" class="img-fluid" style="width: 100px;">
                            </p>
                        </div>


                        <form id="payment_form">
                            @csrf
                            <input type="hidden" id="_fgty" name="_encrypted">
                            <div class="form-group">
                                <label for="cardNumber">Card Number*</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="expiryDate">Expiry Date*</label>
                                    <input type="text" class="form-control" id="expiryDate" placeholder="MM/YYYY" required>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="cvv">CVV*</label>
                                    <input type="text" class="form-control" name="cvv" id="cvv" placeholder="3 digits" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cardHolder">Cardholder Name*</label>
                                <input type="text" class="form-control" name="cardHolder" id="cardHolder" placeholder="Maximum of 50 alphanumeric characters." required max="50">
                            </div>
                            <div class="form-group">
                                <label for="cardHolder">Tax ID(CPF)*</label>
                                <input type="text" class="form-control" name="tax" id="tax" placeholder="000.000.000-00" required>
                            </div>
                            <div class="d-grid gap-2 mx-auto col-10 mt-3">
                                <button type="submit" id="_paybtn" class="btn btn-dark btn-block btn-lg">Pagar R$100</button>
                                <p class="fw-bold text-black-50 text-center mt-3">Este pagaento sera prossessado pelo <img src="{{asset('images/PagSeguro.png')}}"></p>
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
