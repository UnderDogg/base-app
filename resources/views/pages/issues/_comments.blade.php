<div id="comments">

    <div v-for="comment in comments">

        <div class="card" v-bind:class="{ 'answer' : comment.resolution }" id="comment-@{{{ $comment->id }}}">

            <div v-if="comment.resolution" class="col-md-12 answer-heading">

                <h4>
                    <i class="fa fa-check-square"></i>
                    Best Answer
                </h4>

            </div>

            <div class="card-heading image">

                <img v-bind:src="comment.user.avatar_url" alt="{{ $issue->user->fullname }}'s Profile Avatar"/>

                <div class="card-heading-header">

                    <h3>@{{{ comment.user.fullname  }}}</h3>

                    <span>@{{{ comment.created_at_human  }}}</span>

                </div>

            </div>

            <div class="card-body">
               <p>
                   @{{{ comment.content_from_markdown }}}
               </p>
            </div>

            <div v-show="comment.edit_url || comment.destroy_url" class="card-actions pull-right">

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

            </div>

            <div class="clearfix"></div>

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
