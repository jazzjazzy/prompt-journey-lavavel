$(document).ready(function () {
    /**
     * Add a new suffix row
     */
    function addCheckboxes() {
        // add the checkboxes to the #input-suffix-fields div
        $('#input-suffix-fields').append(
            createDynamicSuffixRow()
        );
    }

    /**
     * Add a new suffix row
     */
    $('#add-to-suffix-list').on('click', function () {
        addToSuffixList();
    });

    function addToSuffixList() {
        var inputFields = $('#input-suffix-fields').find('.suffix-input');
        var added = false;

        let promptText = getPromptText();
        // Find the first empty input field
        inputFields.each(function () {
            if ($(this).val() === '') {
                $(this).val(promptText);
                added = true;
                return false;
            }
        });

        // If no empty input field is found, add a new one
        if (!added) {
            let inputField = $(createDynamicSuffixRow(promptText));
            $('#input-suffix-fields').append(inputField);
        }
    }

    function createDynamicSuffixRow(input = '') {
        return ' <div class="flex mt-2">\n' +
            '                            <div class="flex-none px-3">\n' +
            '                                <input type="checkbox" name="suffixAdd[]" class="suffix-add">\n' +
            '                            </div>\n' +
            '                            <div class="grow">\n' +
            '                                <input type="text" name="suffix[]" class="suffix-input disabled:text-gray-400" value="' + input + '">\n' +
            '                            </div>\n' +
            '                            <div class="flex-none px-3">\n' +
            '                                <button class="icon-button suffix-input-copy">\n' +
            '                                    <i class="fas fa-copy"></i>\n' +
            '                                </button>\n' +
            '                                <button class="icon-button suffix-input-delete">\n' +
            '                                    <i class="fas fa-trash"></i>\n' +
            '                                </button\n' +
            '                            </div>\n' +
            '                        </div>'

    }


    /**
     * Add the suffix input value to the prompt text
     */
    // attach a click event handler to the .suffix-add checkboxes
    $('#input-suffix-fields').on('click', '.suffix-add', function () {
        // get the parent div of the clicked checkbox
        var parentDiv = $(this).closest('.flex').find('.suffix-input');

        // check if the checkbox is checked
        if ($(this).is(':checked')) {
            // get the value of the corresponding .suffix-input field
            var inputVal = parentDiv.val();
            parentDiv.prop('disabled', true);
            // append the value to the #prompt text
            console.log($('#prompt').val());
            if ($('#prompt').val() !== '') {
                $('#prompt').val($.trim($('#prompt').val()) + ' ' + inputVal);
            } else {
                $('#prompt').val(inputVal);
            }
        } else {
            // get the value of the corresponding .suffix-input field
            var inputVal = parentDiv.val();
            parentDiv.prop('disabled', false);
            // remove the value from the #prompt text
            $('#prompt').val($('#prompt').val().replace(inputVal, ''));
        }
    });

    /**
     * Copy the suffix input value to the clipboard
     */
    $('#input-suffix-fields').on('click', '.suffix-input-copy', function () {
        var parentDiv = $(this).closest('.flex').find('.suffix-input');
        ;

        var inputVal = parentDiv.val();
        if (inputVal !== '') {
            navigator.clipboard.writeText(inputVal);
        }
        suffixNoticeAlert('#suffix-notice', 'Suffix copied to clipboard');
    });

    /**
     * Delete the suffix input value and uncheck the checkbox
     */
    $('#input-suffix-fields').on('click', '.suffix-input-delete', function () {
        var parentDiv = $(this).closest('.flex');
        let suffixInput = parentDiv.find('.suffix-input');
        let suffixAdd = parentDiv.find('.suffix-add');

        if ($('#input-suffix-fields .flex').length > 1) {
            parentDiv.remove();
        } else {
            suffixInput.val('');
            suffixInput.prop('disabled', false);
            suffixAdd.prop("checked", false);
        }

        suffixNoticeAlert('#suffix-notice', 'Suffix string deleted');

    });

    function suffixNoticeAlert(paramId, massage) {
        $(paramId).text(massage);
        // Slide the div from left to right
        $(paramId).fadeIn(1000);

        // Wait for 3 seconds before sliding the div from right to left
        setTimeout(function () {
            $(paramId).fadeOut(1000);
        }, 3000);
    }

    $('.add-suffix').click(function () {
        addCheckboxes();
    });

    function getSuffixPromptText() {
        let suffixText = '';
        // if field is not empty, add it to the suffixText
        $('#input-suffix-fields').children('div').each(function () {

            let $suffixValue = $(this).find('.suffix-input').val();
            let $suffixAdd = $(this).find('.suffix-add').is(':checked');

            if ($suffixAdd && $suffixValue !== '') {
                suffixText += $suffixValue + ' ';
            }
        });
        return suffixText;
    }

    function setPromptWithSuffixText() {
        let suffixText = getSuffixPromptText();
        $('#prompt').val($('#prompt').val() + ' ' + suffixText);
    }

    $.extend(window, {
        setPromptWithSuffixText: setPromptWithSuffixText,
        addToSuffixList: addToSuffixList,
        getSuffixPromptText:getSuffixPromptText
    });

});
