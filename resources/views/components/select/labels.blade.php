<select class="select-labels form-control" multiple>
    @foreach($labels as $label)
        <option data-display='{{ $label->display() }}' selected value="{{ $label->id }}">{{ $label->name }}</option>
    @endforeach
</select>
