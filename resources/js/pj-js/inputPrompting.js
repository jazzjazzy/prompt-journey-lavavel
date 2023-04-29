// chaos field
$(document).ready(function () {
    // Attach an 'input' event listener to all elements with the 'parameter-class' class
    /**
     * this will directly affect the color of the input field when the user types in it,
     * changes to these field from the prompt-text input are handled in
     * parameter.js methods textParmeters() and selectParmeters() and checkboxParmeters() functions
     */
    $('.parameter-class').on('input', function () {
        // Get the ID of the input element
        var id = $(this).attr("id");
        // Get the wrapper element using the ID
        var wrapper = $('#' + id + '-wrapper');
        // Get the label elements using the wrapper element
        var labels = wrapper.find('label');
        // Get the background color from the 'data-color' attribute of the wrapper element
        var color = wrapper.attr("data-color");
        // Determine the value of the input element based on its type, don't care about the value of checkboxes
        var value = ($(this).prop('type') === 'checkbox') ? '' : $(this).val().trim();
        // Check whether the input element is checked
        var isChecked = $(this).is(':checked');
        // Check whether the input element has a non-empty value
        var hasValue = !isChecked && value !== '';
        // Add or remove the appropriate background color class based on the input element state
        if (isChecked || hasValue) {
            wrapper.removeClass('bg-' + color + '-300').addClass('bg-' + color + '-700');
            labels.removeClass('text-gray-600').addClass('text-gray-200');
        } else {
            wrapper.removeClass('bg-' + color + '-700').addClass('bg-' + color + '-300');
            labels.removeClass('text-gray-200').addClass('text-gray-600');
        }
    });

    function resetPromptsBackgrounds() {
        var labels = wrapper.find('label');
        // Get the background color from the 'data-color' attribute of the wrapper element
        var color = wrapper.attr("data-color");
    }

    function clearAllPromptText(withPromptText = false) {


        $("input.parameter-class, select.parameter-class").each(function () {
            var type = $(this).attr("type");
            var paraName = $(this).attr("id");

            if (type === "checkbox" && $('#' + paraName).is(":checked")) {
                $('#' + paraName).prop("checked", false);
            } else if (type === "text" && $('#' + paraName).val() !== '') {
                $('#' + paraName).val('');
            } else if (type !== "checkbox" && type !== "text") {
                var selection = $('#' + paraName).selectize();
                if (selection[0].selectize.getValue() !== '') {
                    let selectize = selection[0].selectize;
                    selectize.setValue('');
                }
            }

            /**
             * Reset the background color of the wrapper element
             * @type {*|jQuery|HTMLElement}
             */
            var wrapper = $('#' + paraName + '-wrapper');
            // Get the label elements using the wrapper element
            var labels = wrapper.find('label');
            // Get the background color from the 'data-color' attribute of the wrapper element
            var color = wrapper.attr("data-color");

            wrapper.removeClass('bg-' + color + '-700').removeClass('bg-' + color + '-300').addClass('bg-' + color + '-300');
            labels.removeClass('text-gray-200').addClass('text-gray-600');
        });

        if(withPromptText){
            $('#prompt-text').val('');
        }
        updatePromptText();
    }

    $.extend({
        clearAllPromptText: clearAllPromptText
    });
});



