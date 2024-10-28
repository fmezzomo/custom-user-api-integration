document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.getElementById('add-preference');
    const preferencesContainer = document.getElementById('preferences-container');

    addButton.addEventListener('click', function() {
        const newPreferenceDiv = document.createElement('div');
        newPreferenceDiv.classList.add('preference-field');
        newPreferenceDiv.innerHTML = `
            <input type="text" name="user_preferences[]" required>
            <button type="button" class="remove-preference">Remove</button>
        `;
        preferencesContainer.appendChild(newPreferenceDiv);
    });

    preferencesContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-preference')) {
            event.target.parentElement.remove();
        }
    });

    const form = preferencesContainer.closest('form');
    form.addEventListener('submit', function(e) {
        const preferenceFields = document.querySelectorAll('input[name="user_preferences[]"]');
        let valid = true;

        preferenceFields.forEach(field => {
            if (!/^[a-zA-Z0-9]+$/.test(field.value)) {
                valid = false;
                field.setCustomValidity('Please enter only alphanumeric characters.');
                field.reportValidity();
            } else {
                field.setCustomValidity('');
            }
        });

        if (!valid) {
            e.preventDefault();
        }
    });
});
