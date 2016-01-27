<div id="step-{{ $step->position }}" class="step panel panel-default">

    @if(count($step->images) > 0)

    <div class="step-heading panel-heading">
        @foreach($step->images as $image)
            <img class="img-responsive" data-original="{{ route('resources.guides.steps.images.download', [$step->guide->getSlug(), $step->getKey(), $image->uuid]) }}">
        @endforeach
    </div>

    @endif

    <div class="panel-body">

        <div class="col-sm-2 col-md-2 step-vertical">
            <h1 class="text-bold sortable-handle"><a class="anchor" href="#step-{{ $step->position }}">{{ $step->position }}</a></h1>
        </div>

        <div class="col-sm-9 col-md-9 step-vertical">
            <p class="lead">{{ $step->title }}</p>

            <p>{{ $step->description }}</p>
        </div>

    </div>

</div>
