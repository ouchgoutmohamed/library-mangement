$(document).ready(function() {
    // Get the form elements
    const isbnInput = $('#book-isbn');
    const editionInput = $('#edition');
    const priceInput = $('#price');
    const yearInput = $('#year');
    const publisherInput = $('#publisher');
    const imageInput = $('#url');
    const authorInput = $('#author');
    const mainCategorySelect = $('#category');
    const subCategorySelect = $('#sub-category');
    const saveButton = $('#save-btn');

    //set error msg to category selection
    // const CatValue = $("#category").val();
    // if (CatValue==""){
    //     validateMainCategory();
    //     checkValidity();
    // }
    //
    //set error msg to sub-category selection


    // Attach event listeners for input fields
    isbnInput.on('input', function () {
        validateIsbn();
        checkValidity();
    });
    // editionInput.on('input', function () {
    //     validateEdition();
    //     checkValidity();
    // });
    priceInput.on('input', function () {
        validatePrice();
        checkValidity();
    });
    yearInput.on('input', function () {
        validateYear();
        checkValidity();
    });
    publisherInput.on('input', function () {
        validatePublisher();
        checkValidity();
    });
    imageInput.on('input', function () {
        validateImage();
        checkValidity();
    });
    authorInput.on('input', function () {
        validateAuthor();
        checkValidity();
    });
    mainCategorySelect.on('change', function () {
        validateMainCategory();
        checkValidity();
        const subCategoryErrorDiv = $('#subCatErr');
        subCategoryErrorDiv.html('Please select a sub category.');
        subCategoryErrorDiv.css("color", "red");
        saveButton.prop('disabled', true);

    });
    subCategorySelect.on('change', function () {
        validateSubCategory();
        checkValidity();
    });



    function validateIsbn() {
        const isbn = isbnInput.val();
        const isbnErrorDiv = $('#isbnErr');
        // const formatIsbn = isbn.replace(/[^0-9X]/gi, '');
        if (!/^\d{10}$/.test(isbn) && !/^\d{13}$/.test(isbn)) {
            isbnErrorDiv.html('ISBN number should be in the 10-digit/13-digit format');
            isbnErrorDiv.css("color", "red");
            return false;
        }
            // else  if (/[^0-9-]/gi.test(isbn)) {
            //     isbnErrorDiv.html('ISBN cannot contain non-numeric characters.');
            //     isbnErrorDiv.css("color", "red");
            //     return false;
        // }
        else {
            isbnErrorDiv.html('');
            return true;
        }
    }

    // function validateEdition() {
    //     const edition = editionInput.val();
    //     const editionErrorDiv = $('#editionErr');
    //
    //     if (!/^[0-9]*$/.test(edition)) {
    //         editionErrorDiv.html('Edition should contain only digits.');
    //         editionErrorDiv.css("color", "red");
    //         return false;
    //     } else if (edition <= 0) {
    //         editionErrorDiv.html('Edition should be greater than zero.');
    //         editionErrorDiv.css("color", "red");
    //         return false;
    //     } else {
    //         editionErrorDiv.html('');
    //         return true;
    //     }
    // }

    function validatePrice() {
        const price = priceInput.val();
        const priceErrorDiv = $('#priceErr');
        const regex = /^\d{1,5}$/;
        if (price==0) {
            console.log("error")
            priceErrorDiv.html('Invalid Price');
            priceErrorDiv.css("color", "red");
            return false;
        } else {
            priceErrorDiv.html('');
            return true;
        }
    }

    function validateYear() {
        const year = yearInput.val();
        const yearErrorDiv = $('#yearErr');
        const currentYear = new Date().getFullYear();
        if (year < 1900 || year > currentYear) {
            yearErrorDiv.html('Published year should be between 1900 and ' + currentYear + '.');
            yearErrorDiv.css("color", "red");
            return false;
        } else {
            yearErrorDiv.html('');
            return true;
        }
    }

    function validatePublisher() {
        const publisher = publisherInput.val();
        const publisherErrorDiv = $('#publisherErr');
        if (!/^[A-Za-z ]*$/.test(publisher)) {
            publisherErrorDiv.html('Publisher should contain only letters.');
            publisherErrorDiv.css("color", "red");
            return false;
        } else {
            publisherErrorDiv.html('');
            return true;
        }
    }

    function validateImage() {
        const url = imageInput.val();
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

    function validateAuthor() {
        const author = authorInput.val();
        const authorErrorDiv = $('#authorErr');
        if (!/^[A-Za-z .,]*$/.test(author)) {
            authorErrorDiv.html('Author name should contain only letters.');
            authorErrorDiv.css("color", "red");
            return false;
        } else {
            authorErrorDiv.html('');
            return true;
        }
    }

    function validateMainCategory() {
        const mainCategory = mainCategorySelect.val();
        const mainCategoryErrorDiv = $('#catErr');


        // console.log(mainCategory);
        if (mainCategory === '') {
            mainCategoryErrorDiv.html('Please select a main category.');
            mainCategoryErrorDiv.css("color", "red");
            return false;
        } else {
            mainCategoryErrorDiv.html('');
            return true;
        }
    }

    function validateSubCategory() {
        const subCategory = subCategorySelect.val();
        const subCategoryErrorDiv = $('#subCatErr');
        if (subCategory === '') {
            subCategoryErrorDiv.html('Please select a sub category.');
            subCategoryErrorDiv.css("color", "red");
            return false;
        } else {
            subCategoryErrorDiv.html('');
            return true;
        }
    }

    function checkValidity() {
        if (validateIsbn() && validatePrice() && validateYear() && validatePublisher() && validateImage() && validateAuthor() && validateMainCategory() && validateSubCategory()) {
            saveButton.prop('disabled', false);
        } else {
            saveButton.prop('disabled', true);
        }
    }

});