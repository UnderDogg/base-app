$(function ()
{
    // Show Password Toggle
    $('.password-show').password();

    // Markdown
    $("textarea[data-provide='markdown']").markdown();

    // Convert all instances of the date input type to datetime pickers.
    $(".date-picker").datetimepicker({
        format: "L LT"
    });

    // Lazy load all responsive images.
    $('.img-responsive').lazyload();

    // Mark Switches
    $(".switch-mark").bootstrapToggle({
        on: 'Yes',
        off: 'No'
    });

    // Standard Switches.
    $(".switch").bootstrapToggle();

    // Issue Users select.
    $(".select-users").select2();

    // Issue Labels select.
    $(".select-labels").select2({
        formatResult: formatLabel,
        formatSelection: formatLabel
    });

    // Label color select.
    $(".select-label-color").select2({
        formatResult: formatLabel,
        formatSelection: formatLabel
    });

    // Compute slug whenever a key is pressed.
    $("input.slug:text").on('change keyup paste', function ()
    {
        var self = $(this);

        var field = $(self.data('slug-field'));

        if (field != undefined) {
            field.val(getSlug(self.val()));
        }
    });

    /**
     * Formats a select2 label.
     *
     * @param label
     *
     * @returns {*|jQuery}
     */
    function formatLabel(label)
    {
        return $(label.element).text();
    }

    // Form Confirmation window
    $('.form-confirm').on('submit', function(e)
    {
        e.preventDefault();

        var self = this;

        var title = $(self).data('title');
        var text = $(self).data('message');

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

    // Delete link confirmation window
    $('[data-post]').on('click', function(e)
    {
        e.preventDefault();

        var self = this;

        var title = $(self).data('title');
        var text = $(self).data('message');
        var url = $(self).attr('href');
        var method = $(self).data('post');
        var token = $("meta[name='csrf-token']").attr('content');

        var form = $("<form></form>");

        form.attr('method', 'POST');
        form.attr('action', url);

        form.append('<input name="_method" type="hidden" value="'+method+'" />');
        form.append('<input name="_token" type="hidden" value="'+token+'" />');

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
                $('body').append(form);

                return form.submit();
            }
        });
    });

});
