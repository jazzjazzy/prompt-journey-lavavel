// Description: This file contains the keyboard shortcuts for the application

// Shortcut: Ctrl + b + c
// chaos field
$(document).ready(function () {

    $(document).on('keydown', function (e) {
        // Ctrl + shift + c = copy generated prompt to clipboard
        if (e.ctrlKey && e.shiftKey && e.keyCode === 67) {
            e.preventDefault(); // prevent the default browser behavior for this key combination
            copyMjPrompt();
        }
        //Ctrl + alt + c = focus chaos
        if (e.ctrlKey && e.altKey && e.keyCode === 67) {
            e.preventDefault();
            $('#chaos').focus();
        }
        //Ctrl + alt + a = focus aspect
        else if (e.ctrlKey && e.altKey && e.keyCode === 65) {
            e.preventDefault();
            let selectize = $('#aspect')[0].selectize;
            selectize.focus();
        }
        //Ctrl + alt + shift + s = all Suffix
        else if (e.ctrlKey && e.altKey && e.shiftKey && e.keyCode === 83) {
            e.preventDefault();
            allToSuffixList();
        }
        //Ctrl + alt + shift + p = params Suffix
        else if (e.ctrlKey && e.altKey && e.shiftKey && e.keyCode === 80) {
            e.preventDefault();
            paramsToSuffixList();
        }
        //Ctrl + alt + shift + F4 = clear all
        else if (e.ctrlKey && e.altKey && e.shiftKey && e.keyCode === 115) {
            e.preventDefault();
            $.clearAllPromptText();
        }
        //Ctrl + alt + shift + h = show history
        else if (e.ctrlKey && e.altKey && e.shiftKey && e.keyCode === 72) {
            e.preventDefault();
            showHistory();
        }
        //Ctrl + alt + shift + q = focus quality
        else if (e.ctrlKey && e.altKey && e.shiftKey && e.keyCode === 81) {
            e.preventDefault();
            let selectize = $('#quality')[0].selectize;
            selectize.focus();
        }
        //Ctrl + alt + n = focus no
        else if (e.ctrlKey && e.altKey && e.keyCode === 78) {
            e.preventDefault();
            $('#no').focus();
        }
        //Ctrl + alt + e = focus seed
        else if (e.ctrlKey && e.altKey && e.keyCode === 69) {
            e.preventDefault();
            $('#seed').focus();
        }
        //Ctrl + alt + y = focus style
        else if (e.ctrlKey && e.altKey && e.keyCode === 89) {
            e.preventDefault();
            let selectize = $('#style')[0].selectize;
            selectize.focus();
        }
        //Ctrl + alt + v = focus version
        else if (e.ctrlKey && e.altKey && e.keyCode === 86) {
            e.preventDefault();
            let selectize = $('#version')[0].selectize;
            selectize.focus();
        }
        //Ctrl + alt + i = focus version
        else if (e.ctrlKey && e.altKey && e.keyCode === 73) {
            e.preventDefault();
            $('#iw').focus();
        }
        //Ctrl + alt + l = focus version
        else if (e.ctrlKey && e.altKey && e.keyCode === 76) {
            e.preventDefault();
            $("#tile").prop("checked", function (index, value) {
                checkboxColor($("#tile"));
                return !value;
            });
        }
    });


    $(document).on('keyup', function (e) {
        //alt + a = focus upanime
        if (!e.ctrlKey && e.altKey && e.keyCode === 65) {
            e.preventDefault();
            $("#upanime").prop("checked", function (index, value) {
                checkboxColor($("#upanime"));
                return !value;
            });

        }
        //alt + h = focus hd
        else if (!e.ctrlKey && e.altKey && e.keyCode === 72) {
            e.preventDefault();
           $("#hd").prop("checked", function (index, value) {
                checkboxColor($("#hd"));
                return !value;
            });

        }
        //alt + l = focus uplight
        else if (!e.ctrlKey && e.altKey && e.keyCode === 76) {
            e.preventDefault();
            $("#uplight").prop("checked", function (index, value) {
                checkboxColor($("#uplight"));
                return !value;
            });

        }
        //alt + n = focus niji
        else if (!e.ctrlKey && e.altKey && e.keyCode === 78) {
            e.preventDefault();
            $("#niji").prop("checked", function (index, value) {
                checkboxColor($("#niji"));
                return !value;
            });
        }
        //alt + p = focus testp
        else if (!e.ctrlKey && e.altKey && e.keyCode === 80) {
            e.preventDefault();
            $("#testp").prop("checked", function (index, value) {
                checkboxColor($("#testp"));
                return !value;
            });
        }
        //alt + t = focus test
        else if (!e.ctrlKey && e.altKey && e.keyCode === 84) {
            e.preventDefault();
            $("#test").prop("checked", function (index, value) {
                checkboxColor($("#test"));
                return !value;
            });
        }
        //alt + b = focus upbeta
        else if (!e.ctrlKey && e.altKey && e.keyCode === 66) {
            e.preventDefault();
            $("#upbeta").prop("checked", function (index, value) {
                checkboxColor($("#upbeta"));
                return !value;
            });
        }
        //Ctrl + space = focus prompt
        else if (e.ctrlKey && e.keyCode === 32) {
            e.preventDefault();
            $("#prompt-text").focus();
        }
    });

        function checkboxColor(param) {

            // Get the ID of the input element
            let id = param.attr("id");
            // Get the wrapper element using the ID
            let wrapper = $('#' + id + '-wrapper');
            // Get the label elements using the wrapper element
            let labels = wrapper.find('label');
            // Get the background color from the 'data-color' attribute of the wrapper element
            let color = wrapper.attr("data-color");
            // Add or remove the appropriate background color class based on the input element state
            if (param.is(':checked')) {
                param.prop('checked', false);
                wrapper.removeClass('bg-' + color + '-700').addClass('bg-' + color + '-300');
                labels.removeClass('text-gray-400').addClass('text-gray-200');
            } else {
                param.prop('checked', true);
                wrapper.removeClass('bg-' + color + '-300').addClass('bg-' + color + '-700');
                labels.removeClass('text-gray-200').addClass('text-gray-400');
            }

            var functionName = id +"Param";
            window[functionName]();
        }

    });




