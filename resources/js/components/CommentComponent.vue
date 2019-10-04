<template>
  <div class="col-md-6 col-md-offset-2 col-sm-12">
        <div class="comment-wrapper">
            <div class="panel panel-info">
                <div class="panel-heading"> Comment panel</div>
                <div class="panel-body">
                    <div v-if="user">
                        <textarea class="form-control"
                            v-model="comment"
                            placeholder="write a comment..." rows="3"></textarea>
                        <br>
                        <button type="button" v-if="checkEmpty" @click.prevent="sentComment()" class="btn btn-info">Post</button>
                    </div>
                    <div v-else>
                        <p>You must logged in to leave your comment!  
                            <a class='btn btn-primary' href="/login">
                                    Login Now
                            </a>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <ul class="media-list">
                        <li class="media" v-for="cmt in comments">
                            <a href="#" class="pull-left">
                                <img src="https://randomuser.me/api/portraits/women/15.jpg" alt="" class="img-circle">
                            </a>
                            <div class="media-body">
                                <span class="text-muted pull-right">
                                        <small class="text-muted">30 min ago</small>
                                </span>
                                <strong class="text-success">@{{cmt.user.name}} </strong>
                                <p> 
                                    {{cmt.body}},
                                    <!-- <a href="#">#consecteturadipiscing </a>. -->
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        postid : Number,
        user: Object,
    },
    data : function(){
        return {
            comments:[],
            comment:"",
        }
    },
    
    mounted(){
        this.getComments();
        this.listen();
    },

    computed:{
        checkEmpty: function(){
            return (this.comment.length >0 && this.comment.length >= 3) ? true : false;
        }
    },

    methods: {
        getComments: function () {
            axios.get(`/api/posts/${this.postid}/comments`)
                .then(res => {
                    this.comments = res.data;
                })
                .catch(err => {
                    console.log(err);
                })
        },

        sentComment: function () {
            axios.post(`/api/posts/${this.postid}/comments`, {
                    body: this.comment,
                },
                {
                    headers: {
                        Accept: 'application/json',
                        Authorization: 'Bearer ' + this.user.api_token
                    }
                }
            )
                .then(res => {
                    this.comments.unshift(res.data);
                    this.comment = '';
                })
                .catch(err => {
                    console.log(err);
                })
        },

        listen() {
            Echo.private(`post-comment.${this.postid}`)
                .listen("PostCommentEvent", comment => {
                    this.comments.unshift(comment);
                })
        },
    }
}
</script>