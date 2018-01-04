<template>
    <div class="articles">
        <page-loading v-if="loading"></page-loading>
        <div v-if="!loading && products.length > 0" class="content clearfix">

            <!-- Loop product-item -->
            <div v-for="product in products" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-sx-24 product-item">
                <div class="white-bg">
                    <!-- Product Item Thumbnail -->
                    <div class="product-item-image">
                        <!-- Show Product Image -->
                        <ul v-if="product.attachments.length >= 3" class="list-inline attachments clearfix">                            
                                <li class="large-image">
                                    <a  class="border-outline" :href="'/'+product.user[0].slug+'/post/'+product.slug" :title="product.title">
                                        <img :src="'/images/'+product.user[0].uid+'/'+product.attachments[0].large" :title="product.title" :alt="product.title">
                                    </a>
                                </li>
                                <li class="small-image">
                                    <a  class="border-outline" :href="'/'+product.user[0].slug+'/post/'+product.slug" :title="product.title">
                                        <img :src="'/images/'+product.user[0].uid+'/'+product.attachments[1].small" :title="product.title" :alt="product.title">
                                    </a>
                                    <a  class="border-outline" :href="'/'+product.user[0].slug+'/post/'+product.slug" :title="product.title">
                                        <img :src="'/images/'+product.user[0].uid+'/'+product.attachments[2].small" :title="product.title" :alt="product.title">
                                        <div v-if="product.attachments.length > 3" class="image-count">
                                            <span>{{ '+' + (product.attachments.length - 3) }}</span>
                                        </div>
                                    </a>
                                </li>
                        </ul>
                        <ul v-if="product.attachments.length == 2" class="list-inline attachments clearfix">   
                            <li v-for="attachment in product.attachments" class="half-image">
                                <a  class="border-outline" :href="'/'+product.user[0].slug+'/post/'+product.slug" :title="product.title">
                                    <img :src="'/images/'+product.user[0].uid+'/'+attachment.half" :title="product.title" :alt="product.title">
                                </a>
                            </li>
                        </ul>
                        <ul v-if="product.attachments.length == 1" class="list-inline attachments clearfix">   
                            <li v-for="attachment in product.attachments" class="full-image">
                                <a  class="border-outline" :href="'/'+product.user[0].slug+'/post/'+product.slug" :title="product.title">
                                    <img :src="'/images/'+product.user[0].uid+'/'+attachment.full" :title="product.title" :alt="product.title">
                                </a>
                            </li>
                        </ul>
                        <!-- Show Product Image -->                        

                        <ul v-if="product.attachments.length == 0" class="list-inline attachments clearfix">
                            <li class="full-image">
                                <a class="border-outline" :href="'/'+product.user[0].slug+'/post/'+product.slug" :title="product.title">
                                    <img src="/images/no-image.png" :title="product.title" :alt="product.title">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Product Item Thumbnail -->
                    <!-- Product Item Body -->
                    <div class="product-item-body">
                        <h3>
                            <a :href="'/'+product.user[0].slug+'/post/'+product.slug" :title="product.title">
                                {{ product.title }}
                            </a>
                        </h3>
                        <span class="product-body">{{ product.body }}</span>	
                    </div>
                    <!-- Product Item Body -->
                    <!-- Product Item Footer -->
                    <div class="product-item-footer">
                        <div class="author">
                            <a :href="'/'+product.user[0].slug">
                                <div class="img-circle border-outline _ib outline-circle">
                                    <img :src="product.user[0].avatar" width="24" class="img-circle">
                                </div>
                            </a>
                            <a class="user_name" :href="'/'+product.user[0].slug">{{ product.user[0].name }}</a>
                            <ul class="coccoc-product-item-btn list-inline pull-right">
                                <li>
                                    <a href=""><i class="fa fa-comment"></i> 6</a>
                                </li>
                                <li><a href="" class="btn btn-default btn-xs"><i class="fa fa-bookmark"></i> Lưu</a></li>
                            </ul>
                        </div>			
                    </div>
                    <!-- Product Item Footer -->
                </div>
            </div>
            <!-- Loop product-item -->

 


        </div>
        <div v-if="products.length == 0">
            <p class="text-center">
                Khong tim thay noi dung phu hop
            </p>
        </div>
        <pagination v-if="products.length > 0" v-bind:pagination="pagination" v-on:click.native="getProducts(pagination.current_page)" :offset="4"></pagination>
        
    </div>
</template>

<script>
    import {
        get,
        post
    } from '../../../api'
    import Pagination from './Pagination'
    var config = require('../../../config')
    export default {
        components: { Pagination },
        props: ['page'],
        data() {
            return {
                loading: true,
                // products: [],
                pagination: {
                    total: 0,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,
                fetched_page: 0
            }
        },
        mounted() {
            if(this.page) {
                this.pagination.current_page = this.page
            }
            this.getProducts(this.pagination.current_page);
        },
        methods: {
            getProducts(page) {
                if(this.fetched_page != page) {
                    this.loading = true
                    get(`/${config.api.version}/_get/products?page=${page}`)
                        .then(resp => {
                            this.$store.commit('refresh_products', 0)
                            resp.data.data.forEach((item) => {
                                this.$store.commit('add_new_products', item)
                            })
                            // this.products = resp.data.products

                            this.pagination.total = resp.data.page.total
                            this.pagination.last_page = resp.data.page.last_page
                            this.pagination.current_page = resp.data.page.current_page
                            this.pagination.from = resp.data.page.from
                            this.pagination.to = resp.data.page.to

                            this.fetched_page = resp.data.page.current_page

                            this.loading = false
                            // $("html, body").animate({scrollTop: 0}, 0);
                            if(this.pagination.current_page > 1) {
                                window.history.pushState("object or string", "Title", "/?page="+resp.data.page.current_page);
                            }else{
                                window.history.pushState("object or string", "Title", "/");
                            }               
                                    
                        })
                }                
            }            
        },
        computed: {
            products() {
                return this.$store.getters.get_all_products
            }            
        },
    }
</script>