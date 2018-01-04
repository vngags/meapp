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
                <dropzone ref="child" :attachments_ids="child_attachments" :maxfile="30" :params="{'type':'image'}" @completed="get_images"></dropzone>
            </div>

            <div class="form-group">
                <label>Product Content</label>
                <textarea name="body" class="form-control" cols="30" rows="10" v-model="form.body"></textarea>
            </div>

            <div class="form-group clearfix row">
                <div class="col-md-12">

                    <div class="form-group">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ price_label }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a @click="status_price = 0">Giá sản phẩm</a>
                                </li>
                                <li>
                                    <a @click="status_price = 2">Giá chỉ từ</a>
                                </li>
                                <li>
                                    <a @click="status_price = 1">Giá khuyến mãi</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="input-group" id="product-price">
                        <!-- /btn-group -->
                        <div v-if="status_price == 2">
                            <label>Giá thấp nhất</label>
                            <div class="input-group">
                                <input type="text" class="form-control" @blur="focusOut('start_price')" @focus="focusIn('start_price')" placeholder="Nhập giá thấp nhất" v-model="form.start_price">
                                <span class="input-group-addon">.000 đ</span>
                            </div>
                            <label>Giá cao nhất</label>
                            <div class="input-group">
                                <input type="text" class="form-control" @blur="focusOut('end_price')" @focus="focusIn('end_price')" placeholder="Nhập giá cao nhất" v-model="form.end_price">
                                <span class="input-group-addon">.000 đ</span>
                            </div>
                        </div>
                        <div v-if="status_price == 1">
                            <label>Giá cũ</label>
                            <div class="input-group">
                                <input type="text" class="form-control" @blur="focusOut('price')" @focus="focusIn('price')" placeholder="Nhập giá cũ" v-model="form.price">
                                <span class="input-group-addon">.000 đ</span>
                            </div>
                            <label>Giá khuyến mãi</label>
                            <div class="input-group">
                                <input type="text" class="form-control" @blur="focusOut('new_price')" @focus="focusIn('new_price')" placeholder="Nhập giá khuyến mãi" v-model="form.new_price">
                                <span class="input-group-addon">.000 đ</span>
                            </div>
                            <label v-if="form.old_price && form.new_price" class="price-alert">
                                {{ parseInt(form.new_price.replace('.', "")) - parseInt(form.old_price.replace('.', "")) < 0 ? 'Giảm: '+Math.abs(Math.round(((parseInt(form.new_price.replace('.', "")) - parseInt(form.old_price.replace('.', ""))) / parseInt(form.old_price.replace('.', ""))) * 100))+'%' : 'Lỗi: Giá KM phải thấp hơn giá cũ' }}
                            </label>
                        </div>
                        <div v-if="status_price == 0" class="input-group">
                            <input type="text" class="form-control" @blur="focusOut('price')" @focus="focusIn('price')" placeholder="Nhập giá sản phẩm" v-model="form.price">
                            <span class="input-group-addon">.000 đ</span>
                        </div>
                    </div>
                    <!-- /input-group -->
                </div>
            </div>
            <div class="form-group">
                <div class="pull-right">
                        <button v-if="product_id" type="button" @click="save" class="btn btn-sm btn-primary">Cập nhật</button>
                        <button v-else type="button" @click="save" class="btn btn-sm btn-primary">Đăng tin</button>
                </div>
                <div v-if="dataAuthor.slug" class="pull-left">
                    <a :href="'/'+dataAuthor.slug+'/post/'+form.slug" class="btn btn-sm btn-default"><i class="fa fa-mail-reply"></i> Quay lại bài viết</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        get,
        post
    } from '../../../api'
    import Dropzone from './Dropzone'
    var config = require('../../../config')

    export default {
        props: ['product_id'],
        components: {
            Dropzone
        },
        data() {
            return {
                form: {
                    title: null,
                    slug: null,
                    body: null,
                    attachments: [],
                    id: null,
                    price: null,
                    start_price: null,
                    end_price: null,
                    new_price: null
                },
                store_url: `/${config.api.version}/post/store`,
                child_attachments: [],
                loading: true,
                status_price: 0,
                price_label: 'Giá sản phẩm',
                dataAuthor: []
            }
        },
        mounted() {
            if (this.product_id) {
                this.fetchData()
                this.store_url = `/${config.api.version}/post/update`
                this.form.id = this.product_id
            } else {
                this.loading = false
            }
        },
        methods: {
            fetchData() {
                this.loading = true
                post(`/${config.api.version}/post/get_product`, {
                    product_id: this.product_id
                }).then(resp => {
                    this.form.title = resp.data.product.title
                    this.form.body = resp.data.product.body
                    this.form.slug = resp.data.product.slug
                    this.child_attachments = resp.data.attachments
                    this.dataAuthor = resp.data.user
                    this.loading = false
                    if(resp.data.product.price || resp.data.product.new_price) {
                        if(resp.data.product.price && resp.data.product.new_price) {
                            this.status_price = 1
                            this.form.price = resp.data.product.price
                            this.form.new_price = resp.data.product.new_price
                        }else{
                            this.status_price = 0
                            this.form.price = resp.data.product.price
                        }                        
                    }else if(resp.data.product.price_start || resp.data.product.price_end) {
                        if(resp.data.product.price_start && resp.data.product.price_end) {
                            this.form.start_price = resp.data.product.price_start
                            this.form.end_price = resp.data.product.price_end
                        }else if(resp.data.product.price_start) {
                            this.form.start_price = resp.data.product.price_start
                        }else{
                            this.form.end_price = resp.data.product.price_end
                        }
                        this.status_price = 2
                    }else{
                        this.status_price = 0
                    }
                })
            },
            async save() {
                // await this.$refs.child.submited()
                if (this.form.price && this.form.price != null) {
                    this.form.price = this.form.price.replace('.', "");
                }
                if (this.form.new_price && this.form.new_price != null) {
                    this.form.new_price = this.form.new_price.replace('.', "");
                }
                if (this.form.start_price && this.form.start_price != null) {
                    this.form.start_price = this.form.start_price.replace('.', "");
                }
                if (this.form.end_price && this.form.end_price != null) {
                    this.form.end_price = this.form.end_price.replace('.', "");
                }
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
            },
            focusOut(type) {
                if (type == 'price' && this.form.price && this.form.price != null) {
                    this.form.price = parseFloat(this.form.price).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                }
                if (type == 'new_price' && this.form.new_price && this.form.new_price != null) {
                    this.form.new_price = parseFloat(this.form.new_price).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                }
                if (type == 'start_price' && this.form.start_price && this.form.start_price != null) {
                    this.form.start_price = parseFloat(this.form.start_price).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                }
                if (type == 'end_price' && this.form.end_price && this.form.end_price != null) {
                    this.form.end_price = parseFloat(this.form.end_price).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                }
            },
            focusIn(type) {
                if (type == 'price' && this.form.price && this.form.price != null) {
                    this.form.price = this.form.price.replace('.', "");
                }
                if (type == 'new_price' && this.form.new_price && this.form.new_price != null) {
                    this.form.new_price = this.form.new_price.replace('.', "");
                }
                if (type == 'start_price' && this.form.start_price && this.form.start_price != null) {
                    this.form.start_price = this.form.start_price.replace('.', "");
                }
                if (type == 'end_price' && this.form.end_price && this.form.end_price != null) {
                    this.form.end_price = this.form.end_price.replace('.', "");
                }
            },
        },
        computed: {
            user() {
                return this.$store.getters.get_auth_user_data
            },
        },
        watch: {
            status_price() {
                if (this.status_price == 0) {
                    this.price_label = 'Giá sản phẩm';
                    this.form.start_price = null
                    this.form.end_price = null
                    this.form.new_price = null
                } else if (this.status_price == 1) {
                    this.price_label = 'Giá khuyến mãi';
                    this.form.start_price = null
                    this.form.end_price = null
                } else {
                    this.price_label = 'Giá chỉ từ';
                    this.form.price = null
                    this.form.new_price = null
                }
            },

        },
    }
</script>

<style>

</style>