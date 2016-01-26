<div id="comments">

    <div v-for="comment in comments">

        <div class="panel" v-bind:class="[ comment.resolution ? 'panel-success' : 'panel-default' ]" id="comment-@{{{ $comment->getKey() }}}">

            <div class="panel-heading">
                <h3 class="panel-title">

                    <i v-show="comment.resolution" class="fa fa-check-square"></i>

                    <span class="h5">
                        @{{{ comment.created_at_tag_line  }}}
                    </span>

                    <div class="clearfix"></div>

                </h3>
            </div>

            <div class="panel-body">
                @{{{ comment.content_from_markdown  }}}

                <div v-show="comment.edit_url || comment.destroy_url" class="row">

                    <hr>

                    <div class="col-md-12">

                        <span class="btn-group">
                            <a
                                    v-show="comment.edit_url"
                                    class="btn btn-default btn-sm"
                                    href="@{{{ comment.edit_url }}}">
                                <i class="fa fa-edit"></i>
                                Edit
                            </a>

                            <a
                                    v-show="comment.destroy_url"
                                    class="btn btn-default btn-sm"
                                    data-post="DELETE"
                                    data-title="Delete Comment?"
                                    data-message="Are you sure you want to delete this comment?"
                                    href="@{{{ comment.destroy_url }}}">
                                <i class="fa fa-times"></i>
                                Delete
                            </a>
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    new Vue({
        el: '#comments',
        data: {
            comments: []
        },
        ready: function () {
            this.fetch();
        },
        methods: {
            fetch: function () {
                this.$http.get('{{ route('api.v1.issues.comments.index', [$issue->getKey()]) }}', function (comments) {
                    this.$set('comments', comments);
                });

                setTimeout(this.fetch, 10000);
            }
        }
    });
</script>
