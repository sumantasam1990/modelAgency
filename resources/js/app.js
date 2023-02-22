import './bootstrap';

// table fadeIn one/one animation
const tableRows = document.querySelectorAll('.table tbody tr');

// Stagger the animation by adding a delay for each row
tableRows.forEach((row, index) => {
    row.style.transitionDelay = `${index * 0.1}s`;
});

// Add the "fade-in" class to each row to trigger the animation
setTimeout(() => {
    tableRows.forEach(row => {
        row.classList.add('fade-in');
    });
}, 500);

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

function getCCToken() {
    const cardNumber = document.getElementById("cardNumber").value;
    const expiryDate = document.getElementById("expiryDate").value;
    const cvv = document.getElementById("cvv").value;
    const cardHolder = document.getElementById("cardHolder").value;

    const [month, year] = expiryDate.split("/");

    var card = PagSeguro.encryptCard({
        publicKey: "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAr+ZqgD892U9/HXsa7XqBZUayPquAfh9xx4iwUbTSUAvTlmiXFQNTp0Bvt/5vK2FhMj39qSv1zi2OuBjvW38q1E374nzx6NNBL5JosV0+SDINTlCG0cmigHuBOyWzYmjgca+mtQu4WczCaApNaSuVqgb8u7Bd9GCOL4YJotvV5+81frlSwQXralhwRzGhj/A57CGPgGKiuPT+AOGmykIGEZsSD9RKkyoKIoc0OS8CPIzdBOtTQCIwrLn2FxI83Clcg55W8gkFSOS6rWNbG5qFZWMll6yl02HtunalHmUlRUL66YeGXdMDC2PuRcmZbGO5a/2tbVppW6mfSWG3NPRpgwIDAQAB",
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

    let token = getCCToken();

    const formData = new FormData(form);
     formData.append('encrypted', token);

    fetch('/model/checkout', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            //console.log(data);
            if ( data.status === 'PAID') {
                window.location.href='/model/success';
            } else {
                window.location.href='/model/error';
            }
            // Process response from PHP file
        })
        .catch(error => {
            //console.error(error);
            // Handle error
        });
});
