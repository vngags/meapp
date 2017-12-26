<template>
    <div class="product-form">

        <page-loading v-if="loading"></page-loading>

        <div v-else>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control input-lg" placeholder="Product Title..." v-model="form.title">
            </div>

            <div class="form-group">
                <label>Product Images</label>
                <dropzone ref="child" :attachments_ids="child_attachments" :maxfile="10" :params="{'type':'image'}" @completed="get_images"></dropzone>
            </div>
            <div class="form-group">
                <label>Product Content</label>
                <textarea name="body" class="form-control" cols="30" rows="10" v-model="form.body"></textarea>
            </div>
            <button type="button" @click="save" class="btn btn-sm btn-primary">Upload</button>
        </div>
    </div>
</template>

<script>
    import {
        get,
        post
    } from '../../../api'
    import Dropzone from './Dropzone'
    export default {
        props: ['product_id'],
        components: {
            Dropzone
        },
        data() {
            return {
                form: {
                    title: null,
                    body: null,
                    attachments: [],
                    id: null
                },
                store_url: '/api/v1/post/store',
                child_attachments: [],
                loading: true
            }
        },
        mounted() {
            if (this.product_id) {
                this.fetchData()
                this.store_url = '/api/v1/post/update'
                this.form.id = this.product_id
            }else{
                this.loading = false
            }
        },
        methods: {
            fetchData() {
                this.loading = true
                post('/api/v1/post/get_product', {
                    product_id: this.product_id
                }).then(resp => {
                    this.form.title = resp.data.product.title
                    this.form.body = resp.data.product.body
                    this.child_attachments = resp.data.attachments
                    this.loading = false
                })
            },
            async save() {
                // await this.$refs.child.submited()
                post(this.store_url, this.form)
                    .then(resp => {
                        if (resp.data.status == 'success') {
                            window.location.href = `/${this.user.slug}/post/${resp.data.product.slug}`
                        }
                    })
            },
            get_images(data) {
                // this.form.attachments = []
                // data.forEach((image) => {                    
                //     this.form.attachments.push(image.id)
                //     console.log(image.id);
                // })
                this.form.attachments.push(data)
            }
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