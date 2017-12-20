<template>
    <div class="qrcode">
        <img id="qrcode-logo" :src="avatar" style="display:none">
        <div class="qr-code"></div>
    </div>
</template>

<script>
    import {get, post} from '../../../api'
    import qrcode from '../../../../../../public/plugins/qrcode/jquery-qrcode.js'
    export default {
        props: ['avatar', 'url'],
        data() {
            return {
            }
        },
        mounted() {  
            // this.set_QRCode()
        },
        methods: {
            // get_user_data() {
            //     return new Promise((res, rej) => {
            //         get(`/api/v1/${this.uid}`)
            //         .then(resp => {        
            //             if(resp.status != 200) return rej(new Error('Errors'))
            //             res(resp.data)
            //             console.log(1);
                        
            //         })
            //     })
                
            // },
            async set_QRCode() {
                $('.qr-code').qrcode({
                    // render method: 'canvas', 'image' or 'div'
                    render: 'image',
                    // version range somewhere in 1 .. 40
                    minVersion: 1,
                    maxVersion: 40,
                    // error correction level: 'L', 'M', 'Q' or 'H'
                    ecLevel: 'H',
                    // offset in pixel if drawn onto existing canvas
                    left: 0,
                    top: 0,
                    // size in pixel
                    size: 200,
                    // code color or image element
                    fill: '#000',
                    // background color or image element, null for transparent background
                    background: null,
                    // content
                    text: `${ this.url }`,
                    // corner radius relative to module width: 0.0 .. 0.5
                    radius: 0,
                    // quiet zone in modules
                    quiet: 3,
                    // modes
                    // 0: normal
                    // 1: label strip
                    // 2: label box
                    // 3: image strip
                    // 4: image box
                    mode: 4,
                    mSize: 0.25,
                    mPosX: 0.5,
                    mPosY: 0.5,
                    label: 'qrcode',
                    fontname: 'sans',
                    fontcolor: '#000',
                    image: $('#qrcode-logo')[0]
                });
            }
        },
        computed: {
            user() {
                return this.$store.getters.get_auth_user_data
            }
        }
    }
</script>