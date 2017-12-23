<template lang="html">
    <li class="notifications dropdown">
        <a class="notification" :data-count="notify.length" :title="[notify.length > 0 ? notify.length : 'Không có'] + ' thông báo mới'"
            :class="{ 'show-count' : notify.length > 0 }" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true"></a>
        <ul class="dropdown-menu with-arrow with-arrow-center">
            <div class="notify-title">
                <h4>Thông báo</h4>
            </div>
            <div class="scroller" :style="{ 'max-height': winHeight + 'px' }">
                <li v-if="notify.length == 0">
                    <p class="text-center text-brown pt20 pb20 mb0">Không có thông báo mới</p>
                </li>
                <li v-for="not in notify">
                    <a :href="not.data.url">
                        <div class="w55 pull-left">
                            <a :href="'/'+not.data.user.slug" class="border-outline outline-circle">
                                <img :src="not.data.user.avatar" width="48" class="img-circle">
                            </a>
                        </div>
                        <div class="ml55">
                            <a :href="'/'+not.data.user.slug">
                                <strong>{{ not.data.user.name }}</strong>
                            </a>
                            <span v-html="not.data.message"></span>
                            <p>
                                <small>
                                    <timeago :since="not.created_at ? not.created_at : new Date()" :auto-update="60"></timeago>
                                </small>
                            </p>
                        </div>
                    </a>
                </li>
            </div>
            <div class="notify-footer">
                <a href="/notifications" class="text-center block size13" target="_blank">Xem tất cả</a>
            </div>
        </ul>
        <audio id="bell_audio">
            <source src="/audio/notifications/notification48.mp3">
            <!-- <source src="/audio/notifications/chime.ogg">
            <source src="/audio/notifications/chime.m4r"> -->
        </audio>
    </li>
</template>

<script>
    import {
        get,
        post
    } from '../api'
    export default {
        data() {
            return {
                winHeight: 0
            }
        },
        mounted() {
            let vm = this
            this.get_unread_notifications()
            this.getWinSize();
            this.$nextTick(function () {
                window.addEventListener("resize", vm.getWinSize);
            });
        },
        methods: {
            getWinSize() {
                this.winWidth = document.documentElement.clientWidth;
                this.winHeight =
                    document.documentElement.clientHeight - 180 >= 100 ?
                    document.documentElement.clientHeight - 180 :
                    100;
            },
            get_unread_notifications() {
                let vm= this
                get('/api/v1/get_unread_notifications')
                .then(resp => {
                    resp.data.forEach((item) => {
                        this.$store.commit('add_unread_notification', item)
                    })                    
                })
            }
        },
        computed: {
            notify() {
                return this.$store.getters.get_notifications;
            }
        },
        beforeDestroy() {
            window.removeEventListener("resize", this.getWinSize);
        }
    }
</script>