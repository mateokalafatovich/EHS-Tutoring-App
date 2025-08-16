document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('tutor-search-form');
    const inputs = form.querySelectorAll('select');

    // Restore form values from sessionStorage
    inputs.forEach(input => {
        const savedValue = sessionStorage.getItem(input.id);
        if (savedValue) {
            input.value = savedValue;
        }

        // Save input values on change
        input.addEventListener('change', () => {
            sessionStorage.setItem(input.id, input.value);
        });
    });

    // Clear sessionStorage on form reset
    form.addEventListener('reset', () => {
        inputs.forEach(input => {
            sessionStorage.removeItem(input.id);
        });
    });
});