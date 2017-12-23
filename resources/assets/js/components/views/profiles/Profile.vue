<template>
    <div class="profile container">
        <transition name="fade">
            <div v-if="profile_user.uid" class="profile-avatar">
                <div class="border-outline outline-circle _ibi">
                    <img :src="profile_user.avatar" class="img-circle" width="96">
                </div>
                <div class="profile-info">
                    <ul>
                        <li>Name: {{ profile_user.name }}</li>
                        <li>Slug: {{ profile_user.slug }}</li>
                        <li>Email: {{ profile_user.email }}</li>
                        <li>About: {{ profile_user.profile.about }}</li>
                        <li>Phone: {{ profile_user.profile.phone_number }}</li>
                    </ul>
                </div>

                <follow :slug="profile_user.slug"></follow>

                <div class="form-group">
                    <a @click="show_qrcode" class="dropdown-toggle" id="show-qrcode" data-tooltip="QRCODE" data-placement="top">
                        <i class="fa fa-qrcode"></i>
                    </a>
                    <qr-code v-if="profile_user.uid" ref="qrcode" :avatar="profile_user.avatar" :url="'http://coccoc.me/'+profile_user.slug"
                        style="display:none"></qr-code>
                </div>

                <div class="form-group">
                    <h4>Following
                        <span v-if="profile_user.followings.length > 0" class="badge">{{ profile_user.followings.length }}</span>
                    </h4>
                    <transition name="fadebg">
                        <div v-if="profile_user.followings.length > 0" v-for="following in profile_user.followings">
                            <a :href="'/' + following.slug" class="border-outline outline-circle">
                                <img :src="following.avatar" width="28" class="img-circle">
                            </a>
                        </div>
                    </transition>
                </div>

                <div class="form-group">
                    <h4>Followers
                        <span v-if="profile_user.followers.length > 0" class="badge">{{ profile_user.followers.length }}</span>
                    </h4>
                    <transition name="fadebg">
                        <div v-if="profile_user.followers.length > 0" v-for="follower in profile_user.followers">
                            <a :href="'/' + follower.slug" class="border-outline outline-circle">
                                <img :src="follower.avatar" width="28" class="img-circle">
                            </a>
                        </div>
                    </transition>
                </div>

                <div class="rules_permissions">
                    <h4>Vai trò</h4>
                    <li>{{ profile_user.rule[0] }}</li>
                    <hr>
                    <h4>Permissions</h4>
                    <li v-for="permission in profile_user.permissions">{{ permission.name }}</li>
                </div>
                <div class="products">
                    <h4>Products</h4>
                    <ul>
                        <li v-for="product in profile_user.products">
                            <h5>
                                <a :href="'/' + profile_user.slug + '/post/' + product.slug">{{product.title}}</a>
                            </h5>
                            <span>{{ product.body }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import {
        get,
        post
    } from '../../../api'
    import QrCode from './QRcode'
    export default {
        props: ['slug'],
        components: {
            QrCode
        },
        mounted() {
            this.get_user_data()            
        },
        methods: {
            get_user_data() {
                get(`/api/v1/${this.slug}`)
                    .then(resp => {
                        // console.log(resp);
                        this.$store.commit('add_profile_user_data', resp.data)
                    })
            },
            async show_qrcode() {

                await this.$refs.qrcode.set_QRCode()

                var src = $('.qr-code img').attr('src');
                swal({
                    title: 'QR CODE',
                    text: `Quét mã QR Code của ${this.profile_user.name}`,
                    imageUrl: src,
                    width: 280,
                    imageWidth: 200,
                    imageHeight: 200,
                    imageAlt: 'QRCode',
                    showCancelButton: false,
                    showConfirmButton: false,
                    animation: false
                }).catch(swal.noop);
            },            
        },
        computed: {
            user() {
                return this.$store.getters.get_auth_user_data
            },
            profile_user() {
                return this.$store.getters.get_profile_user_data
            }
        }
    }
</script>

<style>

</style>