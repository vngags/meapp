<template></template>
<script>
    import {get, post} from '../api'
    export default {
        mounted() {
            get(`/api/v1/user`)
            .then(resp => {
               this.$store.commit('add_auth_user_data', resp.data)                
            })
        }
    }
</script>