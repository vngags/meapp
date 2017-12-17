<template>
    <div class="profile">
        <div v-if="profile_user" class="profile-avatar">
            <div class="border-outline outline-circle _ibi">
                <img :src="profile_user.avatar" class="img-circle" width="96">
            </div>
            <div class="profile-info">
                <ul>
                    <li>Name: {{ profile_user.name }}</li>
                    <li>Slug: {{ profile_user.slug }}</li>
                    <li>Email: {{ profile_user.email }}</li>
                    
                </ul>
            </div>
            <qr-code v-if="profile_user.uid" :avatar="profile_user.avatar" :url="'http://coccoc.me/'+profile_user.slug"></qr-code>
        </div>
    </div>
</template>

<script>
    import {get, post} from '../../../api'
    import QrCode from './QRcode'
    export default {        
        props: ['uid'],
        components: {
            QrCode
        },
        mounted() {
            this.get_user_data()            
        },
        methods: {
            get_user_data() {
                get(`/api/v1/${this.uid}`)
                .then(resp => {
                    // console.log(resp);
                    this.$store.commit('add_profile_user_data', resp.data)
                })
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