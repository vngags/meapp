<template>
    <div class="white-bg">
        <page-loading v-if="loading"></page-loading>

        <div v-else class="panel panel-default">
            <div class="panel-heading clearfix">
                Product Detail
                <div v-if="user.uid" class="pull-right">
                    <span v-if="user && user.can['edit-post'] && user.uid === dataProduct.user.uid" style="margin-left:10px">
                        <a :href="'/'+dataProduct.user.slug+'/post/'+dataProduct.slug+'/edit'" class="btn btn-sm btn-primary">Chỉnh sửa</a>
                    </span>
                    <span v-if="user && user.can['delete-post'] && user.uid === dataProduct.user.uid">
                        <a @click="delete_post" class="btn btn-sm btn-danger">Xóa</a>
                    </span>
                </div>

            </div>

            <div class="panel-body">
                <h1>{{ dataProduct.title }}</h1>
                <small>
                    <a :href="'/'+dataProduct.user.slug">{{ dataProduct.user.name }}</a>
                </small>
                <div class="form-group">
                    <p>
                        {{ dataProduct.body }}
                    </p>
                    <!-- Price -->
                    <div class="product-price">

                    </div>
                    <!-- Price -->
                </div>
                <h4>Hình ảnh sản phẩm
                    <small class="badge">{{ dataProduct.attachments.length }}</small>
                </h4>
                <ul class="scroller scrollbar-macosx product-images list-inline">
                    <li v-for="attachment in dataProduct.attachments" class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <a href="" @click.prevent="modal_image(attachment.id)" class="border-outline _ibi">
                            <img :src="'/images/'+attachment.large">

                            <div v-if="attachment.detail.price" class="image-price">
                                <span>{{ attachment.detail.price }}.000 đ</span>
                            </div>

                        </a>
                    </li>
                </ul>
            </div>
            <div class="panel-footer">
                <a href="/" class="btn btn-sm btn-default">Back to home</a>
            </div>
            <image-modal :arrayImages="arrayImages" :dataImage="dataImage" :type="'show'" :author_uid="dataProduct.user.uid"></image-modal>
        </div>        
    </div>
</template>

<script>
    import {
        get,
        post
    } from '../../../api'
    import ImageModal from './ImageModal'
    var config = require('../../../config')
    import scrollbar from '../../../../../../public/plugins/scrollbar/jquery.scrollbar.js'
    import '../../../../../../public/plugins/scrollbar/jquery.scrollbar.css'
    import '../../../../../../public/plugins/prettify/prettify.js'
    import '../../../../../../public/plugins/prettify/prettify.css'
    export default {
        components: {
            ImageModal
        },
        props: ['slug'],
        data() {
            return {
                dataProduct: [],
                loading: true,
                dataImage: {
                    id: null,
                    url: null,
                    price: null,
                    caption: null
                },
                arrayImages: []
            }
        },
        created() {
            let data = async () => {
                await this.fetchData()
                $('.scrollbar-macosx').scrollbar({
                    "autoScrollSize": true,
                });
            }
            data()
        },
        methods: {
            fetchData() {
                let vm = this
                return new Promise(function(resolve, reject) {
                    vm.loading = true
                    get(`/${config.api.version}/${vm.slug}`)
                    .then(resp => {
                        vm.dataProduct = resp.data
                        vm.loading = false
                        resp.data.attachments.forEach((image) => {
                            vm.arrayImages.push({
                                dataURL: image.fullname,
                                dataFileName: image.original_url,
                                dataId: image.id,
                                dataThumb: image.thumb,
                                dataPrice: image.detail.price,
                                dataCaption: image.detail.caption
                            });
                        })
                        resolve(vm.arrayImages)
                    })                   
                })
            },
            async modal_image(id) {
                let vm = this
                await this.show_modal_image(id)
                $('#modal_image').modal({
                    keyboard: false
                }).on('hidden.bs.modal', function (e) {
                    vm.clear_dataImage()
                });
            },
            clear_dataImage() {
                this.dataImage.id = null
                this.dataImage.url = null
                this.dataImage.price = null
                this.dataImage.caption = null
            },
            async show_modal_image(id) {
                var image = this.arrayImages.find(i => {
                    return i.dataId == id
                })
                var index = this.arrayImages.indexOf(image);               
                
                this.dataImage.id = this.arrayImages[index].dataId
                this.dataImage.url = this.arrayImages[index].dataURL
                this.dataImage.price = this.arrayImages[index].dataPrice
                this.dataImage.caption = this.arrayImages[index].dataCaption
            },
            delete_post() {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result) {
                        post(`/${config.api.version}/_post/delete_post`, {
                            postId: this.dataProduct.id
                        }).then(resp => {
                            if (resp.data.status == 'deleted') {
                                window.location.href = "/"
                            }
                        })
                    }
                })
            }
        },
        computed: {
            user() {
                return this.$store.getters.get_auth_user_data
            },

        }
    }
</script>