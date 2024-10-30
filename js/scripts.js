class PreferenceManager {
    constructor() {
        this.addButton = document.getElementById('add-preference');
        this.preferencesContainer = document.getElementById('preferences-container');
        this.form = this.preferencesContainer.closest('form');
        this.submitButton = this.form.querySelector('button[type="submit"]');

        this.addButton.addEventListener('click', () => this.addPreferenceField());
        this.preferencesContainer.addEventListener('click', (event) => this.removePreferenceField(event));
        this.form.addEventListener('submit', (e) => this.validateForm(e));

        this.preferencesContainer.addEventListener('input', () => this.updateButtonState());
    }

    initPreferences(preferences) {
        if (preferences.length === 0) {
            this.addPreferenceField();
        }

        preferences.forEach(preference => {
            this.addPreferenceField(preference);
        });
    }

    addPreferenceField(value = '') {
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
        this.preferencesContainer.appendChild(newPreferenceDiv);
    }

    removePreferenceField(event) {
        const removeButton = event.target.closest('.remove-preference');
        if (removeButton) {
            removeButton.closest('.preference-field').remove();
            this.updateButtonState();
        }
    }

    validateField(field) {
        const valid = /^[a-zA-Z0-9]+$/.test(field.value);
        field.setCustomValidity(valid ? '' : 'Please enter only alphanumeric characters.');
        return valid;
    }

    validateForm(e) {
        const preferenceFields = document.querySelectorAll('input[name="user_preferences[]"]');
        let allValid = true;

        preferenceFields.forEach(field => {
            if (!this.validateField(field)) {
                field.reportValidity();
                allValid = false;
            }
        });

        this.submitButton.disabled = !allValid;

        if (!allValid) {
            e.preventDefault();
        }
    }

    updateButtonState() {
        const preferenceFields = document.querySelectorAll('input[name="user_preferences[]"]');
        let allValid = Array.from(preferenceFields).every(field => this.validateField(field));
        this.submitButton.disabled = !allValid;
    }
}