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
