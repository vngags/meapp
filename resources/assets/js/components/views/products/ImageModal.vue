<template>
    <!-- Modal -->
    <div class="modal fade" id="modal_image" tabindex="-1" role="dialog" aria-labelledby="ImageLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button @click="mode = 'show'" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="ImageLabel">Chi tiết mặt hàng</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body-wrapper row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" id="thumb-wrapper" style="padding-right:0">
                            <transition name="fade">
                                <ul v-if="arrayImages" class="modal-thumbnail thumb-slide scrollbar-macosx scroller">
                                    <li v-for="thumb in arrayImages" @click="show_modal_image(thumb.dataId)" :data-id="thumb.dataId" :data-url="thumb.dataURL"
                                        :class="{ active: dataImage.id == thumb.dataId }">
                                        <img :src="'/'+thumb.dataThumb">
                                    </li>

                                </ul>
                            </transition>
                        </div>
                        <div class="col-md-12 col-md-offset-2 col-lg-12 col-lg-offset-2 col-sm-12 col-sm-offset-2 col-xs-12 col-xs-offset-2">
                            <transition name="fade">
                                <img v-if="dataImage.url" id="large-image" :src="'/images/'+dataImage.url">
                            </transition>
                        </div>
                        <!-- Update Type -->
                        <div v-if="mode == 'update'" class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                            <div id="product-price" class="input-group clearfix">
                                <h4>Giá bán (tùy chọn)</h4>
                                <div class="input-group">
                                    <input id="product-price-input" type="text" v-on:keypress="isNumber" class="form-control" placeholder="Nhập giá sản phẩm"
                                        autofocus v-model="dataImage.price">
                                    <span class="input-group-addon">.000 đ</span>
                                </div>
                            </div>
                            <div id="image-caption" class="clearfix">
                                <h4>Mô tả (tùy chọn)</h4>
                                <transition name="fade">
                                    <textarea v-if="dataImage" id="product-detail-input" :class="{ error : parseInt(inputData.caption) < 0 }" rows="2" cols="80"
                                        placeholder="Viết vài dòng mô tả" class="form-control" v-model="dataImage.caption"></textarea>
                                </transition>
                                <span class="pull-right" :class="{ error : parseInt(inputData.caption) < 0 }">{{ inputData.caption }}</span>
                            </div>
                            <div class="modal-body-alert">
                                Mẹo: Bạn có thể thêm giá bán và mô tả chi tiết cho mỗi hình ảnh mặt hàng
                            </div>
                        </div>
                        <!-- \Update Type -->
                        <!-- Show Type -->
                        <div v-else class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                            <div class="product-image-detail">
                                <!-- Dropdown Button Icon -->
                                <ul v-if="author_uid && user.uid == author_uid && user.can['edit-post']" class="dropdown edit-action-btn">
                                    <li>
                                        <a data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                            <img src="/images/svg/three-dots-menu.svg" alt="">
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a @click="mode = 'update'" href="#">Chỉnh sửa</a>
                                            </li>
                                            <li>
                                                <a href="#">Xóa</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <!-- Dropdown Button Icon -->
                                <div id="product-price" class="clearfix">
                                    <h4>Giá bán</h4>
                                    <h4 v-if="dataImage.price" class="price">
                                        {{ dataImage.price }}.000 đ
                                    </h4>
                                    <h4 v-else class="price">Đang cập nhật</h4>
                                </div>
                                <div id="image-caption" class="clearfix">
                                    <h4>Mô tả</h4>
                                    <h5 v-if="dataImage.caption" class="caption">{{ dataImage.caption }}</h5>
                                    <h5 v-else class="caption">Đang cập nhật</h5>
                                </div>
                            </div>
                            <div v-if="author_uid && user.uid != author_uid" class="modal-body-message">
                                <button class="btn btn-lg btn-primary btn-circle btn-block">
                                    <i class="fa fa-comment"></i> Nhắn tin cho người bán</button>
                            </div>
                        </div>
                        <!-- \Show Type -->

                    </div>

                </div>
                <div class="modal-footer">
                    <div class="btn-group pull-left">
                        <button @click="prevImg(dataImage.id, dataImage.url)" type="button" class="btn btn-default btn-sm">
                            <i class="fa fa-arrow-left"></i> Ảnh trước</button>
                        <button @click="nextImg(dataImage.id, dataImage.url)" type="button" class="btn btn-default btn-sm">Ảnh sau
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                    <div v-if="mode == 'show'" class="modal-footer-alert">
                        Mẹo: Sử dụng phím
                        <i class="fa fa-long-arrow-left"></i> hoặc
                        <i class="fa fa-long-arrow-right"></i> để chuyển đổi hình ảnh
                    </div>
                    <div v-if="mode == 'update'">
                        <button @click="mode = 'show'" type="button" class="btn btn-danger btn-sm">
                            <i class="fa fa-times"></i> Hủy</button>
                        <!-- Loading -->
                        <button v-show="btn_loading" type="button" class="btn button-primary disabled minw60 relative loading">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </button>
                        <!-- \Loading -->
                        <button @click="saveImageDetail" v-show="!btn_loading" :class="{ disabled : parseInt(inputData.caption) < 0 }" type="button" class="btn btn-primary btn-sm">
                            <i class="fa fa-save"></i> Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
