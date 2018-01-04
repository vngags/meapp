<template>
    <div>
        <transition name="fade">
            <div class="previews"></div>
        </transition>
        <form ref="myDropzone" class="dropzone" id="product_image">
            <div class="fallback">
                <input name="file[]" type="file" multiple />
            </div>
        </form>

        <image-modal :arrayImages="arrayImages" :dataImage="dataImage" :type="'show'" :author_uid="user.uid"></image-modal>
        
    </div>
</template>

<script>
    import {
        get,
        post
    } from '../../../api'
    import Dropzone from 'dropzone/dist/dropzone.js'
    import '../../../../../../public/plugins/vue2dropzone/vue2Dropzone.css'
    import ImageModal from './ImageModal'
    var config = require('../../../config')
    export default {
        components: {
            ImageModal
        },
        props: ['attachments_ids', 'params', 'maxfile'],
        data() {
            return {
                myDropzone: null,
                dataImage: {
                    id: null,
                    url: null,
                    price: null,
                    caption: null
                },
                arrayImages: []
            }
        },
        watch: {
            'attachments_ids': 'fetchImage'
        },
        mounted() {
            let vm = this
            this.setup_dropzone()
            Dropzone.autoDiscover = false;
            this.fetchImage()

            $('.previews').delegate('.edit-image', 'click', function () {
                var id = $(this).attr('data-id')
                vm.show_modal_image(id)
                $('#modal_image').modal({
                    backdrop: 'static',
                    keyboard: false
                }).on('hidden.bs.modal', function (e) {
                    vm.clear_dataImage()
                });
            });
        },
        methods: {
            clear_dataImage() {
                this.dataImage.id = null
                this.dataImage.url = null
                this.dataImage.price = null
                this.dataImage.caption = null
            },
            show_modal_image(id) {    
                let vm = this            
                var image = this.arrayImages.find(i => {
                    return i.dataId == id
                })
                var index = this.arrayImages.indexOf(image);
                this.dataImage.id = this.arrayImages[index].dataId
                this.dataImage.url = this.arrayImages[index].dataURL
                this.dataImage.price = this.arrayImages[index].dataPrice
                this.dataImage.caption = this.arrayImages[index].dataCaption               
            },
            fetchImageDetail() {
                let vm = this
                post(`/${config.api.version}/_get/media_detail`, {
                    dataId: vm.dataImage.id
                }).then(resp => {
                    if (resp.data.status == 'success') {
                        vm.dataImage.price = resp.data.data.price
                        vm.dataImage.caption = resp.data.data.caption
                    } else {
                        vm.dataImage.price = null
                        vm.dataImage.caption = null
                    }
                })
            },
            setup_dropzone() {
                let vm = this
                vm.myDropzone = new Dropzone(".dropzone", {
                    url: `/${config.api.version}/media/upload`,
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    maxFilesize: 5,
                    maxFiles: this.maxfile,
                    params: this.params,
                    acceptedFiles: ".jpeg,.jpg,.png,.gif",
                    createImageThumbnails: true,
                    uploadMultiple: false,
                    paramName: "product_images",
                    parallelUploads: 1,
                    dictDefaultMessage: '',
                    dictMaxFilesExceeded: 'Số lượng hình ảnh đã đạt tối đa (10 ảnh)',
                    dictInvalidFileType: 'Loại tệp tin không được hỗ trợ',
                    dictFallbackMessage: 'Trình duyệt của bạn không hỗ trợ kéo thả tệp tin',
                    dictFileTooBig: "Kích thước quá lớn ({{filesize}}MB). Tối đa: {{maxFilesize}}MB",
                    dictInvalidFileType: 'Loại tệp tin không được hỗ trợ',
                    dictResponseError: "Server responded with {{statusCode}} code",
                    dictCancelUpload: 'Hủy tải lên',
                    dictCancelUploadConfirmation: 'Bạn có muốn hủy tải lên?',
                    dictRemoveFile: '',
                    acceptedFiles: 'image/*',
                    addRemoveLinks: true,
                    previewsContainer: '.previews',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function () {
                        let dz = this
                        this.on('success', function (file, response) {
                            file.filename = response.name
                            file.dataURL = '/images/' + response.fullname
                            file.id = response.id
                            vm.$emit('completed', response.id)

                            vm.arrayImages.push({
                                dataURL: response.fullname,
                                dataFileName: response.name,
                                dataId: response.id,
                                dataThumb: response.thumb,
                                dataPrice: null,
                                dataCaption: null
                            });

                            var button = document.createElement('button');
                            button.innerHTML =
                                '<i class="fa fa-cogs" aria-hidden="true"></i>';
                            button.setAttribute("class",
                                "edit-image btn btn-warning btn-xs btn-circle");
                            button.setAttribute('data-tooltip', 'Thêm chi tiết')
                            button.setAttribute('data-placement', 'top')
                            button.setAttribute('data-id', response.id);
                            button.setAttribute('data-url', response.fullname);
                            file.previewTemplate.appendChild(button);
                        });

                        this.on("removedfile", function (file) {
                            post(`/${config.api.version}/media/delete`, {
                                product_image: file.filename
                            }).then(resp => {
                                if (resp.data.status == 'deleted') {
                                    var image = vm.arrayImages.find(i => {
                                        return i.dataFileName == file.filename
                                    })
                                    var index = vm.arrayImages.indexOf(image);
                                    vm.arrayImages.splice(index, 1)
                                }
                            })
                        });

                        this.on("maxfilesexceeded", function (file) {
                            file.removeFile();
                        });

                        this.on("error", function (file, message) {
                            setTimeout(() => {
                                this.removeFile(file);
                            }, 5000)
                        });
                    }
                });

            },

            fetchImage() {
                let dz = this.myDropzone
                let vm = this

                if (this.attachments_ids && this.attachments_ids.length > 0) {
                    var ids = this.attachments_ids.join()
                    get(`/${config.api.version}/_get/get_images/?images=${ids}`)
                        .then(resp => {
                            resp.data.forEach((image) => {
                                var thumb = {
                                    name: image.name,
                                    size: image.size,
                                    dataURL: '/images/' + image.fullname,
                                    filename: image.name,
                                    id: image.id
                                };
                                this.arrayImages.push({
                                    dataURL: image.fullname,
                                    dataFileName: image.name,
                                    dataId: image.id,
                                    dataThumb: image.thumb,
                                    dataPrice: image.price,
                                    dataCaption: image.caption
                                });
                                dz.files.push(thumb);
                                dz.emit('addedfile', thumb);
                                dz.createThumbnailFromUrl(thumb,
                                    dz.options.thumbnailWidth, dz.options.thumbnailHeight,
                                    dz.options.thumbnailMethod, true,
                                    function (thumbnail) {
                                        dz.emit('thumbnail', thumb, thumbnail);
                                        var button = document.createElement('button');
                                        // var text = document.createTextNode('+ Thêm')
                                        // button.appendChild(text); 
                                        if (image.price || image.caption) {
                                            button.innerHTML =
                                                '<i class="fa fa-check" aria-hidden="true"></i>';
                                            button.setAttribute("class",
                                                "edit-image btn btn-success btn-xs btn-circle");
                                        } else {
                                            button.innerHTML =
                                                '<i class="fa fa-cogs" aria-hidden="true"></i>';
                                            button.setAttribute("class",
                                                "edit-image btn btn-warning btn-xs btn-circle");
                                        }

                                        button.setAttribute('data-tooltip', 'Thêm chi tiết')
                                        button.setAttribute('data-placement', 'top')
                                        button.setAttribute('data-id', image.id);
                                        button.setAttribute('data-url', image.fullname);
                                        thumb.previewTemplate.appendChild(button);

                                    });
                                dz.emit('complete', thumb);
                            })
                        })

                } //endif
            },
            
            
        }, //methods
        computed: {
            user() {
                return this.$store.getters.get_auth_user_data
            }
        }
    }
