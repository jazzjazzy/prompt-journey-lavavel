$(document).ready(function () {

    // Your SortableJS initialization code goes here.
    let inputSuffixFields = document.getElementById('input-suffix-fields');
    if (inputSuffixFields) {
        new Sortable(inputSuffixFields, {
            handle: '.handle',
            direction: 'vertical',
            animation: 150,
            onEnd: function (/**Event*/evt) {
                updatePromptText();
            }
        });
    }

    /**
     * Add a new suffix row
     */
    function addNewSuffixRow() {
        // add the checkboxes to the #input-suffix-fields div
        var inputFields = $('#input-suffix-fields').find('.suffix-input');

        let id = inputFields.length + 1;

        let route = '';
        if ($('#projectId').val() !== undefined) {
            route = '/suffix/' + $('#projectId').val();
        }

        $('#input-suffix-fields').append(
            createDynamicSuffixRow(id, route)
        );
    }

    /**
     * Add a new suffix row
     */
    $('#add-to-suffix-list').on('click', function () {
        addToSuffixList(true);
    });

    $('#pramas-to-suffix-list').on('click', function () {
        addToSuffixList();
    });

    function allToSuffixList(withPrompt = false) {
        addToSuffixList(true);
    }

    function paramsToSuffixList(withPrompt = false) {
        addToSuffixList();
    }

    function addToSuffixList(withPrompt = false) {
        var inputFields = $('#input-suffix-fields').find('.suffix-input');
        var added = false;
        let promptText;

        if (withPrompt) {
            promptText = getPromptText();
        } else {
            promptText = getPramaText();
        }

        // Find the first empty input field
        inputFields.each(function () {
            if ($(this).val() === '') {
                $(this).val(promptText);
                added = true;
                return false;
            }
        });
        let id = inputFields.length + 1;
        // If no empty input field is found, add a new one
        if (!added) {
            let inputField = $(createDynamicSuffixRow(id, '', promptText));
            $('#input-suffix-fields').append(inputField);
        }
    }

    function createDynamicSuffixRow(rowId, route, value = '', suffixId = null, checked = null) {

        var suffixIdData = '';
        if (suffixId !== null) {
            var suffixIdData = 'data-suffix-id=' + suffixId;
        }

        checkedData = '';
        if (checked === true || checked === 'true') {
            var checkedData = 'checked';
        }


        // need to setup the route for new suffix to the price modal if user does not have access
        let viewSuffixIconClass = 'icon-button show-suffix';
        let modelSize = 'sm';
        // if the user has access to the suffix then is-suffix will be set
        if ($('#is-suffix').length) {
            //change the route to the price modal
            route = $('#is-suffix').val();
            viewSuffixIconClass = 'open-modal icon-button-disabled show-suffix';
            modelSize = 'xl';
        }

        return ' <div class="flex mt-2">' +
            '                            <span class="handle my-auto cursor-grab">&#9776;</span>' +
            '                            <div class="flex-none px-3">\n' +
            '                                <input type="checkbox" name="suffixAdd-' + rowId + '" id="suffix-add-' + rowId + '" class="suffix-add" ' + checkedData + '>\n' +
            '                            </div>\n' +
            '                            <div class="grow">\n' +
            '                                <input type="text" name="suffix-' + rowId + '" id="suffix-input-' + rowId + '" autocomplete="off" ' +
            '                                   class="suffix-input disabled:text-gray-400 disabled:border-green-700" value="' + value.trim() + '">\n' +
            '                            </div>\n' +
            '                            <div class="flex-none px-3">\n' +
            '                               <button id="row-view-suffix-' + rowId + '" class="'+viewSuffixIconClass+'" title="View Suffix" data-modal-size="'+modelSize+'" data-url="' + route + '" \n' +
            '                                  ' + suffixIdData + '>\n' +
            '                                    <i class="fa-sharp fa-solid fa-align-right"></i>\n' +
            '                                </button>\n' +
            '                                <button id="row-copy-suffix-' + rowId + '" class="icon-button suffix-input-copy">\n' +
            '                                    <i class="fas fa-copy"></i>\n' +
            '                                </button>\n' +
            '                                <button id="row-delete-suffix-' + rowId + '" class="icon-button suffix-input-delete">\n' +
            '                                    <i class="fas fa-trash"></i>\n' +
            '                                </button\n' +
            '                            </div>\n' +
            '                        </div>';

    }

    $('#input-suffix-fields').on('click', '.show-suffix', function () {
        var parentDiv = $(this).closest('.flex');
        var suffixText = parentDiv.find('.suffix-input').val();
        const modal = $('#myModal');
        var rowId = $(this).attr('id').replace('row-view-suffix-', '');

        if (suffixText == "" || suffixText == null || suffixText == undefined) {
            return
        }

        // if the suffix is from gallery
        var suffixId = $(this).attr('data-suffix-id');

        let url = '';
        // if we have a suffixId then get info from gallery else get info from url
        if (suffixId) {
            url = $(this).attr('data-url')+ '/' + suffixId;
        } else {
            url = $(this).attr('data-url') + '?suffix=' + encodeURIComponent(suffixText);
            if (rowId) {
                url += '&rowId=' + rowId;
            }
        }

        $('#myModal .overlay .card').addClass('w-1/2 h-1/2');

        const title = $(this).attr('title');
        const modalIframe = $('#modal-iframe');
        $('#modal-title').text(title);
        modalIframe.attr('src', url);

        // Add a 'load' event listener for the iframe
        modalIframe.off('load').on('load', function() {
            const iframe = modalIframe[0].contentWindow.document;
            const buttonId = $(this).attr('id');
            $(iframe).find('#row-id').data('row-suffix-id', buttonId);
        });

        modal.css('display', 'block');
        /*modalIframe.on('load', function() {
            const suffix = modalIframe.contents().find('#row-id');
            suffix.data('row-id', rowId);
            console.log(suffix.data('row-id'), 'jason2');

        });*/

    });

    /**
     * Add the suffix input value to the prompt text
     */
    // attach a click event handler to the .suffix-add checkboxes
    $('#input-suffix-fields').on('click', '.suffix-add', function () {
        updatePromptText();
        var parentDiv = $(this).closest('.flex');
        var input = parentDiv.find('.suffix-input');
        input.prop('disabled', !input.prop('disabled')); // toggle the disabled attribute
        if (input.prop('disabled')) {
            input.removeClass('text-gray-900');
            input.addClass('text-gray-300');
        } else {
            input.removeClass('text-gray-300');
            input.addClass('text-gray-900');
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

        deleteSuffixRow($(this));
        suffixNoticeAlert('#suffix-notice', 'Suffix string deleted');

    });

    function deleteSuffixRow(rowElemen) {
        var parentDiv = rowElemen.closest('.flex');

        if (window.parent.$('#input-suffix-fields .flex').length > 1) {
            parentDiv.remove();
        } else {
            parentDiv.remove();
            let route = '/suffix';
            if (window.parent.$('#projectId').val() !== undefined) {
                route += '/' + window.parent.$('#projectId').val();
            }
            let inputField = $(createDynamicSuffixRow(1, route, '', null, null));
            window.parent.$('#input-suffix-fields').append(inputField);
        }
        return;
    }

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
        addNewSuffixRow();
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

    function addToSuffixList(suffixStr = null, id) {
        var inputFields = window.parent.$('#input-suffix-fields').find('.suffix-input');
        var added = false;
        let suffixId = id.split('-')[1];

        // Find the first empty input field
        inputFields.each(function () {
            if ($(this).val() === '') {
                //add suffix to the input field
                $(this).val(suffixStr);
                if (suffixId) {
                    let showsuffix = $(this).parent().parent().find('.show-suffix');
                    //if we have a suffixId the add it to data-suffix-id
                    showsuffix.attr('data-suffix-id', suffixId);
                    //and also add it to the route
                    let route = showsuffix.attr('data-url');
                    showsuffix.attr('data-url', route);
                }
                added = true;
                return false;
            }
        });
        let rowid = inputFields.length + 1;

        //todo: add a route to suffix modal for paid accounts if they have a projectId
        //if route is empty with show use the input url to show the suffix in a modal
        let route = '/suffix';
        //add a route to suffix modal for paid accounts if they have a projectId
        if (window.parent.$('#projectId').val() !== undefined) {
            route += '/' + window.parent.$('#projectId').val();
        }

        if (!added) {
            let inputField = $(createDynamicSuffixRow(rowid, route, suffixStr, suffixId));
            window.parent.$('#input-suffix-fields').append(inputField);
        }

        setCheckmarkListSuffix();
    }

    function removeFromSuffixList(id) {
        var inputFields = window.parent.$('#input-suffix-fields').find('.suffix-input');
        let suffixId = id.split('-')[1];

        // Find the first empty input field
        inputFields.each(function () {

            let dataSuffixId = $(this).parent().parent().find('.show-suffix').attr('data-suffix-id');
            let showSuffix = $(this).parent().parent().find('.suffix-input-delete');
            if (dataSuffixId === suffixId) {
                deleteSuffixRow(showSuffix);
                setCheckmarkListSuffix();
            }

        });
    }

    /**
     * find all the ids for images used in the dashboard
     * @returns {*[]}
     */
    function getSuffixIds() {
        let suffixIds = [];
        //find all the ids for suffixs used in the dashboard
        window.parent.$('#input-suffix-fields').find('.show-suffix').each(function () {
            let suffixId = 'suffix-' + $(this).attr('data-suffix-id');

            if (suffixId !== undefined) {
                suffixIds.push(suffixId);
            }
        });
        return suffixIds;
    }

    /**
     * Add a checkmark to suffixs that are currently on the dashboard
     */
    function setCheckmarkListSuffix() {

        //these are a list that are currently already select
        let suffixIds = getSuffixIds();

        //find a list of all visable suffixs in the modal
        // var visableSuffix = [];
        $(window.document).find('.modal #gallery-suffixes a').each(function () {
            var id = $(this).attr('id');

            if (suffixIds.indexOf(id) >= 0) {
                let checkMark = $(this).children('div').children('i.fa-circle-check');
                $(this).attr('data-in-suffix-list', true);
                checkMark.show();
            }else {
                let checkMark = $(this).children('div').children('i.fa-circle-check');
                $(this).attr('data-in-suffix-list', false);
                checkMark.hide();
            }
        });
    }

    function addSuffixFromPromptHistory(suffixHistory) {

        if (!$.isArray(suffixHistory)) {
            suffixHistory = JSON.parse(suffixHistory);
        }

        //todo: add a route to suffix modal for paid accounts if they have a projectId
        let route = '/suffix';
        //add a route to suffix modal for paid accounts if they have a projectId
        if (window.parent.$('#projectId').val() !== undefined) {
            route += '/' + window.parent.$('#projectId').val();
        }

        $('#input-suffix-fields').empty();
        if (suffixHistory === null || suffixHistory.length === 0) {
            let inputField = $(createDynamicSuffixRow(1, route, '', null, null));
            window.parent.$('#input-suffix-fields').append(inputField);
        } else {
            $.each(suffixHistory, function (index, suffix) {
                let inputField = $(createDynamicSuffixRow(index, route, suffix['input'], null, suffix['add']));
                window.parent.$('#input-suffix-fields').append(inputField);
            });
        }

    }

    function removeAllSuffix() {
        $('#input-suffix-fields').empty();
        let inputField = createDynamicSuffixRow(1, '/suffix', '', null, false);
        window.parent.$('#input-suffix-fields').append(inputField);
    }

    $.extend(window, {
        allToSuffixList: allToSuffixList,
        paramsToSuffixList: paramsToSuffixList,
        suffixNoticeAlert: suffixNoticeAlert,
        addToSuffixList: addToSuffixList,
        removeFromSuffixList:removeFromSuffixList,
        getSuffixPromptText: getSuffixPromptText,
        setCheckmarkListSuffix: setCheckmarkListSuffix,
        addSuffixFromPromptHistory: addSuffixFromPromptHistory,
        removeAllSuffix: removeAllSuffix
    });

});
