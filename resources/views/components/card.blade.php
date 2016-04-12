<div class="card @yield('card.type')" id="@yield('card.id')">

    @yield('card.title')

    <div class="card-heading image">

        @yield('card.heading')

    </div>

    <div class="card-body">

        @yield('card.body')

    </div>

    <div class="card-actions pull-right">

        @yield('card.actions')

    </div>

    <div class="clearfix"></div>

</div>
