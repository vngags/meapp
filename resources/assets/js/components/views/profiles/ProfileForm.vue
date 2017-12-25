<template>
    <div class="profile">     
        <page-loading v-if="loading"></page-loading>
        <transition name="fade">
            <div v-if="profile_data.uid">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" v-model="profile_data.name">
                </div>
                <div class="form-group">
                    <label>Slug:</label>
                    <input type="text" name="name" v-model="profile_data.slug">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" name="name" v-model="profile_data.email">
                </div>
                <div class="form-group">
                    <label>Avatar:</label>
                    <img :src="profile_data.avatar" width="48">
                    <upload-image></upload-image>
                </div>
                <hr>
                <div class="form-group">
                    <label>About:</label>
                    <input type="text" name="name" v-model="profile_data.profile.about">
                </div>
                <div class="form-group">
                    <label>Phone:</label>
                    <input type="text" name="name" v-model="profile_data.profile.phone_number">
                </div>
                <hr>
                <div class="form-group">
                    <button @click="save" type="button" class="btn btn-primary">Save</button>
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
    import UploadImage from './UploadImage'
    export default {
        components: {
            UploadImage
        },
        // props: ['slug'],
        data() {
            return {
                profile_data: [],
                loading: true
            }
        },
        mounted() {
            // this.get_user_data()
        },
        methods: {
            // get_user_data() {
            //     this.loading = true
            //     get(`/api/v1/${this.slug}`)
            //         .then(resp => {
            //             this.profile_data = resp.data
            //             this.loading = false
            //         })
            // },
            save() {
                this.loading = true
                post(`/api/v1/update_profile`, this.profile_data)
                    .then(resp => {
                        this.loading = false
                        window.location.href = `/${resp.data.slug}`
                        // this.$store.commit('add_auth_user_data', resp.data)             
                    });
            }
        },
        computed: {
            user() {
                this.loading = false
                return this.$store.getters.get_auth_user_data
            }
        },
        watch: {
            user() {
                this.profile_data = {
                    uid: this.user.uid,
                    name: this.user.name,
                    email: this.user.email,
                    slug: this.user.slug,
                    avatar: this.user.avatar,
                    profile: this.user.profile,
                }
            }
        }
    }
</script>