<template>
    <div class="profile">
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
    import {get, post} from '../../../api'
    export default {
        props: ['slug'],
        data() {
            return {
                profile_data: []
            }
        },
        mounted() {
            this.get_user_data()            
        },
        methods: {
            get_user_data() {                
                get(`/api/v1/${this.slug}`)
                .then(resp => {
                    this.profile_data = resp.data
                })
            },
            save() {
                post(`/api/v1/update_profile`, this.profile_data)
                .then(resp => {
                    window.location.href=`/${resp.data.slug}`          
                });
            }
        },
        computed: {
            user() {
                return this.$store.getters.get_auth_user_data
            }
        }
    }
</script>