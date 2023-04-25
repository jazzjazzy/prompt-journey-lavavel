
$(document).ready(function () {
    $(document).on('click', '.delete-project', function (event) {
        event.preventDefault();
        var deleteUrl = $(this).data('project-url');

        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                location.reload(); // refresh the current page
            },
            error: function (xhr, status, error) {
                alert('error deleting project');
            }
        });
    });
});
