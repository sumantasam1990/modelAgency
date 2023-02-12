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
        rightBox.classList.remove('hidden');
    } else {
        starContainer.classList.add('hidden');
        rightBox.classList.add('hidden');
    }

    previousPosition = currentPosition;
});


