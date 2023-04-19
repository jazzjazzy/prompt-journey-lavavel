$(document).ready(function () {

    function addCheckboxes() {

        //count the number images input fields to create a id for the new one
        let id = $('#input-image-fields').find('.images-input').length + 1;

        //check if #project_id is set and create a route
        let route = '';
        if ($('#projectId').val() !== undefined) {
            route = '/image/' + $('#projectId').val();
        }

        // add the checkboxes to the #input-image-fields div
        $('#input-image-fields').append(
            createDynamicImagesRow(id, route)
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

        //count the number images input fields to create a id for the new one
        let id = inputFields.length + 1;

        // If no empty input field is found, add a new one
        if (!added) {
            $('#input-image-fields').append(createDynamicImagesRow(id));
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


    /**
     * This will create the dynamic image row for Images Links
     *
     * @param rowid - is the row that this image currenly is in the list
     * @param route - if we need to display a free image modal or paid image model
     * @param value - the link to the image
     * @param imageId - the image id if we get the image from gallery
     * @returns {string} new row image to append to the #input-image-fields div
     */
    function createDynamicImagesRow(rowid, route, value = '', imageId = null) {

        var imageIdData = '';
        if (imageId !== null) {
            var imageIdData = 'data-image-id='+ imageId;
        }

        return '<div class="flex mt-2">\n' +
            '                        <div class="flex-none px-3">\n' +
            '                            <input type="checkbox" name="imagesAdd-' + rowid + '" id="images-add-' + rowid + '" class="images-add">\n' +
            '                        </div>\n' +
            '                        <div class="grow">\n' +
            '                            <input type="text" name="images-' + rowid + '" id="images-input-' + rowid + '" '+
            '                                   value="'+ value +'" ' +
            '                                       class="images-input disabled:text-gray-400">\n' +
            '                        </div>\n' +
            '                        <div class="flex-none px-3">\n' +
            '                            <button class="icon-button show-image" title="View images" data-modal-size="lg" data-url="' + route + '"'+
            '                             '+ imageIdData +'>\n' +
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
        const modal = $('#myModal');

        // if the image is from gallery
        var imageId = $(this).attr('data-image-id');

        let url = '';
        // if we have a imageId then get info from gallery else get info from url
       if (imageId !== undefined && imageId !== null && imageId !== '') {
             url = $(this).attr('data-url');
        }else{
             url = $(this).attr('data-url') + '?image=' + encodeURIComponent(imgUrl);
        }

        $('#myModal .overlay .card').addClass('w-1/2 h-3/4');

        const title = $(this).attr('title');
        const modalIframe = $('#modal-iframe');
        $('#modal-title').text(title);
        modalIframe.attr('src', url);
        const image = modalIframe.contents().find('#image-preview');
        image.attr('src', imgUrl);
        modal.css('display', 'block');

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
        $('#prompt').val($.trim(ImagesText) + ' ' + $('#prompt').val());
    }

    function addToImageList(url, id) {
        var inputFields = window.parent.$('#input-image-fields').find('.images-input');
        var added = false;
        let imageId = id.split('-')[1];

        // Find the first empty input field
        inputFields.each(function () {
            if ($(this).val() === '') {
                $(this).val(url);
                if(imageId) {
                    let showimage = $(this).parent().parent().find('.show-image');
                    //if we have a imageId the add it to data-image-id
                    showimage.attr('data-image-id', imageId);
                    //and also add it to the route
                    let route = showimage.attr('data-url');
                    showimage.attr('data-url', route + '/' + imageId);
                }
                added = true;
                return false;
            }
        });
        let rowid = inputFields.length + 1;

        //if route is empty with show use the input url to show the image in a modal
        let route = '/image';
        //add a route to image modal for paid accounts if they have a projectId
        if (window.parent.$('#projectId').val() !== undefined) {
            route += '/' + window.parent.$('#projectId').val();
            if (imageId !== undefined) {
                route += '/' + imageId;
            }
        }

        if (!added) {
            let inputField = $(createDynamicImagesRow( rowid, route, url, imageId));
            window.parent.$('#input-image-fields').append(inputField);
        }

        setCheckmarkGalleryImages();
    }

    /**
     * find all the ids for images used in the dashboard
     * @returns {*[]}
     */
    function getImageIds() {
        let imageIds = [];
        //find all the ids for images used in the dashboard
        window.parent.$('#input-image-fields').find('.show-image').each(function () {
            let imageId = 'image-'+$(this).attr('data-image-id');

            if (imageId !== undefined) {
                imageIds.push(imageId);
            }
        });
        return imageIds;
    }

    /**
     * Add a checkmark to images that are currently on the dashboard
     */
    function setCheckmarkGalleryImages() {

        //these are a list that are currently already select
        let imageIds = getImageIds();

        //find a list of all visable images in the modal
       // var visableImage = [];
        $(window.document).find('.modal a').each(function() {
            var id = $(this).attr('id');

            if (imageIds.indexOf(id) >= 0) {
                let checkMark = $(this).children('div').children('i.fa-circle-check');
                checkMark.show();
            }
        });
    }


    $.extend(window, {
        getImagePromptText: getImagePromptText,
        imageNoticeAlert: imageNoticeAlert,
        addToImageList: addToImageList,
        setCheckmarkGalleryImages:setCheckmarkGalleryImages,
    });
});