</template>

<script>
    import scrollbar from '../../../../../../public/plugins/scrollbar/jquery.scrollbar.js'
    import '../../../../../../public/plugins/scrollbar/jquery.scrollbar.css'
    import {
        get,
        post
    } from '../../../api'
    import autosize from 'autosize'
    var config = require('../../../config')
    export default {
        props: ['arrayImages', 'dataImage', 'type', 'author_uid'],
        data() {
            return {
                image_height: 422,
                mode: this.type,
                inputData: [],
                btn_loading: false
            }
        },
        mounted() {
            let vm = this
            window.addEventListener('keyup', function (event) {
                // If down arrow was pressed...
                if (event.keyCode == 39 && vm.mode == 'show') {
                    vm.nextImg(vm.dataImage.id, vm.dataImage.url)
                }
                if (event.keyCode == 37 && vm.mode == 'show') {
                    vm.prevImg(vm.dataImage.id, vm.dataImage.url)
                }
            });


            $('#modal_image').on('shown.bs.modal', function () {
                var image = vm.arrayImages.find(i => {
                    return i.dataId == vm.dataImage.id
                })
                var index = vm.arrayImages.indexOf(image);
                $('.scrollbar-macosx.modal-thumbnail').not('.scroll-wrapper').animate({
                    scrollTop: index * 47
                }, 500);
                var mode = async function () {
                    await vm.dataImage.caption
                    if (vm.mode == 'update') {
                        var textarea = document.getElementById('product-detail-input');
                        textarea.style.display = 'none';
                        autosize(textarea);
                        textarea.style.display = '';
                        autosize.update(textarea);
                    }
                }
                mode()
            }).on('show.bs.modal', function () {

            });
            $('.scrollbar-macosx').scrollbar();


        },
        methods: {
            isNumber: function (evt) {
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },
            show_modal_image(id) {
                let vm = this
                return new Promise((resolve, reject) => {
                    var image = vm.arrayImages.find(i => {
                        return i.dataId == id
                    })
                    var index = vm.arrayImages.indexOf(image);
                    $('.scrollbar-macosx.modal-thumbnail').not('.scroll-wrapper').animate({
                        scrollTop: index * 47
                    }, 500);
                    vm.dataImage.id = vm.arrayImages[index].dataId
                    vm.dataImage.url = vm.arrayImages[index].dataURL
                    vm.dataImage.price = vm.arrayImages[index].dataPrice
                    vm.dataImage.caption = vm.arrayImages[index].dataCaption
                    resolve(vm.dataImage)
                })
            },
            nextImg() {
                var image = this.arrayImages.find(i => {
                    return i.dataId == this.dataImage.id
                })
                var index = this.arrayImages.indexOf(image);
                if ((index + 1) >= this.arrayImages.length) {
                    this.dataImage.id = this.arrayImages[0].dataId
                    this.dataImage.url = this.arrayImages[0].dataURL
                    this.dataImage.price = this.arrayImages[0].dataPrice
                    this.dataImage.caption = this.arrayImages[0].dataCaption
                    $('.scrollbar-macosx.modal-thumbnail').not('.scroll-wrapper').animate({
                        scrollTop: 0
                    }, 500);
                } else {
                    this.dataImage.id = this.arrayImages[index + 1].dataId
                    this.dataImage.url = this.arrayImages[index + 1].dataURL
                    this.dataImage.price = this.arrayImages[index + 1].dataPrice
                    this.dataImage.caption = this.arrayImages[index + 1].dataCaption
                    $('.scrollbar-macosx.modal-thumbnail').not('.scroll-wrapper').animate({
                        scrollTop: (index + 1) * 47
                    }, 500);
                }
                // this.fetchImageDetail()
            },
            prevImg() {
                var image = this.arrayImages.find(i => {
                    return i.dataId == this.dataImage.id
                })
                var index = this.arrayImages.indexOf(image);
                if ((index - 1) < 0) {
                    this.dataImage.id = this.arrayImages[this.arrayImages.length - 1].dataId
                    this.dataImage.url = this.arrayImages[this.arrayImages.length - 1].dataURL
                    this.dataImage.price = this.arrayImages[this.arrayImages.length - 1].dataPrice
                    this.dataImage.caption = this.arrayImages[this.arrayImages.length - 1].dataCaption
                    $('.scrollbar-macosx.modal-thumbnail').not('.scroll-wrapper').animate({
                        scrollTop: (this.arrayImages.length - 1) * 47
                    }, 500);
                } else {
                    this.dataImage.id = this.arrayImages[index - 1].dataId
                    this.dataImage.url = this.arrayImages[index - 1].dataURL
                    this.dataImage.price = this.arrayImages[index - 1].dataPrice
                    this.dataImage.caption = this.arrayImages[index - 1].dataCaption
                    $('.scrollbar-macosx.modal-thumbnail').not('.scroll-wrapper').animate({
                        scrollTop: (index - 1) * 47
                    }, 500);
                }
                // this.fetchImageDetail()
            },
            saveImageDetail() {
                let vm = this
                if (this.inputData.caption > 0) {
                    this.btn_loading = true
                    post(`/${config.api.version}/_post/media_detail`, {
                        dataId: this.dataImage.id,
                        price: this.dataImage.price,
                        caption: this.dataImage.caption
                    }).then(resp => {
                        var image = vm.arrayImages.find(i => {
                            return i.dataId == resp.data.media_id
                        })
                        image.dataPrice = resp.data.media_price
                        image.dataCaption = resp.data.media_caption
                        vm.mode = 'show'
                        vm.btn_loading = false
                    })
                }
            }
        },
        computed: {
            user() {
                return this.$store.getters.get_auth_user_data
            }
        },
        watch: {
            'dataImage.caption': function () {
                if (this.dataImage.caption) {
                    //max length 255 characters
                    this.inputData.caption = parseInt(255 - this.dataImage.caption.length)
                }
            },
            'mode': async function () {
                await this.dataImage.caption
                if (this.mode == 'update') {
                    var textarea = document.getElementById('product-detail-input');
                    textarea.style.display = 'none';
                    autosize(textarea);
                    textarea.style.display = '';
                    autosize.update(textarea);
                }
            }
        }
    }
