<div class="table-responsive">

    <table class="table table-hover">

        <thead>

            <tr>
                <th>
                    Last Issue
                </th>
            </tr>

        </thead>

        <tbody>

            <tr>

                <td>
                    @if(isset($column) && isset($issue))
                        {!! call_user_func($column->value, $issue) !!}
                    @else
                        <h5>There are no records to display.</h5>
                    @endif
                </td>

            </tr>

        </tbody>

    </table>

</div>
