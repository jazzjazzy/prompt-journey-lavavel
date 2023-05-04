$(document).ready(function () {

    // Get the modal and button elements
    const modal = $('#myModal');
    // Get the <span> element that closes the modal
    const span = $('.close').eq(0);


// When the user clicks on the button, open the modal
    $(document).on('click', '.open-modal', function () {

        const url = $(this).attr('data-url');
        const size = $(this).attr('data-modal-size');
        const isFixed = $(this).attr('data-modal-fixed');

        if (size == 'xs') {
            $('#myModal .overlay .card').addClass('w-1/8 h-1/2');
        } else if (size == 'sm') {
            $('#myModal .overlay .card').addClass('w-1/4 h-1/2');
        } else if (size == 'lg') {
            $('#myModal .overlay .card').addClass('w-3/4 h-3/4');
        } else if (size == 'xl') {
            $('#myModal .overlay .card').addClass('w-4/5 h-4/5');
        } else if (size == 'full') {
            $('#myModal .overlay .card').addClass('w-full h-full');
        } else {
            $('#myModal .overlay .card').addClass('w-1/2 h-1/2');
        }

        const title = $(this).attr('title');
        const modalIframe = $('#modal-iframe');
        $('#modal-title').text(title);
        modalIframe.attr('src', url);
        modalIframe.show();


        if (isFixed === 'true') {
            modalIframe.attr('scrolling', 'no');
        }else{
            modalIframe.attr('scrolling', 'yes');
        }
        modal.css('display', 'block');
    });

// When the user clicks on <span> (x), close the modal
    span.on('click', function () {
        modal.css('display', 'none');
        reinitiateModal();
    });

    $('#myModal .close-btn').on('click', function () {
        modal.css('display', 'none');
        reinitiateModal();
    });
// When the user clicks anywhere outside of the modal, close it
    $(window).on('click', function (event) {
        if (event.target == modal[0]) {
            modal.css('display', 'none');
            reinitiateModal();
        }
    });

    /**
     * clear all possible frames sizes for the next modal
     */
    function reinitiateModal(){
        //remove all the possible sizes, so we don't get multiple sizes in class
        $('#myModal .overlay .card').removeClass('w-1/8 h-1/2');
        $('#myModal .overlay .card').removeClass('w-1/4 h-1/2');
        $('#myModal .overlay .card').removeClass('w-3/4 h-3/4');
        $('#myModal .overlay .card').removeClass('w-4/5 h-4/5');
        $('#myModal .overlay .card').removeClass('w-full h-full');
        $('#myModal .overlay .card').removeClass('w-1/2 h-1/2');

        //clear the iframe src, so we don't have a previous iframe loaded
        $('#modal-iframe').attr('src', null);
    }
});
