$(function ()
{
    // Bind Pjax to the app container.
    $(document).pjax('a', '#app');

    $(document).on('pjax:beforeSend', function () {
        // Initialize loading screen.
    });

    // Re-initialize js on successful pjax requests.
    $(document).on('ready pjax:success', function() {
        // Force reloads on links clicked with the force-reload class.
        $('.force-reload').click(function () {
            location.reload();
        });

        // User Roles select.
        $(".select-roles").select2({
            placeholder: formatPlaceholder
        });

        // Users select.
        $(".select-users").select2({
            placeholder: formatPlaceholder
        });

        // Labels select.
        $(".select-labels").select2({
            formatResult: formatLabel,
            formatSelection: formatLabel,
            placeholder: formatPlaceholder
        });

        // Label color select.
        $(".select-label-color").select2({
            formatResult: formatLabel,
            formatSelection: formatLabel
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

        /**
         * Formats a select2 placeholder.
         *
         * @param label
         *
         * @returns {*|jQuery}
         */
        function formatPlaceholder(label)
        {
            return $(label.element).data('placeholder');
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
                closeOnCancel: true,
                animation:false
            }, function(isConfirm) {
                if (isConfirm) {
                    return self.submit();
                }
            });
        });

        // Delete link confirmation window
        $('#app').on('click', '[data-post]', function(e)
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
                closeOnCancel: true,
                animation:false
            }, function(isConfirm) {
                if (isConfirm) {
                    $('body').append(form);

                    return form.submit();
                }
            });
        });

    });

});
