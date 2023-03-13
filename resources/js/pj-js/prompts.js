$(document).ready(function () {


    //todo: this has been removes as multipart promts are not a proirty right now but mabye in the future

    $(document).on('input', '.prompt-text-class', function () {

        //todo: we return this for the moment as it is not complete
        //maybe we can use it in the future or delete it
        return;

        const regex = /::(\s|\d\s)/g;
        let promptText = $(this).val();
        const matches = promptText.match(regex);

        if (matches) {
            const matchIndex = promptText.indexOf(matches[0]); // Get the index of the matched string
            const nextChar = promptText.charAt(matchIndex + matches[0].length); // Get the character after the matched string

            const newPromptText = promptText.slice(matchIndex + matches[0].length); // Remove the matched string and the subsequent character from the prompt text
            $(this).val(promptText.replace(matches[0]+newPromptText, ''));
            // Create a new row
            let newRow = createDynamicPromptRow(newPromptText);

            // Get the new textarea so we can set the focus and append the subsequent character
            let newTextarea = newRow.find('.prompt-text-class');

            // Insert the new row after the current row
            $(this).closest('.input-prompt-fields').after(newRow);

            // Set the focus to the new textarea
            newTextarea.focus();

            if (nextChar) {
                const newTextAreaValue = newTextarea.val(); // Append the subsequent character to the new textarea
                newTextarea.val(newTextAreaValue);
            }
        }
    });

    $('#prompt-multi-button').on('click', function () {
        let inputFields = $('.input-prompt-fields');

        // Create a new row
        let newRow = createDynamicPromptRow();
        // Insert the new row after the current row
        inputFields.after(newRow);
    });

    /**
     * Create a new Dynamic Prompt row
     *
     * todo: this has been removed from the front end to be done at a later date as it is not a priority
     */
    function createDynamicPromptRow(newPromptText = '' ) {
        const newRow = $('<div>', {class: 'grid grid-cols-12 gap-2 input-prompt-fields'});
        const newTextarea = $('<textarea>', {
            class: 'prompt-text-class mt-0',
            name: 'prompt-text',
            type: 'text',
            title: 'ctrl-space',
            onInput: "this.parentNode.dataset.replicatedValue = this.value",
            text: newPromptText
        }); // Set the value of the new textarea to the modified prompt text
        const newWeight = $('<input>', {
            class: 'prompt-weight border prompt-text-class m-0 border-black w-full',
            type: 'text',
            value: ''
        });

        // Append the new textarea and weight input to the new row
        newRow.append($('<div>', {class: 'col-span-11 grow-wrap'}).append(newTextarea));
        newRow.append($('<div>', {class: 'col-span-1 w-fit'}).append(newWeight));

        return newRow;
    }

});
