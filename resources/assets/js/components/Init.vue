<template></template>
<script>
    import {get, post} from '../api'
    var config = require('../config')
    export default {
        mounted() {
            get(`/${config.api.version}/user`)
            .then(resp => {
               this.$store.commit('add_auth_user_data', resp.data)                
            })
        }
    }
</script>