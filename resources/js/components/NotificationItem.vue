<template>
    <li @click="markAsRead">
        <a :href="postUrl">
            {{ unread.data.user.name }} commented on {{ unread.data.post.title }}
        </a>
    </li>
</template>

<script>
    export default {
        props:{
            unread:Object,
        },

        data(){
            return {
                postUrl:'',
            }
        },

        methods:{
            markAsRead : function(){
                console.log(this.unread.id);
                // axios.get(`/markAsRead/${this.unread.id}`);
            }
        },
        mounted(){
            this.postUrl='/posts/'+this.unread.data.post.id;
        }
    }
</script>
