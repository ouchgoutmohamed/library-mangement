$(document).ready(function() {
    // Get the form elements
    const nameInput = $('#name');
    const emailInput = $('#email');
    const mobileInput = $('#no');
    const urlInput = $('#imgUrl');
    const saveButton = $('#save-btn');

    // Attach event listeners for input fields
    nameInput.on('input', function() {
        validateName();
        checkValidity();
    });
    emailInput.on('input', function() {
        validateEmail();
        checkValidity();
    });
    mobileInput.on('input', function() {
        validateMobile();
        checkValidity();
    });
    urlInput.on('input', function() {
        validateUrl();
        checkValidity();
    });

    // Validation functions
    function validateForm() {
        let error = '';
        if (!validateName()) {
            error += 'Name should contain only letters.<br>';
        }
        if (!validateEmail()) {
            error += 'Email should contain the @ symbol.<br>';
        }
        if (!validateMobile()) {
            error += 'Mobile number should be a 10-digit number.<br>';
        }
        if (!validateUrl()) {
            error += 'URL is not valid.<br>';
        }
        // resultDiv.html(error || 'Input data is correct.');
    }

    function validateName() {
        const name = nameInput.val();
        const nameErrorDiv = $('#nameErr');
        if (!/^[A-Za-z ]*$/.test(name)) {
            nameErrorDiv.html('Name should contain only letters.');
            nameErrorDiv.css("color", "red");
            return false;
        } else {
            nameErrorDiv.html('');
            return true;
        }
    }

    function validateEmail() {
        const email = emailInput.val();
        const emailErrorDiv = $('#emailErr');
        if (!/@/.test(email)) {
            emailErrorDiv.html('Email should contain the @ symbol.');
            emailErrorDiv.css("color", "red");
            return false;
        } else {
            emailErrorDiv.html('');
            return true;
        }
    }

    function validateMobile() {
        const mobile = mobileInput.val();
        const mobileErrorDiv = $('#noErr');
        if (!/^[0-9]*$/.test(mobile)) {
            mobileErrorDiv.html('Mobile number should contain only digits.');
            mobileErrorDiv.css("color", "red");
            return false;
        } else if (mobile.length !== 10) {
            mobileErrorDiv.html('Mobile number should be a 10-digit number.');
            mobileErrorDiv.css("color", "red");
            return false;
        } else {
            mobileErrorDiv.html('');
            return true;
        }
    }

    function validateUrl() {
        const url = urlInput.val();
        const urlErrorDiv = $('#urlErr');
        if (!/^(http|https):\/\/[^ "]+$/.test(url)) {
            urlErrorDiv.html('Please enter a valid URL starting with ftp://, http:// or https://');
            urlErrorDiv.css("color", "red");
            return false;
        } else {
            urlErrorDiv.html('');
            return true;
        }
    }

    function checkValidity() {
        if (validateName() && validateEmail() && validateMobile() && validateUrl()) {
            saveButton.prop('disabled', false);
        } else {
            saveButton.prop('disabled', true);
        }
    }
});
