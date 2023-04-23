import './bootstrap';

// table fadeIn one/one animation
// const tableRows = document.querySelectorAll('.table tbody tr');
// tableRows.forEach((row, index) => {
//     row.style.transitionDelay = `${index * 0.1}s`;
// });
// setTimeout(() => {
//     tableRows.forEach(row => {
//         row.classList.add('fade-in');
//     });
// }, 500);

// div animation---------

const starContainer = document.querySelector('.star-container');
const rightBox = document.querySelector('#right_box');

let previousPosition = window.pageYOffset;

let noscroll = document.getElementById('right_box');
window.addEventListener('scroll', function() {
    let currentPosition = window.pageYOffset;

    if (currentPosition < previousPosition) {
        starContainer.classList.remove('hidden');
        //rightBox.classList.remove('hidden');
    } else {
        starContainer.classList.add('hidden');
        //rightBox.classList.add('hidden');
    }

    previousPosition = currentPosition;
});

// ----- payment form js -----
const expiryDateInput = document.getElementById("expiryDate");

expiryDateInput.addEventListener("input", function() {
    const inputValue = this.value;

    if (inputValue.length === 2 && inputValue.charAt(1) !== "/") {
        this.value = inputValue + "/";
    }
});

// Pagseguro card token generate
// sandbox public key = MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAr+ZqgD892U9/HXsa7XqBZUayPquAfh9xx4iwUbTSUAvTlmiXFQNTp0Bvt/5vK2FhMj39qSv1zi2OuBjvW38q1E374nzx6NNBL5JosV0+SDINTlCG0cmigHuBOyWzYmjgca+mtQu4WczCaApNaSuVqgb8u7Bd9GCOL4YJotvV5+81frlSwQXralhwRzGhj/A57CGPgGKiuPT+AOGmykIGEZsSD9RKkyoKIoc0OS8CPIzdBOtTQCIwrLn2FxI83Clcg55W8gkFSOS6rWNbG5qFZWMll6yl02HtunalHmUlRUL66YeGXdMDC2PuRcmZbGO5a/2tbVppW6mfSWG3NPRpgwIDAQAB

function getCCToken(publicKey) {
    const cardNumber = document.getElementById("cardNumber").value;
    const expiryDate = document.getElementById("expiryDate").value;
    const cvv = document.getElementById("cvv").value;
    const cardHolder = document.getElementById("cardHolder").value;

    const [month, year] = expiryDate.split("/");

    var card = PagSeguro.encryptCard({
        publicKey: publicKey,
        holder: cardHolder,
        number: cardNumber,
        expMonth: month,
        expYear: year,
        securityCode: cvv
    });

    return card.encryptedCard;

    //document.getElementById('_fgty').value = encrypted;
}

// const _tokenBtn = document.getElementById("_token");

// _tokenBtn.addEventListener("click", function() {
//     getCCToken();
// });

// Retrieve form data and send to PHP file
const form = document.querySelector('#payment_form');
form.addEventListener('submit', (event) => {
    event.preventDefault();

    document.getElementById('_paybtn').disabled = true;
    document.getElementById('pay_proc_msg').style.display = 'block';

    //validation call
    var number = document.getElementById('cardNumber').value;
    var holder = document.getElementById('cardHolder').value;
    var tax = document.getElementById('tax').value;
    var publicKey = document.getElementById('hd_public_key').value;

    var card_no = validateInputCard(number);
    var card_name = validateInputName(holder);
    var card_cpf = validateInputtaxId(tax);

    //end validation

    if (card_no && card_name && card_cpf) {
        let token = getCCToken(publicKey);

        const formData = new FormData(form);
        formData.append('encrypted', token);

        fetch('/model/checkout', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                if ( data.status === 'PAID') {
                    window.location.href='/model/success';
                } else {
                    window.location.href='/model/error';
                }
                // Process response from PHP file
            })
            .catch(error => {
                console.error(error);
                // Handle error
            });
    } else {
        document.getElementById('_paybtn').disabled = false;
    }
});

// validation
function validateInputCard(input) {
    document.getElementById('_two').innerHTML = '';
    var stripped = input.replace(/\D/g, '');

    if (stripped.length === 16) {
        return true;
    } else {
        document.getElementById('_two').innerHTML = 'Card number is invalid.';
        return false;
    }
}

function validateInputName(input) {
    document.getElementById('_one').innerHTML = '';
    var lettersAndSpaces = /^[A-Za-z\s]{1,50}$/;
    if (input.match(lettersAndSpaces) !== null) {
        return true;
    } else {
        document.getElementById('_one').innerHTML = 'Card holder name format is incorrect.';
        return false;
    }
}

function validateInputtaxId(input) {
    document.getElementById('_three').innerHTML = '';
    var stripped = input.replace(/\D/g, '');

    if (stripped.length === 11) {
        return true;
    } else {
        document.getElementById('_three').innerHTML = 'CPF ID/Tax ID format is incorrect.';
        return false;
    }
}
