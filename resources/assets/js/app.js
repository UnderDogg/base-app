$(function ()
{

    var confirmForm = $('.form-confirm');

    confirmForm.on('submit', function(e)
    {
        e.preventDefault();

        var self = this;

        var title = confirmForm.data('title');
        var text = confirmForm.data('message');

        swal({
            title: (title ? title : "Are you sure?"),
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                return self.submit();
            }
        });
    });

});
