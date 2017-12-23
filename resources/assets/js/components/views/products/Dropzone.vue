<template>
    <div>
        <div class="previews"></div>
        <form class="dropzone">
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
    import 'dropzone/dist/dropzone.css'
    // import '../../../../../../public/plugins/vue2dropzone/vue2Dropzone.css'
    export default {
        mounted() {
            var myDropzone = new Dropzone(".dropzone", {
                url: '/api/v1/media/upload',
                thumbnailWidth: 150,
                thumbnailHeight: 150,
                maxFilesize: 5,
                maxFiles: 10,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                createImageThumbnails: true,
                uploadMultiple: false,
                paramName: "product_images",
                parallelUploads: 1,
                dictDefaultMessage: 'Kéo thả hình ảnh hoặc click vào đây',
                dictMaxFilesExceeded: 'Số lượng hình ảnh đã đạt tối đa (10 ảnh)',
                dictInvalidFileType: 'Loại tệp tin không được hỗ trợ',
                dictFallbackMessage: 'Trình duyệt của bạn không hỗ trợ kéo thả tệp tin',
                dictFileTooBig: "Kích thước quá lớn ({{filesize}}MB). Tối đa: {{maxFilesize}}MB",
                dictInvalidFileType: 'Loại tệp tin không được hỗ trợ',
                dictResponseError: "Server responded with {{statusCode}} code",
                dictCancelUpload: 'Hủy tải lên',
                dictCancelUploadConfirmation: 'Bạn có muốn hủy tải lên?',
                dictRemoveFile: 'Xóa',
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                // previewsContainer: '.previews',                
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                init: function () {
                    let dz = this
                    this.on('success', function (file, response) {
                        file.filename = response.name

                    });

                    this.on("removedfile", function (file) {
                        post('/api/v1/media/delete', {
                            product_image: file.filename
                        }).then(resp => {
                            // if(resp.data.status == 'deleted') {
                            //     this.removeFile(file);
                            // }                   
                            console.log('removed');
                        })
                    });

                    get('/api/v1/media/list')
                    .then(resp => {
                        resp.data.forEach((img) => {
                            var thumb = {
                                name: img.name,
                                size: img.size,
                                dataURL: '/images/' + img.fullname,
                                filename: img.name
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

                }
            });
            Dropzone.autoDiscover = false;
        }
    }
</script>