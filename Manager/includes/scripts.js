<script>
const form = document.getElementById('addStudentForm');
const inputs = form.querySelectorAll('input, select');
inputs.forEach(input => {
    input.addEventListener('input', () => {
        const errorSpan = document.getElementById(input.id + 'Error');
        if (input.checkValidity()) {
            errorSpan.textContent = '';
        } else {
            errorSpan.textContent = `Invalid input in ${input.id}`;
        }
    });
});
</script>

