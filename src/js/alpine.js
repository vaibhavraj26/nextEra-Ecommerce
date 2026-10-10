document.addEventListener('DOMContentLoaded', () => {
    // Example of a simple Alpine.js component for toggling a modal
    Alpine.data('modal', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
        }
    }));
    
    // Example of a simple Alpine.js component for form validation
    Alpine.data('formValidation', () => ({
        username: '',
        password: '',
        validate() {
            // Basic validation logic
            if (this.username === '' || this.password === '') {
                alert('Please fill in all fields.');
                return false;
            }
            return true;
        }
    }));
});