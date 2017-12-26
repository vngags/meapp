<template>
    <div class="follow">
        <!-- Loading -->
        <button v-show="loading" type="button" class="btn button-default disabled minw80 relative loading btn-circle">
            <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
            </div>  
        </button>
        <!-- \Loading -->
            <button @click="addFollow" v-show="!loading" v-if="status == 0" type="button" class="btn btn-primary btn-circle bold btn-outline"><i class="fa fa-user-plus"></i> Theo dõi</button>
            <button @click="removeFollow" v-show="!loading" v-if="status == 'following'" type="button" class="btn btn-default btn-circle bold btn-outline"><i class="fa fa-times"></i> Hủy theo dõi</button>
    </div>
</template>

<script>
    import {get, post} from '../../../api'
    export default {
        props: ['slug'],
        data() {
            return {
                loading: true,
                status: null
            }
        },
        mounted() {
            this.check_follow()            
        },
        methods: {
            check_follow() {
                post(`/api/v1/check_following`, {
                    user_slug: this.slug
                }).then(resp => {
                    if(resp.data.status == 0) {
                        this.status = 0                    
                    }
                    if(resp.data.status == 'following') {
                        this.status = 'following'
                    }
                    this.loading = false
                })
            },
            addFollow() {
                this.loading = true
                post('/api/v1/add_following', {
                    user_slug: this.slug
                }).then(resp => {                           
                    if(resp.data.status == 'following') {
                        this.status = 'following'
                        this.$store.commit('add_new_following', {
                            slug: this.user.slug,
                            avatar: this.user.avatar
                        })
                    }
                    this.loading = false
                })
            },
            removeFollow() {
                this.loading = true
                post('/api/v1/remove_following', {
                    user_slug: this.slug
                }).then(resp => {
                    if(resp.data.status == 'removed') {
                        this.status = 0
                        this.$store.commit('remove_following', this.user.slug)
                    }
                    this.loading = false
                })
            }
        },
        computed: {
            user() {
                return this.$store.getters.get_auth_user_data
            },
            
        }
    }
</script>

<style>
.size-lg .btn {
    height: 40px !important;
    border-radius: 20px;
    font-size: 15px;
    padding: 0 20px;
}
.size-sm .btn {
    height: 28px !important;
    border-radius: 14px;
    font-size: 12px;
    padding: 0 15px;
}
.size-xs .btn {
    height: 22px !important;
    border-radius: 11px;
    font-size: 12px;
    padding: 0 10px;
}
.follow button {
    font-size: 13px;
    min-width: 80px;
    padding: 0 18px;
    height: 36px;
}
.follow .dropdown-menu a {
    font-size: 13px;
}
.follow .btn.disabled {
    background: rgba(0,0,0,0.1);
    cursor: default;
    position: relative;
}
.follow .btn.disabled.loading {
    height: 36px;
}
.follow .btn.disabled.loading.btn-sm {
    height: 28px;
}
.follow .btn.disabled.loading .spinner {
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 36px;
    height: 12px;
    margin: 0;
    z-index: 1;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}
.follow .btn.disabled.loading .spinner .bounce1 {
    -webkit-animation-delay: -0.32s;
    animation-delay: -0.32s;
}
.follow .btn.disabled.loading .spinner .bounce2 {
    -webkit-animation-delay: -0.16s;
    animation-delay: -0.16s;
}
.follow .btn.disabled.loading .spinner > div {
    width: 12px;
    height: 12px;
    background-color: rgba(0, 0, 0, 0.3);
    border-radius: 100%;
    display: inline-block;
    -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
    animation: sk-bouncedelay 1.4s infinite ease-in-out both;
        animation-delay: 0s;
    float: left;
}
</style>