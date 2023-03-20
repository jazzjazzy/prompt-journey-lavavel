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
        var inputVal = $('#prompt').val();
        // Copy the value to the clipboard
        navigator.clipboard.writeText("/imagine prompt: " + inputVal);

        var nextIndex = window.savedStrings.length;
        // Add the value to the array of saved strings
        window.savedStrings.push(inputVal);
        $('#pre-prompt-1').text(window.savedStrings[nextIndex]);
        $('#pre-prompt-2').text(window.savedStrings[nextIndex - 1]);
        window.currentIndex = window.savedStrings.length
        promptCopyNoticeAlert('#copy-mj-prompt', 'Prompt copied to clipboard');
        console.log(window.savedStrings);
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
                $('#pre-prompt-2').text(window.savedStrings[nextIndex - 2]);
                $('#pre-prompt-1').text(window.savedStrings[nextIndex - 1]);
                // Set the value of the input field to the next or previous value
                $('#prompt').val(window.savedStrings[nextIndex]);

                $('#post-prompt-1').text(window.savedStrings[nextIndex + 1]);
                $('#post-prompt-2').text(window.savedStrings[nextIndex + 2]);
            }
            else if(nextIndex == window.savedStrings.length)
            {
                // reset the current index
                window.currentIndex = window.savedStrings.length;
                // update the master prompt with the current prompt and params
                updatePromptText();
            }

            console.log(window.currentIndex);
        }
    });

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
    });

    function showHistory() {
        let history = '<div class="overlay w-full">\n' +
            '        <div class="card w-1/2 bg-gray-100 w-3/4 h-full">\n' +
            '            <div class="max-w-7xl mx-auto">\n' +
            '                <h2 class="card-header text-2xl font-bold mb-4">Prompt History</h2>\n' +
            '                <div class="card-body flex flex-col h-full">\n' +
            '                    <ul class="list-none pl-8 divide-y divide-gray-300 overflow-auto">';

        if (window.savedStrings.length === 0) {
            history = history + '<li class="py-4 px-6 {{ $loop->last ? \'\' : \'border-b\' }}">\n' +
                '                       <p class="text-gray-500 leading-tight">\n' + 'No history yet!' + '</p>\n' +
                '               </li>'
        } else {
            for (let i = 0; i < window.savedStrings.length; i++) {
                history = history + '<li class="mb-4">\n' +
                    '                       <p class="text-gray-500 leading-tight">\n' + window.savedStrings[i] + '</p>\n' +
                    '               </li>'
            }
        }

        history = history + '     </ul>\n' +
            '                </div>\n' +
            '                <div class="card-footer flex content-end flex-row-reverse">\n' +
            '                    <button class="close-btn btn btn-primary px-4 ml-2 mt-2 rounded-md self-star">\n' +
            '                        Close\n' +
            '                    </button>\n' +
            '                    <button id ="clear-history" class="btn btn-primary py-2 px-4 ml-2 mt-2 rounded-md self-start">\n' +
            '                        Clear History\n' +
            '                    </button>\n' +
            '                </div>' +
            '        </div>\n' +
            '    </div>';


        $("#overlayHistory").html(history);

        $(".overlay").click(function (event) {
            if ($(event.target).hasClass("overlay")) {
                $(this).remove();
            }
        });

        $(".close-btn").click(function () {
            $(".overlay").remove();
        });
    };

    $("#clear-history").click(function () {
        window.savedStrings = [];
    });

    $.extend(window, {
        showHistory: showHistory,
        copyMjPrompt: copyMjPrompt
    })

});
