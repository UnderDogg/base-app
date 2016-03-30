@extends('pages.computers.show')

@section('show.panel.title')
    Access
@endsection

@section('show.panel.body')

    <div class="col-md-12">

        {!! $form !!}

    </div>

    <script type="text/javascript">

        var wmi = $('#wmi');

        var wmiCredentials = $('#wmi_credentials');
        var wmiCredentialsLabel = $('label[for="wmi_credentials"]');

        var wmiUsername = $('#wmi_username');
        var wmiUsernameLabel = $('label[for="wmi_username"]');

        var wmiPassword = $('#wmi_password');
        var wmiPasswordLabel = $('label[for="wmi_password"]');

        if (wmi.prop('checked')) {
            showWmiFields();
        } else {
            hideWmiFields();
        }

        if(wmiCredentials.prop('checked')) {
            disableWmiFields();
        } else {
            enableWmiFields();

            wmiPassword.val('{{ ($computer->access ? $computer->access->wmi_password : null) }}');
        }

        wmi.change(function() {
            if (this.checked) {
                showWmiFields();
            } else {
                hideWmiFields();
            }
        });

        wmiCredentials.change(function ()
        {
            if (this.checked) {
                disableWmiFields();
            } else {
                enableWmiFields();
            }
        });

        function showWmiFields()
        {
            wmiCredentialsLabel.removeClass('hidden');
            wmiCredentials.parent().removeClass('hidden');

            wmiUsernameLabel.removeClass('hidden');
            wmiUsername.removeClass('hidden');

            wmiPasswordLabel.removeClass('hidden');
            wmiPassword.removeClass('hidden');
        }

        function hideWmiFields()
        {
            wmiCredentialsLabel.addClass('hidden');
            wmiCredentials.parent().addClass('hidden');

            wmiUsernameLabel.addClass('hidden');
            wmiUsername.addClass('hidden');

            wmiPasswordLabel.addClass('hidden');
            wmiPassword.addClass('hidden');
        }

        function enableWmiFields()
        {
            wmiUsername.prop('disabled', false);
            wmiPassword.prop('disabled', false);
        }

        function disableWmiFields()
        {
            wmiUsername.prop('disabled', true);
            wmiPassword.prop('disabled', true);
        }

    </script>

@endsection
