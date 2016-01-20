<div id="comments">

    <div v-for="comment in comments">

        @{{{ comment.body }}}

    </div>

</div>

<script>
    new Vue({
        el: '#comments',
        data: {
            comments: []
        },
        ready : function () {
            this.fetch();

            var self = this;

            setInterval(function () {
                self.fetch();
            }, 5000);
        },
        methods : {
            fetch: function () {
                this.$http.get('{{ route('api.v1.issues.comments.index', [$issue->getKey()]) }}', function (comments) {
                    this.$set('comments', comments);
                });
            }
        }
    });
</script>
