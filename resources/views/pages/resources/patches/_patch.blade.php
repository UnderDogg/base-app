<div class="card card-primary">

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

        <img class="avatar" src="{{ route('profile.avatar.download', [$patch->user->getKey()]) }}" alt="{{ $patch->user->name }}'s Profile Avatar"/>

        <div class="card-heading-header">

            <h3>{{ $patch->user->name }}</h3>

            <span>{!! $patch->created_at_human !!}</span>

        </div>

    </div>

    <div class="card-body">

        <p>
            {!! $patch->description_from_markdown !!}
        </p>

    </div>

    <div class="card-actions pull-right">

        <a
                class="btn btn-default btn-sm"
                href="#">
            <i class="fa fa-edit"></i>
            Edit
        </a>

    </div>

    <div class="clearfix"></div>

</div>
