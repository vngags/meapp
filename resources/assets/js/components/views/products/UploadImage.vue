<template>
    <div>
        <div class="previews"></div>
        <vue-dropzone ref="myVueDropzone" id="product_image" data-container="body" data-toggle="popover" data-placement="top" @mouseover="mouseOver"
            :options="dropzoneOptions">
        </vue-dropzone>
    </div>
</template>

<script>
    import {
        get,
        post
    } from '../../../api'
    import vue2Dropzone from 'vue2-dropzone'
    import '../../../../../../public/plugins/vue2dropzone/vue2Dropzone.css'
    export default {
        components: {
            vueDropzone: vue2Dropzone
        },
        data() {
            return {
                total_progress: 0,
                dropzoneOptions: {
                    url: '/api/v1/media/upload',
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    maxFilesize: 5,
                    maxFiles: 10,
                    acceptedFiles: ".jpeg,.jpg,.png,.gif",
                    createImageThumbnails: true,
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
                    // autoProcessQueue: false,
                    previewsContainer: '.previews',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    // success: function(file, response) {
                    //   console.log(response);

                    // },

                    accept: function (file, done) {
                        console.log("Uploaded");
                        done();
                    },

                    init: function () {
                        let dz = this
                        // get('/api/v1/media/list')
                        //     .then(resp => {
                        //         resp.data.forEach((img) => {

                        //             var thumb = {
                        //                 name: img.name,
                        //                 size: img.size,
                        //                 dataURL: '/images/' + img.name
                        //             };
                        //             dz.files.push(thumb);
                        //             dz.emit('addedfile', thumb);
                        //             dz.createThumbnailFromUrl(thumb,
                        //                 dz.options.thumbnailWidth, dz.options.thumbnailHeight,
                        //                 dz.options.thumbnailMethod, true,
                        //                 function (thumbnail) {
                        //                     dz.emit('thumbnail', thumb, thumbnail);
                        //                 });
                        //             dz.emit('complete', thumb);

                        //         })
                        //     })

                        // this.on("sending", function (file) {
                        //     this.options.renameFilename = function (file) {
                        //         var ext = file.split('.').pop();
                        //         var filename = Date.now().toString(36) + Math.random().toString(36).substr(
                        //             2, 8);
                        //         return filename + '.' + ext;
                        //     }
                        // });

                        this.on("removedfile", function (file) {
                            post('/api/v1/media/destroy', {
                                name: file.filename
                            }).then(resp => {
                                console.log(resp);
                            })
                        });

                        // this.on("thumbnail", function (file, dataUrl) {

                        //     file.name = 'aaa.jpg'
                        //     console.log(file);
                            
                        // }),

                            this.on("success", function (file, response) {
                                // console.log(response);
                                file.filename = response.name
                                // this.removeFile(file);

                                // var thumb = {
                                //     name: response.name,
                                //     size: response.size,
                                //     dataURL: '/images/' + response.name
                                // };
                                // // dz.emit("thumbnail", thumb, "/images/" + response.name);
                                // dz.files.push(thumb);
                                // dz.emit('addedfile', thumb);
                                // dz.createThumbnailFromUrl(thumb,
                                //     dz.options.thumbnailWidth, dz.options.thumbnailHeight,
                                //     dz.options.thumbnailMethod, true,
                                //     function (thumbnail) {
                                //         dz.emit('thumbnail', thumb, thumbnail);
                                //     });

                                // dz.emit('complete', thumb);
                                var existingFileCount = 1; // The number of files already uploaded
                                dz.options.maxFiles = dz.options.maxFiles - existingFileCount;
                            });
                        this.on("error", function (file, message) {
                            this.removeFile(file);
                        });
                        // this.on("sending", function (file) {
                        //     dz.options.renameFilename = function (file) {
                        //         //keeping the file extension.
                        //         var ext = file.split('.').pop();
                        //         var filename = Date.now().toString(36) + Math.random().toString(36).substr(
                        //             2, 8);
                        //         return file.name = filename + '.' + ext;
                        //     };
                        // });

                        // dz.on('processingfile', function (file) {
                        //     var ext = file.split('.').pop();
                        //     var filename = Date.now().toString(36) + Math.random().toString(36).substr(
                        //         2, 8);
                        //     file.name = filename + '.' + ext;
                        // });

                    }, //init

                },
            }
        },
        mounted() {

        },
        methods: {
            async upload() {
                this.$refs.myVueDropzone.processQueue()
            },
            mouseOver() {
                $('[data-toggle="popover"]').popover()
            },
        }, //methods
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
        border: 2px dashed rgba(0, 0, 0, 0.08);
        background: rgba(0, 0, 0, 0.01);
        color: #838383;
        transition: all 0.3s linear;
        position: relative;
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