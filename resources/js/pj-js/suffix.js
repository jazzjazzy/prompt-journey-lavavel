$(document).ready(function () {

    // Your SortableJS initialization code goes here.
    let inputSuffixFields = document.getElementById('input-suffix-fields');
    if(inputSuffixFields) {
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
    function addCheckboxes() {
        // add the checkboxes to the #input-suffix-fields div
        var inputFields = $('#input-suffix-fields').find('.suffix-input');

        let id = inputFields.length + 1;

        let route = '';
        if ($('#projectId').val() !== undefined) {
            route = '/suffix/' + $('#projectId').val();
        }

        $('#input-suffix-fields').append(
            createDynamicSuffixRow( id, route)
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

        if(withPrompt){
            promptText = getPromptText();
        }else{
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
            var suffixIdData = 'data-suffix-id='+ suffixId;
        }

        checkedData = '';
        if(checked === "true"){
            var checkedData = 'checked';
        }

        return ' <div class="flex mt-2">' +
            '                            <span class="handle my-auto cursor-grab">&#9776;</span>' +
            '                            <div class="flex-none px-3">\n' +
            '                                <input type="checkbox" name="suffixAdd-'+ rowId +'" id="suffix-add-'+ rowId +'" class="suffix-add" '+ checkedData +'>\n' +
            '                            </div>\n' +
            '                            <div class="grow">\n' +
            '                                <input type="text" name="suffix-'+ rowId +'" id="suffix-input-'+ rowId +'" autocomplete="off" ' +
            '                                   class="suffix-input disabled:text-gray-400 disabled:border-green-700" value="'+ value.trim() +'">\n' +
            '                            </div>\n' +
            '                            <div class="flex-none px-3">\n' +
            '                               <button class="icon-button show-suffix" title="View Suffix" data-modal-size="sm" data-url="' + route + '" \n' +
            '                                  ' + suffixIdData + '>\n'+
            '                                    <i class="fa-sharp fa-solid fa-align-right"></i>\n' +
            '                                </button>\n' +
            '                                <button class="icon-button suffix-input-copy">\n' +
            '                                    <i class="fas fa-copy"></i>\n' +
            '                                </button>\n' +
            '                                <button class="icon-button suffix-input-delete">\n' +
            '                                    <i class="fas fa-trash"></i>\n' +
            '                                </button\n' +
            '                            </div>\n' +
            '                        </div>'

    }

    $('#input-suffix-fields').on('click', '.show-suffix', function () {
        var parentDiv = $(this).closest('.flex');
        var suffixText = parentDiv.find('.suffix-input').val();
        const modal = $('#myModal');

        if(suffixText=="" || suffixText==null || suffixText==undefined){
            return
        }

        // if the suffix is from gallery
        var suffixId = $(this).attr('data-suffix-id');

        let url = '';
        // if we have a suffixId then get info from gallery else get info from url
        if (suffixId !== undefined && suffixId !== null && suffixId !== '') {
            url = $(this).attr('data-url');
        }else{
            url = $(this).attr('data-url') + '?suffix=' + encodeURIComponent(suffixText);
        }

        $('#myModal .overlay .card').addClass('w-1/2 h-1/2');

        const title = $(this).attr('title');
        const modalIframe = $('#modal-iframe');
        $('#modal-title').text(title);
        modalIframe.attr('src', url);
        const suffix = modalIframe.contents().find('#suffix-preview');
        suffix.attr('src', suffixText);
        modal.css('display', 'block');
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

    function addToSuffixModalList(url, id) {
        var inputFields = window.parent.$('#input-suffix-fields').find('.suffix-input');
        var added = false;
        let suffixId = id.split('-')[1];

        // Find the first empty input field
        inputFields.each(function () {
            if ($(this).val() === '') {
                $(this).val(url);
                if(suffixId) {
                    let showsuffix = $(this).parent().parent().find('.show-suffix');
                    //if we have a suffixId the add it to data-suffix-id
                    showsuffix.attr('data-suffix-id', suffixId);
                    //and also add it to the route
                    let route = showsuffix.attr('data-url');
                    showsuffix.attr('data-url', route + '/' + suffixId);
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
            if (suffixId !== undefined) {
                route += '/' + suffixId;
            }
        }

        if (!added) {
            let inputField = $(createDynamicSuffixRow( rowid, route, url, suffixId));
            window.parent.$('#input-suffix-fields').append(inputField);
        }

        setCheckmarkListSuffix();
    }

    /**
     * find all the ids for images used in the dashboard
     * @returns {*[]}
     */
    function getSuffixIds() {
        let suffixIds = [];
        //find all the ids for suffixs used in the dashboard
        window.parent.$('#input-suffix-fields').find('.show-suffix').each(function () {
            let suffixId = 'suffix-'+$(this).attr('data-suffix-id');

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
        $(window.document).find('.modal a').each(function() {
            var id = $(this).attr('id');

            if (suffixIds.indexOf(id) >= 0) {
                let checkMark = $(this).children('div').children('i.fa-circle-check');
                checkMark.show();
            }
        });
    }

    function addSuffixFromPromptHistory(suffixHistory) {

        //todo: add a route to suffix modal for paid accounts if they have a projectId
        let route = '/suffix';
        //add a route to suffix modal for paid accounts if they have a projectId
        if (window.parent.$('#projectId').val() !== undefined) {
            route += '/' + window.parent.$('#projectId').val();
        }
        console.log(suffixHistory);
        if(suffixHistory != null) {
            $('#input-suffix-fields').empty();
            $.each(suffixHistory, function(index, suffix) {
                let inputField = $(createDynamicSuffixRow(index, route, suffix['input'], null, suffix['add']));
                window.parent.$('#input-suffix-fields').append(inputField);
            });
        }
    }

    function removeAllSuffix() {
        $('#input-suffix-fields').empty();
        createDynamicSuffixRow(1, '/suffix', '', null, true);
    }

    $.extend(window, {
        allToSuffixList: allToSuffixList,
        paramsToSuffixList: paramsToSuffixList,
        suffixNoticeAlert: suffixNoticeAlert,
        addToSuffixModalList: addToSuffixModalList,
        getSuffixPromptText: getSuffixPromptText,
        setCheckmarkListSuffix: setCheckmarkListSuffix,
        addSuffixFromPromptHistory:addSuffixFromPromptHistory,
        removeAllSuffix: removeAllSuffix
    });

});
