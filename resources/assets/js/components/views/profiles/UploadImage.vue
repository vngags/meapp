<template>
    <div>
        <div class="previews"></div>
        <form ref="myDropzone" class="dropzone" id="product_image">
            <div class="fallback">
                <input name="file[]" type="file" multiple />
            </div>
        </form>
    </div>
</template>

<script>
    import {
        get,
        post
    } from '../../../api'
    import Dropzone from 'dropzone/dist/dropzone.js'
    // import 'dropzone/dist/dropzone.css'
    import '../../../../../../public/plugins/vue2dropzone/vue2Dropzone.css'
    export default {
        props: ['attachments_ids'],
        data() {
            return {
                myDropzone: null
            }
        },
        mounted() {
            this.setup_dropzone()
            Dropzone.autoDiscover = false;
        },
        methods: {
            async setup_dropzone() {
                let vm = this
                vm.myDropzone = new Dropzone(".dropzone", {
                    url: '/api/v1/media/upload',
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    maxFilesize: 5,
                    maxFiles: 1,
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
                        });

                        this.on("maxfilesexceeded", function (file) {
                            this.removeAllFiles();
                            this.addFile(file);
                        });

                        this.on("removedfile", function (file) {
                            post('/api/v1/media/delete', {
                                product_image: file.filename
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
        },
        watch: {
            attachments_ids() {
                let dz = this.myDropzone
                let vm = this
                if (this.attachments_ids && this.attachments_ids.length > 0) {
                    dz.removeAllFiles() //clean all file before push new
                    this.attachments_ids.forEach((item) => {
                        vm.$emit('completed', item)
                        get('/api/v1/media/get_image/' + item)
                            .then(resp => {
                                var thumb = {
                                    name: resp.data.name,
                                    size: resp.data.size,
                                    dataURL: '/images/' + resp.data.fullname,
                                    filename: resp.data.name,
                                    id: resp.data.id
                                };
                                dz.files.push(thumb);
                                dz.emit('addedfile', thumb);
                                dz.createThumbnailFromUrl(thumb,
                                    dz.options.thumbnailWidth, dz.options.thumbnailHeight,
                                    dz.options.thumbnailMethod, true,
                                    function (thumbnail) {
                                        dz.emit('thumbnail', thumb, thumbnail);
                                    });
                                dz.emit('complete', thumb);

                            })
                    })
                } //endif
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
</style>