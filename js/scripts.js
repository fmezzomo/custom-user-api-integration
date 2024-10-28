document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.getElementById('add-preference');
    const preferencesContainer = document.getElementById('preferences-container');

    function addPreferenceField(value = '') {
        const newPreferenceDiv = document.createElement('div');
        newPreferenceDiv.classList.add('preference-field');
        newPreferenceDiv.innerHTML = `
            <input type="text" name="user_preferences[]" value="${value}" required>
            <button type="button" class="remove-preference">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 6H5H21" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6V20C19 20.5523 18.5523 21 18 21H6C5.44772 21 5 20.5523 5 20V6H19Z" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        `;
        preferencesContainer.appendChild(newPreferenceDiv);
    }

    addButton.addEventListener('click', function() {
        addPreferenceField();
    });

    preferencesContainer.addEventListener('click', function(event) {
        if (event.target.closest('.remove-preference')) {
            event.target.closest('.preference-field').remove();
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
