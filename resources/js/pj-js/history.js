window.savedStrings = [];
window.currentIndex = window.savedStrings.length;

$(document).ready(function () {

    // Attach a 'click' event listener to the button
    $('#copyMjButton').on('click', function () {
        copyMjPrompt();
    });

    /**
     *
     */
    function copyMjPrompt() {
        // Get the value of the input field
        var promptText = $.trim($('#prompt').val());

        if (promptText !== '' && promptText !== null && promptText !== undefined) {
            // Copy the value to the clipboard
            navigator.clipboard.writeText("/imagine prompt: " + promptText);

            var nextIndex = window.savedStrings.length;

            let suffixArray = getExtendedValues('#input-suffix-fields', true);
            let imagesArray = getExtendedValues('#input-image-fields', true);

            promptText = stripStringFromPrompt(promptText, suffixArray);
            promptText = stripStringFromPrompt(promptText, imagesArray);

            let promptArray = {
                "promptText": promptText,
                "suffix": suffixArray,
                "images": imagesArray,
            };


            // Add the value to the array of saved strings
            window.savedStrings.push(promptArray);

            // add last 2 prompts to the pre prompt
            $('#pre-prompt-1').text(window.savedStrings[nextIndex] ? window.savedStrings[nextIndex].prompt : '');
            $('#pre-prompt-2').text(window.savedStrings[nextIndex - 1] ? window.savedStrings[nextIndex - 1].prompt : '');

            //change the currentIndex to the new prompt index
            window.currentIndex = window.savedStrings.length

            let projectId = $('#projectId').val();


            if (projectId !== null && projectId !== undefined && projectId !== '') {
                storeProjectHistory(projectId);
            } else {
                //show alert that the prompt was copied
                promptCopyNoticeAlert('#copy-mj-prompt', 'Prompt copied to clipboard');
            }
        }
        //console.log(window.savedStrings);
    }

    function storeProjectHistory(projectId) {

        let promptText = $('#prompt').val();

        let suffixArray = getExtendedValues('#input-suffix-fields', true);
        let imagesArray = getExtendedValues('#input-image-fields', true);

        promptText = stripStringFromPrompt(promptText, suffixArray);
        promptText = stripStringFromPrompt(promptText, imagesArray);

        let promptArray = {
            "promptText": promptText,
            "suffix": suffixArray,
            "images": imagesArray,
        };

        $.ajax({
            url: `/projects/${projectId}/prompt-history`, // Replace with actual project ID
            type: 'POST',
            data: promptArray,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    promptCopyNoticeAlert('#copy-mj-prompt', 'Prompt copied to account history');
                } else {
                    alert('Error adding prompt history.');
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred while adding prompt history.');
                console.log(error + ' ' + status + ' ' + xhr.responseText);
            }
        });
    }

    function retrieveProjectHistory() {
        let projectId = $('#projectId').val();

        $.ajax({
            url: `/projects/${projectId}/history`, // Replace with actual project ID
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    window.savedStrings = response.promptHistory;
                    window.currentIndex = window.savedStrings.length;
                    console.log(response.promptHistory);
                    // add last 2 prompts to the pre prompt
                    let nextIndex = window.currentIndex
                    $('#pre-prompt-1').text(window.savedStrings[nextIndex - 1] ? window.savedStrings[nextIndex - 1].prompt : '');
                    $('#pre-prompt-2').text(window.savedStrings[nextIndex - 2] ? window.savedStrings[nextIndex - 2].prompt : '');


                } else {
                    alert('Error adding prompt history.');
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred while adding prompt history.');
                console.log(error + ' ' + status + ' ' + xhr.responseText);
            }
        });
    }

    /**
     *
     * @param fieldId find the input fields in this div
     * @param allowFalse if true, will allow false values to be added to the object
     * @returns {{}}
     */
    function getExtendedValues(fieldId, allowFalse = false) {

        const result = [];

        $(fieldId + ' > .flex').each(function () {
            const addChecked = $(this).find('.images-add, .suffix-add').is(':checked');
            const inputText = $(this).find('.images-input, .suffix-input').val();

            if (inputText !== '') {
                result.push({
                    add: addChecked,
                    input: inputText
                });
            }
        });
        return result;
    }

    /**
     * this function will remove the suffix and images from the prompt text
     * @param promptText
     * @param obj
     * @returns {*}
     */
    function stripStringFromPrompt(promptText = '', arr = []) {
        if (typeof promptText !== 'string' || !Array.isArray(arr)) {
            return promptText;
        }

        arr.forEach((item) => {
            if (item.add === true) {
                promptText = promptText.replace(new RegExp(item.input, 'g'), '');
            }
        });

        return promptText.trim();
    }


    // Attach a 'keydown' event listener to the input field
    $(document).on('keydown', function (e) {
        if (e.keyCode === 38 || e.keyCode === 40) { // up or down arrow key
            e.preventDefault(); // stop default scrolling behavior

            // Calculate the index of the next or previous value
            var nextIndex = window.currentIndex + (event.keyCode === 38 ? -1 : 1);

            // Check if the index is within the bounds of the array
            if (nextIndex >= 0 && nextIndex < window.savedStrings.length) {
                // Update the current index
                window.currentIndex = nextIndex;

                // Clear the value of the input field
                $('#pre-prompt-2').text('');
                $('#pre-prompt-1').text('');
                $('#post-prompt-2').text('');
                $('#post-prompt-1').text('');
                // Set the value of the input field to the next or previous value
                $('#pre-prompt-2').text(window.savedStrings[nextIndex - 2] ? window.savedStrings[nextIndex - 2].prompt : '');
                $('#pre-prompt-1').text(window.savedStrings[nextIndex - 1] ? window.savedStrings[nextIndex - 1].prompt : '');

                $('#prompt').val(window.savedStrings[nextIndex].prompt);
                console.log(window.savedStrings)

                $('#post-prompt-1').text(window.savedStrings[nextIndex + 1] ? window.savedStrings[nextIndex + 1].prompt : '');
                $('#post-prompt-2').text(window.savedStrings[nextIndex + 2] ? window.savedStrings[nextIndex + 2].prompt : '');

                popluatePromptHistory(window.savedStrings[nextIndex].prompt, window.savedStrings[nextIndex].suffix, window.savedStrings[nextIndex].images);

            } else if (nextIndex == window.savedStrings.length) {
                // reset the current index
                window.currentIndex = window.savedStrings.length;
                // update the master prompt with the current prompt and params
                updatePromptText();
            }

            //console.log(window.currentIndex);
        }
    });

    function popluatePromptHistory(prompt, suffix, images) {

        $.clearAllPromptText();
        $('.prompt-text-class')[0].value = prompt + ' ';

        updatePromptAllFields();

        addSuffixFromPromptHistory(JSON.parse(suffix));
        addImagesFromPromptHistory(JSON.parse(images));
    }

    function promptCopyNoticeAlert(paramId, massage) {
        $(paramId).text(massage);
        // Slide the div from left to right
        $(paramId).fadeIn(1000);

        // Wait for 3 seconds before sliding the div from right to left
        setTimeout(function () {
            $(paramId).fadeOut(1000);
        }, 3000);
    }

    $("#show-history").click(function () {

        showHistory();
        let cardHeight = $('#overlayHistory .card').height();
        let cardHeaderHeight = $('#overlayHistory .card-header').height();
        let cardFooterHeight = $('#overlayHistory .card-footer').height();
        let viwportHeight = $(window).height();

        //
        if (cardHeight > viwportHeight) {
            cardHeight = (viwportHeight - 100);
            let container = (cardHeight - (cardHeaderHeight + cardFooterHeight));
            container = container - Math.floor(container * 0.1); //remove offset 10%
            $('#overlayHistory .card-body').attr('style', 'height: ' + container + 'px');
        }

    });

    function showHistory() {

        let historyList = [];
        let projectId = $('#projectId').val();

        if (projectId == null || projectId == undefined || projectId == '') {
            historyList = window.savedStrings;
        } else {
            historyList = getHistoryList(projectId);
        }

        let history = '<ul class="list-none mt-4 pl-8 divide-y divide-slate-400 overflow-auto">';
        console.log(historyList);

        if (historyList.length === 0) {
            history = history + '<li class="py-4 px-6 {{ $loop->last ? \'\' : \'border-b\' }}">\n' +
                '   <p class="text-gray-500 leading-tight">\n' + 'No history yet!' + '</p>\n' +
                '</li>'
        } else {
            for (let i = 0; i < historyList.length; i++) {
                history = history + '<li class="m-auto py-2 odd:bg-slate-50 even:bg-white">\n' +
                    '<div class="grid grid-cols-12 pt-1 m-auto px-12">\n' +
                    '    <div class="historyPrompt col-span-11 ">' + historyList[i].prompt + '</div>\n' +
                    '    <button class="copyFromHistroybtn col-span-1"> <i className="fas fa-copy"></i> </button>\n' +
                    '</div>\n' +
                    '</li>'
            }
        }

        history = history + '</ul>\n';


        $("#overlayContent").html(history);

        $("#overlayHistory").removeClass('hidden');
        $("#overlayHistory div i ").addClass('fas fa-copy');


        $(".overlay").click(function (event) {
            if ($(event.target).hasClass("overlay")) {
                $('#overlayHistory .card-body').attr('style', '');
                $("#overlayContent").html('');
                $("#overlayHistory").addClass('hidden');
            }
        });

        $(".close-btn").click(function () {
            $('#overlayHistory .card-body').attr('style', '');
            $("#overlayContent").html('');
            $("#overlayHistory").addClass('hidden');
        });
    };

    function getHistoryList(projectId) {
        let historyList = [];
        $.ajax({
            type: "GET",
            url: "/projects/" + projectId + "/history",
            async: false,
            success: function (data) {
                historyList = data.promptHistory;
            },
            error: function (response) {
                //if the is an error log it but send back window.savedStrings
                console.log(response);
                historyList = window.savedStrings;
            }
        });
        return historyList;
    }

    $("#clear-history").click(function () {

        let projectId = $('#projectId').val();

        if (projectId == null || projectId == undefined || projectId == '') {
            $('#overlayHistory .card-body').attr('style', '');
            $("#overlayContent").html('');
            $("#overlayHistory").addClass('hidden');
            $('#pre-prompt-2').text('');
            $('#pre-prompt-1').text('');
            $('#post-prompt-2').text('');
            $('#post-prompt-1').text('');
            window.savedStrings = [];
            window.currentIndex = 0;
            updatePromptText();
        } else {
            clearHistory(projectId);
        }
    });

    function clearHistory(projectId) {
        $.ajax({
            type: "GET",
            url: "/projects/" + projectId + "/clearHistory",
            async: false,
            success: function (data) {
                $('#overlayHistory .card-body').attr('style', '');
                $("#overlayContent").html('');
                $("#overlayHistory").addClass('hidden');
                $('#pre-prompt-2').text('');
                $('#pre-prompt-1').text('');
                $('#post-prompt-2').text('');
                $('#post-prompt-1').text('');
                window.savedStrings = [];
                window.currentIndex = 0;
                updatePromptText();
            },
            error: function (response) {
                //if the is an error log it but send back window.savedStrings
                console.log(response);
                $('#overlayHistory .card-body').attr('style', '');
                $("#overlayContent").html('');
                $("#overlayHistory").addClass('hidden');
                $('#pre-prompt-2').text('');
                $('#pre-prompt-1').text('');
                $('#post-prompt-2').text('');
                $('#post-prompt-1').text('');
                window.savedStrings = [];
                window.currentIndex = 0;
                updatePromptText();
            }
        });
    }

    $(document).on('click', '.copyFromHistroybtn', function () {
        let prompt = $(this).parent().find('.historyPrompt').text();
        navigator.clipboard.writeText("/imagine prompt: " + prompt);
    });

    $.extend(window, {
        updatePromptText: updatePromptText,
        showHistory: showHistory,
        copyMjPrompt: copyMjPrompt,
        retrieveProjectHistory: retrieveProjectHistory,
    })

});
