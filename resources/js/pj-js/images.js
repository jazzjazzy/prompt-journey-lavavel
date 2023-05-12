$(document).ready(function () {

    // Your SortableJS initialization code goes here.
    let inputImageFields = document.getElementById('input-image-fields');
    if (inputImageFields) {
        new Sortable(inputImageFields, {
            handle: '.handle',
            direction: 'vertical',
            animation: 150,
            onEnd: function (/**Event*/evt) {
                updatePromptText();
            }
        });
    }

    function addImageRow() {

        //count the number images input fields to create a id for the new one
        let id = $('#input-image-fields').find('.images-input').length + 1;

        //check if #project_id is set and create a route
        let route = '/image';
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

    $('#input-image-fields').on('click', '.images-add', function () {
        updatePromptText();
        var parentDiv = $(this).closest('.flex');
        var input = parentDiv.find('.images-input');
        input.prop('disabled', !input.prop('disabled')); // toggle the disabled attribute
        if (input.prop('disabled')) {
            input.removeClass('text-gray-900');
            input.addClass('text-gray-300');
        } else {
            input.removeClass('text-gray-300');
            input.addClass('text-gray-900');
        }
    });

    $('.add-images').click(function () {
        addImageRow();
    });


    /**
     * This will create the dynamic image row for Images Links
     *
     * @param rowId - is the row that this image currenly is in the list
     * @param route - if we need to display a free image modal or paid image model
     * @param value - the link to the image
     * @param imageId - the image id if we get the image from gallery
     * @returns {string} new row image to append to the #input-image-fields div
     */
    function createDynamicImagesRow(rowId, route, value = '', imageId = null, checked = null) {

        var imageIdData = '';
        if (imageId !== null) {
            var imageIdData = 'data-image-id=' + imageId;
        }
        checkedData = '';
        if (checked === true) {
            var checkedData = 'checked';
        }

        return '<div class="flex mt-2">\n' +
            '                        <span class="handle my-auto cursor-grab">&#9776;</span>' +
            '                        <div class="flex-none px-3">\n' +
            '                            <input type="checkbox" name="imagesAdd-' + rowId + '" id="images-add-' + rowId + '" class="images-add" ' + checkedData + '>\n' +
            '                        </div>\n' +
            '                        <div class="grow">\n' +
            '                            <input type="text" name="images-' + rowId + '" id="images-input-' + rowId + '" autocomplete="off" ' +
            '                                   value="' + value + '" ' +
            '                                       class="images-input disabled:text-gray-400 disabled:border-green-700">\n' +
            '                        </div>\n' +
            '                        <div class="flex-none px-3">\n' +
            '                            <button id="row-view-image-' + rowId + '" class="icon-button show-image" title="View images" data-modal-size="lg" data-url="' + route + '"' +
            '                             ' + imageIdData + '>\n' +
            '                                <i class="fas fa-image"></i>\n' +
            '                            </button>\n' +
            '                            <button id="row-copy-image-' + rowId + '" class="icon-button images-input-copy">\n' +
            '                                <i class="fas fa-copy"></i>\n' +
            '                            </button>\n' +
            '                            <button id="row-delete-image-' + rowId + '" class="icon-button images-input-delete">\n' +
            '                                <i class="fas fa-trash"></i>\n' +
            '                            </button>\n' +
            '                        </div>\n' +
            '                    </div>'

    }

    $('#input-image-fields').on('click', '.show-image', function () {
        var parentDiv = $(this).closest('.flex');
        var imgUrl = parentDiv.find('.images-input').val();
        const modal = $('#myModal');
        var rowId = $(this).attr('id').replace('row-view-image-', '');

        if (!imgUrl) {
            return
        }
        ;

        let url = '';

        let imageId = $(this).attr('data-image-id');
        // if we have a imageId then get info from gallery else get info from url
        if (imageId) {
            url = $(this).attr('data-url');
        } else {
            url = $(this).attr('data-url') + '?' + createQueryStringFromUrl(imgUrl);
            if (rowId) {
                url += '&rowId=' + rowId;
            }

        }


        $('#myModal .overlay .card').addClass('w-1/2 h-3/4');

        const title = $(this).attr('title');
        const modalIframe = $('#modal-iframe');
        $('#modal-title').text(title);

        // set the iframe src to the url
        modalIframe.attr('src', url);

        // set the image src to the image url
        const image = modalIframe.contents().find('#image-preview');
        image.attr('src', imgUrl);

        // set the row id to the iframe so we can get it when we save the image and update the input field
        modalIframe.off('load').on('load', function () {
            const iframe = modalIframe[0].contentWindow.document;
            const buttonId = $(this).attr('id');
            $(iframe).find('#row-id').data('row-image-id', buttonId);
        });
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
        deleteImageRow($(this));
        imageNoticeAlert('#images-notice', 'Image link Image deleted');
    });

    function deleteImageRow(rowElemen) {
        const parentDiv = rowElemen.closest('.flex');

        if (window.parent.$('#input-image-fields .flex').length > 1) {
            parentDiv.remove();
        } else {
            parentDiv.remove();
            let route = '/image';
            //add a route to images modal for paid accounts if they have a projectId
            if (window.parent.$('#projectId').val() !== undefined) {
                route += '/' + window.parent.$('#projectId').val();
            }
            let inputField = $(createDynamicImagesRow(1, route, '', null, null));
            window.parent.$('#input-image-fields').append(inputField);
        }
        return;
    }


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
                if (imageId) {
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
        let rowId = inputFields.length + 1;

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
            let inputField = $(createDynamicImagesRow(rowId, route, url, imageId));
            window.parent.$('#input-image-fields').append(inputField);
        }

        setCheckmarkGalleryImages();
    }

    function removeFromImageList(id) {
        var inputFields = window.parent.$('#input-image-fields').find('.images-input');
        let imageId = id.split('-')[1];

        // Find the first empty input field
        inputFields.each(function () {

            let dataImageId = $(this).parent().parent().find('.show-image').attr('data-image-id');
            let showimage = $(this).parent().parent().find('.images-input-delete');
            if (dataImageId === imageId) {
                deleteImageRow(showimage);
                setCheckmarkGalleryImages();
            }

        });
    }

    /**
     * find all the ids for images used in the dashboard
     * @returns {*[]}
     */
    function getImageIds() {
        let imageIds = [];
        //find all the ids for images used in the dashboard
        window.parent.$('#input-image-fields').find('.show-image').each(function () {
            let imageId = 'image-' + $(this).attr('data-image-id');

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
        $(window.document).find('.modal #gallery-images a').each(function () {
            var id = $(this).attr('id');

            if (imageIds.indexOf(id) >= 0) {
                let checkMark = $(this).children('div').children('i.fa-circle-check');
                $(this).attr('data-in-image-list', true);
                checkMark.show();
            } else {
                let checkMark = $(this).children('div').children('i.fa-circle-check');
                $(this).attr('data-in-image-list', false);
                checkMark.hide();
            }
        });
    }

    function addImagesFromPromptHistory(imagesHistory) {

        if (!$.isArray(imagesHistory)) {
            imagesHistory = JSON.parse(imagesHistory);
        }

        //todo: add a route to suffix modal for paid accounts if they have a projectId
        let route = '/image';
        //add a route to images modal for paid accounts if they have a projectId
        if (window.parent.$('#projectId').val() !== undefined) {
            route += '/' + window.parent.$('#projectId').val();
        }
        $('#input-image-fields').empty();
        if (imagesHistory === null || imagesHistory.length === 0) {
            let inputField = $(createDynamicImagesRow(1, route, '', null, null));
            window.parent.$('#input-image-fields').append(inputField);
        } else {
            $.each(imagesHistory, function (index, images) {
                let inputField = $(createDynamicImagesRow(index, route, images['input'], null, images['add']));
                window.parent.$('#input-image-fields').append(inputField);
            });
        }
    }

    function removeAllImages() {
        $('#input-image-fields').empty();
        let inputField = createDynamicImagesRow(1, '/image', '', null, false);
        window.parent.$('#input-image-fields').append(inputField);
    }

    function createQueryStringFromUrl(url) {
        // Break down the URL
        var a = document.createElement('a');
        a.href = url;

        // Extract the components of the URL
        var scheme = a.protocol.replace(':', '');
        var host = a.hostname;
        var dirname = a.pathname.split('/').slice(0, -1).join('/');
        var file = a.pathname.split('/').pop();
        var ext = file.split('.').pop();
        file = file.replace('.' + ext, '');

        // Create an object with the URL components
        var urlObj = {
            'scheme': scheme,
            'host': host,
            'dirname': dirname,
            'file': file,
            'ext': ext
        };

        // Encode the values of the object properties
        for (var prop in urlObj) {
            if (urlObj.hasOwnProperty(prop)) {
                urlObj[prop] = encodeURIComponent(urlObj[prop]);
            }
        }

        // Convert the object to a query string
        var queryString = Object.keys(urlObj).map(function (key) {
            return key + '=' + urlObj[key];
        }).join('&');

        return queryString;
    }

    $.extend(window, {
        getImagePromptText: getImagePromptText,
        imageNoticeAlert: imageNoticeAlert,
        addToImageList: addToImageList,
        removeFromImageList: removeFromImageList,
        setCheckmarkGalleryImages: setCheckmarkGalleryImages,
        addImagesFromPromptHistory: addImagesFromPromptHistory,
        removeAllImages: removeAllImages
    });
});
