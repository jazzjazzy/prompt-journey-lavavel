// Description: This file contains the keyboard shortcuts for the application

// Shortcut: Ctrl + b + c
// chaos field
$(document).ready(function () {

    $(document).on('keydown', function(e) {
        if (e.keyCode === 38 || e.keyCode === 40) { // up or down arrow key
            e.preventDefault(); // stop default scrolling behavior
            let delta = e.keyCode === 38 ? -50 : 50; // determine scroll direction
            $('#myDiv').scrollTop($('#myDiv').scrollTop() + delta); // scroll the div
        }
    });


    $(document).keydown(function (e) {

        // Ctrl + shift + c = copy generated prompt
        if (e.ctrlKey && e.shiftKey && e.keyCode === 67) {
            e.preventDefault(); // prevent the default browser behavior for this key combination
            copyMjPrompt();
        }

        // Ctrl + alt + shift + s = add as Suffix
        if(e.ctrlKey && e.altKey && e.shiftKey && e.keyCode === 83) {
            e.preventDefault();
            addToSuffixList();
        }

        // Ctrl + alt + shift + F4 = clear all
        if(e.ctrlKey && e.altKey && e.shiftKey && e.keyCode === 115) {
            e.preventDefault();
            $.clearAllPromptText();
        }

        //Ctrl + alt + shift + h = show history
        if(e.ctrlKey && e.altKey && e.shiftKey && e.keyCode === 72) {
            e.preventDefault();
            showHistory();
        }

        //Ctrl + space = focus prompt
        if (e.ctrlKey && e.keyCode === 32) { //32 is the keycode for space
            e.preventDefault(); // prevent the default browser behavior for this key combination
            // Call your function here
            $("#prompt-text").focus();
        }


        //Ctrl + alt + a = focus aspect
        if (e.ctrlKey && e.altKey && e.keyCode === 65) { //65 is the keycode for a
            e.preventDefault(); // prevent the default browser behavior for this key combination
            let selectize = $('#aspect')[0].selectize;
            selectize.focus();
        }

        //Ctrl + alt + c = focus chaos
        if (e.ctrlKey && e.altKey && e.keyCode === 67) { //67 is the keycode for c
            e.preventDefault(); // prevent the default browser behavior for this key combination
            $('#chaos').focus();
        }

        //Ctrl + alt + shift + q = focus quality
        if (e.ctrlKey && e.altKey && e.keyCode === 81) { //81 is the keycode for q
            e.preventDefault(); // prevent the default browser behavior for this key combination
            let selectize = $('#quality')[0].selectize;
            selectize.focus();
        }

        //Ctrl + alt + n = focus no
        if (e.ctrlKey && e.altKey && e.keyCode === 78) { //78 is the keycode for n
            e.preventDefault(); // prevent the default browser behavior for this key combination
            $('#no').focus();
        }

        //Ctrl + alt + e = focus seed
        if (e.ctrlKey && e.altKey && e.keyCode === 69) { //69 is the keycode for e
            e.preventDefault(); // prevent the default browser behavior for this key combination
            $('#seed').focus();
        }

        //Ctrl + alt + y = focus style
        if (e.ctrlKey && e.altKey && e.keyCode === 89) { //89 is the keycode for y
            e.preventDefault(); // prevent the default browser behavior for this key combination
            let selectize = $('#style')[0].selectize;
            selectize.focus();
        }

        //Ctrl + alt + v = focus version
        if (e.ctrlKey && e.altKey && e.keyCode === 86) { //86 is the keycode for v
            e.preventDefault(); // prevent the default browser behavior for this key combination
            let selectize = $('#version')[0].selectize;
            selectize.focus();
        }

        //Ctrl + alt + s = focus version
        if (e.ctrlKey && e.altKey && e.keyCode === 83) { //83 is the keycode for s
            e.preventDefault(); // prevent the default browser behavior for this key combination
            $('#stylize').focus();
        }

        //alt + n = focus niji
        if (e.altKey && e.keyCode === 78) { //78 is the keycode for n
            e.preventDefault(); // prevent the default browser behavior for this key combination
            // Call your function here
            $("#niji").prop("checked", function(index, value) {
                return !value; // toggles the current value of the checked property
            });
        }

        //alt + h = focus hd
        if (e.altKey && e.keyCode === 72) { //72 is the keycode for h
            e.preventDefault(); // prevent the default browser behavior for this key combination
            // Call your function here
            $("#hd").prop("checked", function(index, value) {
                return !value; // toggles the current value of the checked property
            });
        }

        //alt + t = focus test
        if (e.altKey && e.keyCode === 84) { //84 is the keycode for t
            e.preventDefault(); // prevent the default browser behavior for this key combination
            // Call your function here
            $("#test").prop("checked", function(index, value) {
                return !value; // toggles the current value of the checked property
            });
        }

        //alt + p = focus testp
        if (e.altKey && e.keyCode === 80) { //80 is the keycode for p
            e.preventDefault(); // prevent the default browser behavior for this key combination
            $("#testp").prop("checked", function (index, value) {
                return !value; // toggles the current value of the checked property
            });
        }

        //alt + l = focus uplight
        if (e.altKey && e.keyCode === 76) { //76 is the keycode for l
            e.preventDefault(); // prevent the default browser behavior for this key combination
            $("#uplight").prop("checked", function (index, value) {
                return !value; // toggles the current value of the checked property
            });
        }

        //alt + b = focus upbeta
        if (e.altKey && e.keyCode === 66) { //66 is the keycode for b
            e.preventDefault(); // prevent the default browser behavior for this key combination
            $("#upbeta").prop("checked", function (index, value) {
                return !value; // toggles the current value of the checked property
            });
        }

        //alt + a = focus upanime
        if (e.altKey && e.keyCode === 65) { //65 is the keycode for a
            e.preventDefault(); // prevent the default browser behavior for this key combination
            $("#upanime").prop("checked", function (index, value) {
                return !value; // toggles the current value of the checked property
            });
        }
    });
});




