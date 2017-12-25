<template>
    <div class="profile">
        <page-loading v-if="!user.uid"></page-loading>
        <transition name="fade">
            <div v-if="user.uid" class="profile-header">

                <div class="profile-cover">
                    <div class="container">
                        <div class="border-outline outline-circle _ibi">
                            <img :src="user.avatar" class="img-circle" width="96">
                        </div>
                    </div>
                </div>

                <div class="container">
                    <h1>My Profile</h1>

                    <div class="profile-info">
                        <ul>
                            <li>Name: {{ user.name }}</li>
                            <li>Slug: {{ user.slug }}</li>
                            <li>Email: {{ user.email }}</li>
                            <li>About: {{ user.profile.about }}</li>
                            <li>Phone: {{ user.profile.phone_number }}</li>
                        </ul>
                    </div>
                    <qr-code v-if="user.uid" :avatar="user.avatar" :url="'http://coccoc.me/'+user.slug"></qr-code>
                    <div class="rules_permissions">
                        <h4>Vai trò</h4>
                        <li>{{ user.rule[0] }}</li>
                        <hr>
                        <h4>Permissions</h4>
                        <li v-for="permission in user.permissions">{{ permission }}</li>
                    </div>
                    <div class="products">
                        <h4>Products</h4>
                        <ul>
                            <li v-for="product in user.products">
                                <h5>
                                    <a :href="'/' + user.slug + '/post/' + product.slug">{{product.title}}</a>
                                </h5>
                                <span>{{ product.body }}</span>
                            </li>
                        </ul>
                    </div>
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

        },
        methods: {

        },
        computed: {
            user() {
                return this.$store.getters.get_auth_user_data
            }
        }
    }
</script>

<style>

</style>