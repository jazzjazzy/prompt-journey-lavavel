$(document).ready(function () {


    function addCheckboxes() {
        // add the checkboxes to the #input-image-fields div
        $('#input-image-fields').append(
            createDynamicImagesRow()
        );
    }

    $('#add-images').on('click', function () {
        var inputFields = $('#input-image-fields').find('.images-input');
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
            $('#input-image-fields').append(createDynamicImagesRow());
        }

    });


    // attach a click event handler to the .images-add checkboxes
    $('#input-image-fields').on('click', '.images-add', function () {
        // get the parent div of the clicked checkbox
        var parentDiv = $(this).closest('.flex');

        // check if the checkbox is checked
        if ($(this).is(':checked')) {
            // get the value of the corresponding .images-input field
            var inputVal = parentDiv.find('.images-input').val();
            parentDiv.find('.images-input').prop('disabled', true);
            // append the value to the #prompt text
            if ($('#prompt').val() !== '') {
                $('#prompt').val(inputVal + ' ' + $.trim($('#prompt').val()));
            } else {
                $('#prompt').val(inputVal);
            }
            ;
        } else {
            // get the value of the corresponding .images-input field
            var inputVal = parentDiv.find('.images-input').val();
            parentDiv.find('.images-input').prop('disabled', false);
            // remove the value from the #prompt text
            $('#prompt').val($('#prompt').val().replace(inputVal, ''));
        }
    });


    $('.add-images').click(function () {
        addCheckboxes();
    });


    function createDynamicImagesRow() {
        return '<div class="flex mt-2">\n' +
            '                        <div class="flex-none px-3">\n' +
            '                            <input type="checkbox" name="imagesAdd[]" class="images-add">\n' +
            '                        </div>\n' +
            '                        <div class="grow">\n' +
            '                            <input type="text" name="images[]" class="images-input disabled:text-gray-400">\n' +
            '                        </div>\n' +
            '                        <div class="flex-none px-3">\n' +
            '                            <button class="icon-button show-image">\n' +
            '                                <i class="fas fa-image"></i>\n' +
            '                            </button>\n' +
            '                            <button class="icon-button images-input-copy">\n' +
            '                                <i class="fas fa-copy"></i>\n' +
            '                            </button>\n' +
            '                            <button class="icon-button images-input-delete">\n' +
            '                                <i class="fas fa-trash"></i>\n' +
            '                            </button>\n' +
            '                        </div>\n' +
            '                    </div>'

    }

    $('#input-image-fields').on('click', '.show-image', function () {
        var parentDiv = $(this).closest('.flex');
        var imgUrl = parentDiv.find('.images-input').val();

        if (imgUrl) {
            var overlayHtml = '<div class="overlay">'
                + '<span class="close">&times;</span>'
                + '<img src="' + imgUrl + '">'
                + '</div>';
            $("#overlayContainer").html(overlayHtml);

            $(".overlay").click(function (event) {
                if ($(event.target).hasClass("overlay")) {
                    $(this).remove();
                }
            });

            $(".close").click(function () {
                $(this).parent().remove();
            });
        }
    });

    /**
     * Copy the suffix input value to the clipboard
     */
    $('#input-image-fields').on('click', '.images-input-copy', function () {
        var parentDiv = $(this).closest('.flex').find('.images-input');

        var inputVal = parentDiv.val();
        if (inputVal !== '') {
            navigator.clipboard.writeText(inputVal);
        }
        imageNoticeAlert('#images-notice', 'Image copied to clipboard');
    });

    /**
     * Delete the suffix input value and uncheck the checkbox
     */
    $('#input-image-fields').on('click', '.images-input-delete', function () {
        var parentDiv = $(this).closest('.flex');
        let imagesInput = parentDiv.find('.images-input');
        let imagesAdd = parentDiv.find('.images-add');

        if ($('#input-image-fields .flex').length > 1) {
            parentDiv.remove();
        } else {
            imagesInput.val('');
            imagesInput.prop('disabled', false);
            imagesAdd.prop("checked", false);
        }
        imageNoticeAlert('#images-notice', 'Image link Image deleted');
    });


    function imageNoticeAlert(paramId, massage) {
        $(paramId).text(massage);
        // Slide the div from left to right
        $(paramId).fadeIn(1000);

        // Wait for 3 seconds before sliding the div from right to left
        setTimeout(function () {
            $(paramId).fadeOut(1000);
        }, 3000);
    }

    function getImagePromptText() {
        let imagesText = '';
        // if field is not empty, add it to the imagesText
        $('#input-image-fields').children('div').each(function () {

            let $imagesValue = $(this).find('.images-input').val();
            let $imagesAdd = $(this).find('.images-add').is(':checked');

            if ($imagesAdd && $imagesValue !== '') {
                imagesText += $imagesValue + ' ';
            }
        });
        return imagesText;
    }


    function setPromptWithImagesText() {
        let ImagesText = getImagePromptText();
        $('#prompt').val( $.trim(ImagesText) + ' ' + $('#prompt').val());
    }

    $.extend(window, {
        setPromptWithImagesText: setPromptWithImagesText,
        getImagePromptText: getImagePromptText
    });


});
