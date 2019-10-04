<template>
    <li class='nav-item dropdown'>
        <a id="notifyDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell position-relative">
                <span class="badge badge-light position-absolute text-danger" style='right:-9px;top:-5px' >{{unreadNotifications.length}}</span>
            </i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notifyDropdown">
            <a href="/markAllAsRead">Mark all as read</a>
            <notification-item v-for="unread in unreadNotifications" :unread='unread' :key='unread.id' ></notification-item>
        </ul>
    </li>

    
</template>

<script>
import NotificationItem from './NotificationItem.vue';
    export default {
        props:{
            unreads:Array,
            userid:Number,
        },

        components:{
            NotificationItem
        },

        data(){
            return {
                unreadNotifications : this.unreads,
            }
        },

        methods:{
            markAllAsRead(){
                if(this.unreadNotifications.length > 0){
                    axios.get('/markAllAsRead');
                }
            }
        },
        mounted() {
            Echo.private('App.User.' + this.userid)
                .notification((notification) => {
                    const newNotify = {data: {post:notification.post,user:notification.user}}
                    this.unreadNotifications.unshift(newNotify);
                });
        }
    }
</script>