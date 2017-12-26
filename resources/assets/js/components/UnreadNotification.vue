<template lang="html">
    <li class="notifications dropdown">
        <!-- <transition name="fade">
            <div v-if="user.notifications"> -->
        <a class="notification" :data-count="[user.notifications && user.notifications.data.length]" :title="[user.notifications && user.notifications.data.length > 0 ? user.notifications.data.length : 'Không có'] + ' thông báo mới'"
            :class="{ 'show-count' : (user.notifications && user.notifications.data.length > 0) }" data-toggle="dropdown" role="button"
            aria-expanded="false" aria-haspopup="true">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px"
                viewBox="0 0 459.334 459.334" style="enable-background:new 0 0 459.334 459.334;" xml:space="preserve" width="18px"
                height="18px">
                <g>
                    <g>
                        <g>
                            <path d="M175.216,404.514c-0.001,0.12-0.009,0.239-0.009,0.359c0,30.078,24.383,54.461,54.461,54.461     s54.461-24.383,54.461-54.461c0-0.12-0.008-0.239-0.009-0.359H175.216z"
                                fill="#999" />
                            <path d="M403.549,336.438l-49.015-72.002c0-22.041,0-75.898,0-89.83c0-60.581-43.144-111.079-100.381-122.459V24.485     C254.152,10.963,243.19,0,229.667,0s-24.485,10.963-24.485,24.485v27.663c-57.237,11.381-100.381,61.879-100.381,122.459     c0,23.716,0,76.084,0,89.83l-49.015,72.002c-5.163,7.584-5.709,17.401-1.419,25.511c4.29,8.11,12.712,13.182,21.887,13.182     H383.08c9.175,0,17.597-5.073,21.887-13.182C409.258,353.839,408.711,344.022,403.549,336.438z"
                                fill="#999" />
                        </g>
                    </g>
                </g>
            </svg>
        </a>
        <ul v-if="user.notifications" class="dropdown-menu with-arrow with-arrow-center">
            <div class="notify-title">
                <h4>Thông báo</h4>
            </div>
            <div class="scroller" :style="{ 'max-height': winHeight + 'px' }">
                <li v-if="user.notifications.data.length == 0">
                    <p class="text-center text-brown pt20 pb20 mb0">Không có thông báo mới</p>
                </li>
                <li v-for="not in user.notifications.data" :class="[ not.read_at ? 'read' : 'unread' ]">
                    <a :href="not.data.url">
                        <div class="w55 pull-left">
                            <a :href="'/'+not.data.user.slug" class="border-outline outline-circle _ibi">
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
        <!-- </div>
        </transition> -->
    </li>
</template>

<script>
    import {
        get,
        post
    } from '../api'
    // import slimScroll from '../../../../public/plugins/slimscroll/jquery.slimscroll.min.js'

    export default {
        data() {
            return {
                winHeight: 0
            }
        },
        mounted() {
            let vm = this
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
        },
        computed: {
            user() {
                return this.$store.getters.get_auth_user_data;
            }
        },
        beforeDestroy() {
            window.removeEventListener("resize", this.getWinSize);
        },
    }
</script>