</script>

<style>
    #product_image {
        width: 150px;
        height: 150px;
        display: inline-block;
    }

    .previews {
        display: inline-block;
        float: left;
    }

    .dz-default.dz-message {
        margin: 0;
        width: 100%;
        height: 100%;
        border: 2px dashed rgba(0, 0, 0, 0.1);
        background: rgba(0, 0, 0, 0.01);
        color: #838383;
        transition: all 0.3s linear;
        position: relative;
        border-radius: 20px;
    }


    .dz-default.dz-message>span::before {
        content: "\f093";
        font-family: FontAwesome;
        font-size: 44px;
        line-height: 110px;
        color: rgba(0, 0, 0, 0.18);
        transition: all 0.3s linear;
    }

    .dz-default.dz-message>span::after {
        content: "Upload Images";
        display: block;
        position: absolute;
        bottom: 10px;
        font-weight: bold;
        text-align: center;
        width: 100%;
        font-size: 12px;
    }

    #product_image:hover .dz-default span::before {
        color: rgba(0, 0, 0, 0.2);
    }

    #product_image:hover .dz-default {
        border-color: rgba(0, 0, 0, 0.1);
        background: rgba(0, 0, 0, 0.05);
    }   


     ::-webkit-input-placeholder {
        /* WebKit browsers */
        color: #999;
    }

     :-moz-placeholder {
        /* Mozilla Firefox 4 to 18 */
        color: #999;
    }

     ::-moz-placeholder {
        /* Mozilla Firefox 19+ */
        color: #999;
    }

     :-ms-input-placeholder {
        /* Internet Explorer 10+ */
        color: #999;
    }

    
</style>