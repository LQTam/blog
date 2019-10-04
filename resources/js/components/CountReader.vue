<template>
    <div id="countReader" class="card-header">{{users.length}}</div>
</template>

<script>
    export default {
        props :{
            postid : Number,
        },
        data(){
            return {
                users : [],
            }
        },

        mounted(){
            this.listen();
        },

        methods:{
            listen: function(){
                Echo.join(`join-post.${this.postid}`)
                .here(users =>{
                    this.users = users;
                })
                .joining(user=>{
                    this.users.push(user)
                })
                .leaving(user=>{
                    this.users = this.users.filter(u => u.id != user.id);
                })
                // .listen('JoinPostChannel',user=>{
                //     this.users = user;
                //     console.log(user);
                // })
            }
        }
    }
</script>

<style>
    #countReader{
        position: fixed;
        right: 31%;
    }
</style>