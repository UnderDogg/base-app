<div class="panel panel-default">
    <div class="panel-heading">
        <img class="img-responsive" src="http://placehold.it/670x447">
    </div>
    <div class="panel-body">
        <div class="col-sm-1 col-md-1 step-vertical">
            <h1 class="text-bold"><a href="#step-{{ $step->position }}">{{ $step->position }}</a></h1>
        </div>

        <div class="col-sm-11 col-md-10 step-vertical">
            <p>{{ $step->title }}</p>

            <p>{{ $step->description }}</p>
        </div>

    </div>
</div>
