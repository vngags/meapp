<template>
    <div class="product-form">

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control input-lg" placeholder="Product Title..." v-model="form.title">
        </div>

        <div class="form-group">
            <label>Product Images</label>
            <dropzone ref="child"></dropzone>
        </div>
        <div class="form-group">
            <label>Product Content</label>
            <textarea name="body" class="form-control" cols="30" rows="10" v-model="form.body"></textarea>
        </div>
        <button type="button" @click="child_upload" class="btn btn-primary">Upload</button>
    </div>
</template>

<script>
    import Dropzone from './Dropzone'
    export default {
        components: {
            Dropzone
        },
        data() {
            return {
                form: [],
                
            }
        },
        methods: {
            async child_upload() {
                await this.$refs.child.upload() // undefined
                console.log(2);
                
            }
        }
    }
</script>

<style>
    
 </style>