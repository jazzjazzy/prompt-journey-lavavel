//section select arrays
const aspectOptions = [
    {value: '1:1', text: '1:1'},
    {value: '2:3', text: '2:3'},
    {value: '3:2', text: '3:2'},
    {value: '4:3', text: '4:3'},
    {value: '3:4', text: '3:4'},
    {value: '7:9', text: '7:9'},
    {value: '9:7', text: '9:7'},
    {value: '16:9', text: '16:9'},
    {value: '9:16', text: '9:16'},
];

const qualityOptions = [
    {value: '.25', text: '.25'},
    {value: '.5', text: '.5'},
    {value: '1', text: '1'},
    {value: '2', text: '2'},
];

const versionOptions = [
    {value: '1', text: '1'},
    {value: '2', text: '2'},
    {value: '3', text: '3'},
    {value: '4', text: '4'},
    {value: '5', text: '5'},
    {value: '5.1', text: '5.1'},
    {value: '5.2', text: '5.2'},
];

const styleOptions = [
    {value: '4a', text: '4a'},
    {value: '4b', text: '4b'},
    {value: '4c', text: '4c'},
    {value: 'raw', text: 'raw'},
    {value: 'cute', text: 'cute'},
    {value: 'expressive', text: 'expressive'},
];


// section select controls
$(document).ready(function () {

    function updatePromptAllFields() {
        aspect();
        chaos();
        quality();
        no();
        seed();
        stop();
        style();
        stylize();
        tile();
        iw();
        version();
        niji();
        hd();
        test();
        testp();
        uplight();
        upbeta();
        upanime();
    }


    /*******************
     * set up the selectize controls for parameters
     * @type {*|jQuery}
     */
    var aspectSelect = $('#aspect').selectize({
        options: aspectOptions,
        valueField: 'value',
        labelField: 'text',
        searchField: 'text',
        create: true,
        dropdownParent: 'body',
        render: {
            option: function (data, escape) {
                return '<div class="px-4 py-2 hover:bg-gray-900">' + escape(data.text) + '</div>';
            },
            item: function (data, escape) {
                return '<div class="p-0">' + escape(data.text) + '</div>';
            }
        },
    });

    var qualitySelect = $('#quality').selectize({
        options: qualityOptions,
        valueField: 'value',
        labelField: 'text',
        searchField: 'text',
        create: false,
        dropdownParent: 'body',
        render: {
            option: function (data, escape) {
                return '<div class="px-4 py-2 hover:bg-gray-900">' + escape(data.text) + '</div>';
            },
            item: function (data, escape) {
                return '<div class="p-0">' + escape(data.text) + '</div>';
            }
        },
    });

    var versionSelect = $('#version').selectize({
        options: versionOptions,
        valueField: 'value',
        labelField: 'text',
        searchField: 'text',
        create: false,
        dropdownParent: 'body'
    });
    var styleSelect = $('#style').selectize({
        options: styleOptions,
        valueField: 'value',
        labelField: 'text',
        searchField: 'text',
        create: false,
        dropdownParent: 'body'
    });

    //section param action calls
    /*******************
     * Lister for any changes to the parameters to update the prompt text
     ******************/
    aspectSelect[0].selectize.on('change', function () {
        aspect();
    });
    versionSelect[0].selectize.on('change', function () {
        version();
    });
    $('#chaos').on('change', function () {
        chaos();
    });
    qualitySelect[0].selectize.on('change', function () {
        quality();
    });
    $('#no').on('change', function () {
        no();
    });
    $('#seed').on('change', function () {
        seed();
    });
    $('#stop').on('change', function () {
        stop();
    });
    styleSelect[0].selectize.on('change', function () {
        style();
    });
    $('#stylize').on('change', function () {
        stylize();
    });
    $('#iw').on('change', function () {
        iw();
    });
    $('#tile').on('change', function () {
        tile();
    });
    $('#niji').on('change', function () {
        niji();
    });
    $('#hd').on('change', function () {
        hd();
    });
    $('#test').on('change', function () {
        test();
    });
    $('#testp').on('change', function () {
        testp();
    });
    $('#uplight').on('change', function () {
        uplight();
    });
    $('#upbeta').on('change', function () {
        upbeta();
    });
    $('#upanime').on('change', function () {
        upanime();
    });


//section param functions
    /*******************
     * functions to update the prompt text
     */
    function aspect() {
        const regex = /--(ar|aspect)\s+\d+:\d+/g;
        selectParameters('aspect', regex, aspectSelect);
    }

    function chaos() {
        const regex = /--chaos\s(?:100|\d{1,2})\s/g;
        textParmeters('chaos', regex);
    }

    function quality() {
        const regex = /--(quality|q)\s+(?:(?:\.25|\.5)|[12])/g;
        selectParameters('quality', regex, qualitySelect);
    }


    function version() {
        const regex = /--v(?:ersion)?\s(1|2|3|4|5|5\.1|5\.2)\s/g;
        selectParameters('version', regex, versionSelect);
    }

    function no() {
        const regex = /--no\s+(['"][\w\s]+['"]|\w+)\s/g;// /--no\s*\S*\s/g /--no\s+([\w\s]+?)(?=\s*--|$)/g;
        textParmeters('no', regex);
    }

    function seed() {
        const regex = /--seed\s(?:[1-9]\d{0,8}|0)\s/g;
        textParmeters('seed', regex);
    }

    function stop() {
        const regex = /--stop\s(?:100|\d{1,2})\s/g;
        textParmeters('stop', regex);
    }

    function style() {
        const regex = /--style\s*[4][abc]\s/g;
        selectParameters('style', regex, styleSelect);
    }

    function stylize() {
        const regex = /--s(?:tylize)?\s[0-9]{1,4}(?:\.[0-9]+)?/g;
        textParmeters('stylize', regex);
    }

    function iw() {
        const regex = /--iw\s(0\.[5-9]|[1-9]\.[0-9]|1\.[0-9]|2(\.0)?|1)\s/g;
        textParmeters('iw', regex);
    }

    function tile() {
        const regex = /--tile/g;
        checkboxParameters('tile', regex);
    }

    function niji() {
        const regex = /--niji/g;
        checkboxParameters('niji', regex);
    }

    function hd() {
        const regex = /--hd/g;
        checkboxParameters('hd', regex);
    }

    function test() {
        //we check space after test to make sure we don't match testp
        const regex = /--test\s/g;
        checkboxParameters('test', regex);
    }

    function testp() {
        const regex = /--testp/g;
        checkboxParameters('testp', regex);
    }

    function uplight() {
        const regex = /--uplight/g;
        checkboxParameters('uplight', regex);
    }

    function upbeta() {
        const regex = /--upbeta/g;
        checkboxParameters('upbeta', regex);
    }

    function upanime() {
        const regex = /--upanime/g;
        checkboxParameters('upanime', regex);
    }

    //section textparams
    /*******************
     * functions to update the prompt text
     * @param paraName
     * @param regex
     */
    function textParmeters(paraName, regex) {
        let promptText = $('.prompt-text-class').val();

        const matches = promptText.match(regex);

        if (matches) {
            let match = $.trim(matches[0].match(/^([^ ]+) (.+)/)[2]);
            $('#' + paraName).val(match);
            let wrapper = $('#' + paraName + '-wrapper');
            var labels = wrapper.find('label');
            let color = wrapper.attr("data-color");
            //wrapper.removeClass('bg-'+color+'-300').addClass('bg-'+color+'-700');
            wrapper.removeClass('bg-' + color + '-300').addClass('bg-' + color + '-700');
            labels.removeClass('text-gray-600').addClass('text-gray-200');

            // remove all matches aspect ratio from prompt text
            promptText = $.trim(promptText.replace(regex, ''));
            $('.prompt-text-class').val(promptText + ' ');
        }
        updatePromptText();
    }

    //section selectparams
    /*******************
     * functions to update the prompt text
     * @param paraName
     * @param regex
     * @param selection
     */
    function selectParameters(paraName, regex, selection) {
        let promptText = $('.prompt-text-class').val();

        const matches = promptText.match(regex);
        if (matches) {
            let match = matches[0].split(' ')[1];

            var select = $('#' + paraName).selectize();
            var selectize = select[0].selectize;

            const createEnabled = selectize.settings.create;
            if (createEnabled) {
                selectize.addOption({value: match, text: match});
                selectize.setValue(match);
            } else {
                selectize.setValue(match);
            }
            // remove all matches aspect ratio from prompt text
            promptText = $.trim(promptText.replace(regex, ''));
            $('.prompt-text-class').val(promptText + ' ');
        }
        updatePromptText();
    }

    //section checkboxparams
    function checkboxParameters(paraName, regex) {
        let promptText = $('.prompt-text-class').val();

        const matches = promptText.match(regex);

        if (matches) {
            //let match = matches[0].match(/^([^ ]+) (.+)/)[2];
            $('#' + paraName).prop("checked", true);

            let wrapper = $('#' + paraName + '-wrapper');
            var labels = wrapper.find('label');
            let color = wrapper.attr("data-color");
            //wrapper.removeClass('bg-'+color+'-300').addClass('bg-'+color+'-700');
            wrapper.removeClass('bg-' + color + '-300').addClass('bg-' + color + '-700');
            labels.removeClass('text-gray-600').addClass('text-gray-200');

            // remove all matches aspect ratio from prompt text
            promptText = $.trim(promptText.replace(regex, ''));
            $('.prompt-text-class').val(promptText + ' ');
        }
        updatePromptText();
    }

    /**
     * update the prompt text by adding the prompt-text field and all the parameters
     */
    //section update master prompt
    function updatePromptText() {
       // if (window.currentIndex === window.savedStrings.length) {
            // get the text from prompt text area
            let promptValue = $.trim($('.prompt-text-class').val());
            var paramValue = '';
            var suffix = ''
            var images = '';

            // add the parameters to the prompt text
            $("input.parameter-class, select.parameter-class").each(function () {
                var type = $(this).attr("type");
                var paraName = $(this).attr("id");

                if (type === "checkbox" && $('#' + paraName).is(":checked")) {
                    paramValue += ' --' + paraName;
                } else if ((type === "text" || type === 'number' ) && $('#' + paraName).val() !== '') {
                    paramValue += ' --' + paraName + ' ' + $('#' + paraName).val();
                } else if (type === undefined){
                    var selection = $('#' + paraName).selectize();
                    if (selection[0].selectize.getValue() !== '') {
                        paramValue += ' --' + paraName + ' ' + selection[0].selectize.getValue();
                    }
                }
            });

            // get the list of suffixes and image
            images = getImagePromptText();
            suffix = getSuffixPromptText();

            // check if we have a suffix or images and add a space if we do
            suffix = (suffix === '') ? '' : ' ' + $.trim(suffix);
            images = (images === '') ? '' : $.trim(images) + ' ';
            paramValue = (paramValue === '') ? '' : ' ' + $.trim(paramValue);


            //build the Main Prompt text
            const mainPrompt = $('#prompt');
            mainPrompt.prop('disabled', false);
            mainPrompt.val(images + promptValue + paramValue + suffix);
            $.expandTextarea(mainPrompt[0]);
            mainPrompt.prop('disabled', true);
      //  }
    }

    function getPromptText() {
        let promptsSting = getPromptTextString(true);
        $.clearAllPromptText(true);
        return promptsSting;
    }

    function getPramaText() {
        let promptsSting = getPromptTextString();
        $.clearAllPromptText();
        return promptsSting;
    }

    function getPromptTextString(withPromptText = false) {

        var value = (withPromptText) ? $('.prompt-text-class').val() : '';

        $("input.parameter-class, select.parameter-class").each(function () {
            var type = $(this).attr("type");
            var paraName = $(this).attr("id");
            var paramValue = '';

            if (type === "checkbox" && $('#' + paraName).is(":checked")) {
                paramValue = ' --' + paraName;
            } else if ((type === "text" || type === 'number' ) && $('#' + paraName).val() !== '') {
                paramValue = ' --' + paraName + ' ' + $('#' + paraName).val();
            } else if ((type === undefined)) {
                var selection = $('#' + paraName).selectize();
                if (selection[0].selectize.getValue() !== '') {
                    paramValue = ' --' + paraName + ' ' + selection[0].selectize.getValue();
                }
            }
            if (paramValue !== '') {
                value += paramValue;
            }
        });
        return value;
    }

    $('#clear').on('click', function (e) {
        e.preventDefault();
        $.clearAllPromptText();
    });


    $.extend(window, {
        updatePromptAllFields: updatePromptAllFields,
        getPromptText: getPromptText,
        getPramaText: getPramaText,
        updatePromptText: updatePromptText,
    });
});




