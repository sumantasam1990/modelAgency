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
                            <h4 class="card-title fw-bold mb-4">{{__('main.Payments_Details')}}</h4>
                            <p class="">
                                <img src="{{asset('images/logo.png')}}" alt="Eumodelo" class="img-fluid" style="width: 100px;">
                            </p>
                        </div>

                        <div class="text-danger">
                            <ul style="list-style: none;">
                                <li style="list-style: none;" id="_one"></li>
                                <li style="list-style: none;" id="_two"></li>
                                <li style="list-style: none;" id="_three"></li>
                            </ul>
                        </div>

                        <form id="payment_form">
                            @csrf
                            <input type="hidden" id="hd_public_key" value="{{$publicKey}}">
                            <input type="hidden" id="_fgty" name="_encrypted">
                            <div class="form-group">
                                <label for="cardNumber">{{__('main.Card_Number')}}*</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="cardNumber" placeholder="Digite o número do cartão" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="expiryDate">{{__('main.Expiry_Date')}}*</label>
                                    <input type="text" class="form-control" id="expiryDate" placeholder="{{__('main.MM/YYYY')}}" required>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="cvv">CVV*</label>
                                    <input type="number" class="form-control" name="cvv" id="cvv" placeholder="Digite o CVV" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cardHolder">{{__('main.Cardholder_name')}}*</label>
                                <input type="text" class="form-control" name="cardHolder" id="cardHolder" placeholder="Digite o nome do titular do cartão" required max="50">
                            </div>
                            <div class="form-group">
                                <label for="cardHolder">{{__('main.Tax_ID')}}*</label>
                                <input type="number" class="form-control" name="tax" id="tax" placeholder="Digite o CPF do titular do cartão" required>
                            </div>
                            <div class="d-grid gap-2 mx-auto col-10 mt-3">
                                <button type="submit" id="_paybtn" class="btn btn-dark btn-block btn-lg">Pagar R$100</button>
                                <p class="fw-bold text-black-50 text-center mt-3">Este pagamento será processado por <img src="{{asset('images/PagSeguro.png')}}"></p>
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

    <script>
        const cardNumber = document.getElementById("cardNumber");
        const cardHolder = document.getElementById("cardHolder");
        const tax = document.getElementById("tax");
        const cvv = document.getElementById("cvv");

        cardNumber.addEventListener("keyup", function() {
            if (cardNumber.value.length > 16) {
                cardNumber.value = cardNumber.value.replace(/[^0-9]/g, '')
                cardNumber.value = cardNumber.value.substring(0, 16);
            }
        });

        cardHolder.addEventListener("keyup", function() {
            if (cardHolder.value.length > 50) {
                cardHolder.value = cardHolder.value.substring(0, 50);
            }
        });

        tax.addEventListener("keyup", function() {
            if (tax.value.length > 11) {
                tax.value = tax.value.substring(0, 11);
            }
        });

        cvv.addEventListener("keyup", function() {
            if (cvv.value.length > 3) {
                cvv.value = cvv.value.substring(0, 3);
            }
        });

    </script>

@endsection


