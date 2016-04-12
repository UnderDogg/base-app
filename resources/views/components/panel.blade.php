<div class="panel @section('panel.type') panel-default @show">

    @section('panel.heading')

        <div class="panel panel-heading">

            <div class="panel-title">

                @yield('panel.title')

            </div>

        </div>

    @show

    <div class="panel-body">

        <div class="col-md-12">

            @yield('panel.body')

        </div>

    </div>

</div>
