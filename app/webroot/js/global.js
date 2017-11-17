/**
 * Created by huongnx on 12/10/2015.
 */
var imagePreview = {
    initFancybox: function(){
        $('.fancybox').fancybox({
            openEffect	: 'none',
            closeEffect	: 'none'
        });
    }
};
var Global = {
    init: function(){
        this.addSlider();
        this.addRegion();
        this.addPathAd();
        this.generateSlugFromName();
        this.tags();
        this.initEditor();
    },
    getUrlVars: function() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    },
    addSlider: function () {
        $('#addSlide').click(function () {
            var number = $('.item_wrap_ajax_add_lang').length;
            $.ajax({
                url: URL_ADD_SLIDE,
                type: 'POST',
                dataType: 'HTML',
                data:{number:number},
                success: function (data) {
                    $('.slideItems').append(data);
                }
            })
        })
    },
    addRegion: function () {
        $('#addRegion').click(function () {
            var number = $('.item_wrap_ajax_add_lang').length;
            $.ajax({
                url: URL_ADD_REGION,
                type: 'POST',
                dataType: 'HTML',
                data:{number:number},
                success: function (data) {
                    $('.RegionItems').append(data);
                }
            })
        })
    },
    addPathAd: function () {
        $('#addPathAd').click(function () {
            var number = $('.item_wrap_ajax_add_lang').length;
            $.ajax({
                url: URL_ADD_PATH_AD,
                type: 'POST',
                dataType: 'HTML',
                data:{number:number},
                success: function (data) {
                    $('.pathItems').append(data);
                }
            })
        })
    },
    
    generateSlugFromName: function () {
        $('.name-slug').on('keyup blur', function () {
            $(this).parents('.item_wrap_ajax_add_lang').find('.slug').val(convert_vi_to_en($(this).val()));
        });
    },

    tags: function () {
        $(".chosens-tag").select2({
            tags: true,
            minimumInputLength: 3
        });
    },
    
    initEditor: function () {
        tinymce.init({
            selector: 'textarea.editor',
            language: 'vi',
            paste_data_images: true,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons | sizeselect | fontselect |  fontsizeselect",
            relative_urls: false,
            external_filemanager_path: BASE_URL + "filemanager/",
            filemanager_title: "Responsive Filemanager",
            external_plugins: {"filemanager": BASE_URL + "filemanager/plugin.min.js"},
            filemanager_access_key: A_KEY,
        });
    }

}

//hàm lọc dấu tiếng việt
function convert_vi_to_en(str) {
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\‘|\’| |\"|\&|\#|\[|\]|~|\$|\”|\“|_/g, "-"); /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
    str = str.replace(/-+-/g, "-"); //thay thế 2- thành 1-
    str = str.replace(/^\-+|\-+$/g, ""); //cắt bỏ ký tự - ở đầu và cuối chuỗi
    return str;
}

$(document).ready(function() {
    imagePreview.initFancybox();
    Global.init();
})
