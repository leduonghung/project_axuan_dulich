(function($) {
    "use strict"
    var HT = {}

    HT.select2 = ()=>{
        $(".select2").select2({
            theme: "bootstrap4",
            allowClear:true,
            placeholder: '--Select--'
        });
    }

    HT.Editor = () => {
        var host = window.location.origin
        if ($("#editor").length > 0) {
            // tinymce.init({
            //     selector: "#editor",
            //     plugins: "file-manager,link,image code print preview searchreplace autolink visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern",
            //     toolbar1: 'undo redo | fontsizeselect |styleselect underline bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | pastetext searchreplace |responsivefilemanager image table |image media |link unlink anchor| print preview fullscreen code',
            //     toolbar2: 'formatselect removeformat | visualblocks',
            //     filemanager_title: "Quản lý file",
            //     external_filemanager_path: host + "/filemanager/",
            //     external_plugins: {
            //         "filemanager": host + "/filemanager/plugin.min.js"
            //     },
                
            //     // filemanager_access_key: "9bfb3d618969916159723fed26d4aff8",
            // });
        }
    }
    $(document).ready(function(){
        HT.select2()
        HT.Editor()
    })
})( jQuery );