<div class="card card-primary">

    <!-- Patch Title. -->
    <div class="card-title col-md-12">

        <h4>

            <span class="text-muted">{{ $patch->hash_id }}</span>
            {{ $patch->title }}

            <span class="pull-right text-muted">
                <i class="fa fa-medkit"></i>
            </span>

        </h4>

    </div>

    <div class="card-heading image">

        <img class="avatar" src="{{ route('profile.avatar.download', [$patch->user->id]) }}" alt="{{ $patch->user->name }}'s Profile Avatar"/>

        <div class="card-heading-header">

            <h3>{{ $patch->user->name }}</h3>

            <span>{!! $patch->created_at_human !!}</span>

        </div>

    </div>

    <!-- Patch Body. -->
    <div class="card-body">

        <p>
            {!! $patch->description_from_markdown !!}
        </p>

        @include('pages.resources.patches._files')

    </div>

    <!-- Patch Actions. -->
    <div class="card-actions pull-right">

        <a
                class="btn btn-default btn-sm"
                href="{{ route('resources.patches.edit', [$patch->id]) }}">
            <i class="fa fa-edit"></i>
            Edit
        </a>

    </div>

    <div class="clearfix"></div>

</div>