</script>

<style>
    #product-price h4,
    #image-caption h4 {
        text-align: left;
        font-size: 14px;
        font-weight: bold;
    }

    .modal-thumbnail {
        margin: 0;
        padding: 0;
        list-style: none;
        position: absolute !important;
        top: 0;
        left: 0;
        right: 10px;
        bottom: 0;
    }

    .modal-thumbnail li {
        border: 2px solid rgba(0, 0, 0, 0.1);
        margin-bottom: 5px;
        opacity: .7;
        transition: all 0.3s linear;
    }

    .modal-thumbnail li:hover {
        opacity: 1;
    }

    .modal-thumbnail li.active {
        border: 2px solid rgb(255, 168, 94);
        opacity: 1;
        transition: all 0.3s linear;
    }

    .thumb-slide {
        padding-right: 0;
        /* max-height: 422px; */
        /* min-height: 324px; */
    }

    .modal-body-wrapper {
        position: relative;
        display: flex;
    }

    .modal-body-wrapper .col-md-2 {
        position: absolute;
        height: 100%;
        display: block;
        top: 0;
        left: 10px;
        bottom: 10px;
        right: 10px;
    }

    .scrollbar-macosx.scroll-scrolly_visible {
        overflow-x: hidden !important;
        overflow-y: scroll !important;
    }

    .product-image-detail {
        margin-bottom: 50px;
    }

    .modal-body-message {
        position: absolute;
        bottom: 0;
        right: 10px;
        left: 10px;
    }

    .dropdown.edit-action-btn {
        position: absolute;
        top: 0;
        right: 10px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    #product-detail-input {
        resize: none;
    }

    #image-caption .caption {
        white-space: pre-wrap;
        line-height: 1.4em;
    }

    #image-caption span {
        font-size: 11px;
    }

    #image-caption span.error {
        color: #CC0000;
    }

    #product-detail-input.error {
        border-color: #CC0000;
        background: #FFDFDF;
    }

    .modal-footer-alert {
        font-size: 13px;
        font-style: italic;
        color: #999;
    }
    .loading {
        height: 29px;
    }
</style>