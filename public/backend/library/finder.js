(function($) {
    "use strict"
    var HT = {}

    
    HT.uploadImageToInput = () => {
        $('.upload-image').click(function(){
            let input = $(this), type = input.attr('data-type')
            // HT.setupCkFinder2(input, type);
            HT.setupCkFinder2(input, type);
        })
    }
    HT.uploadImageAvartar = () =>{
        $('.img-target').click(function (e) { 
            let input = $(this), type = 'Images'
            HT.browServerAvartar(input, type);
        });
    }
    HT.multipleUploadImageCkeditor = () => {
        $(document).on('click', '.multipleUploadImageCkeditor', function(e){
            let object = $(this), target = object.attr('data-target')
            HT.browseServerCkeditor(object, 'Images',target);
            e.preventDefault();
        })
    }
    HT.uploadAlbum = () => {
        $(document).on('click', '.upload-picture,.upload-picture', function(e){
            HT.browseServerAlbum('Images');
            e.preventDefault();
        })
    }
    HT.setupCkeditor = () => {
        if($('.ck-editor')){
            $('.ck-editor').each(function(){
                let editor = $(this)
                let elementId = editor.attr('id')
                let elementHeight = editor.attr('data-height')
                HT.ckeditor4(elementId, elementHeight)
            })
        }
    }

    HT.ckeditor4 = (elementId, elementHeight) =>{
        if(typeof(elementHeight) == 'undefined'){
            elementHeight = 500;
        }
        // console.log(elementId);
        CKEDITOR.replace( elementId, {
            height: elementHeight,
            removeButtons: '',
            entities: true,
            allowedContent: true,
            toolbarGroups: [
                { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker','undo' ] },
                { name: 'links' },
                { name: 'insert' },
                { name: 'forms' },
                { name: 'tools' },
                { name: 'document',    groups: [ 'mode', 'document', 'doctools', 'Preview'] },
                { name: 'others' },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup','colors','styles','indent'  ] },
                { name: 'paragraph',   groups: [ 'list', '', 'blocks', 'align', 'bidi' ] },
            ],
            removeButtons: 'Save,NewPage,Pdf,Print,Find,Replace,CreateDiv,SelectAll,Symbol,Block,Button,Language,Flash',
            removePlugins: "exportpdf,easyimage,cloudservices",
        
        })
        
    }
    
    HT.setupCkFinder2 = (object, type) => {
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function( fileUrl, data ) {
            object.val(fileUrl.replace('/public/^\//', ''))
        }
        finder.popup();
    }
    
    HT.browServerAvartar = (object, type)=>{
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function( fileUrl, data ) {
            // console.log(data);
            // fileUrl = fileUrl.replace('/public/', '')
            fileUrl = fileUrl.replace(/^\//, "")
            // console.log(fileUrl);
            object.children('img').attr('src','/'+ fileUrl)
            object.siblings('input.upload-image-avartar').val(fileUrl)
        }
        finder.popup();
    }

    HT.browseServerCkeditor = (object, type, target)=>{
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }
        var finder = new CKFinder();
        
        finder.resourceType = type;
        finder.selectActionFunction = function( fileUrl, data, allFiles) {
            let html =''
            for (let i = 0; i < allFiles.length; i++) {
                let element = allFiles[i], elementId = object.attr('id');
                
                html += '<div class="image-content"><figure><p>'
                html += '<img src="'+element.url+'" alt="'+element.url+'"></p>'
                html += '<figcaption>Nhập mô tả cho ảnh</figcaption></figure></div>'
                // console.log(element.get( 'name' ));
            }
            CKEDITOR.instances[target].insertHtml(html)
            fileUrl = fileUrl.replace(/^\//, "")
        }
        finder.popup();
    }
    HT.browseServerAlbum = (type) =>{
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }
        var finder = new CKFinder();
        
        finder.resourceType = type;
        finder.selectActionFunction = function( fileUrl, data, allFiles) {
            let html =''
            for (let i = 0; i < allFiles.length; i++) {
                let image = allFiles[i].url
                html += '<li class="ui-state-default">'
                    html += '<div class="thumb">'
                        html += '<span class="image span img-scaledown">'
                            html += '<img src="'+image+'" alt="'+image+'">'
                            html += '<input type="hidden" name="album[]" value="'+image+'">'
                        html += '</span>'
                        html += '<button type="button" class="delete-image"><i class="fa fa-trash"></i> </button>'
                    html += '</div>'
                html += '</li>'
            }

            $('#sortable').append(html)
            $('.click-to-upload').addClass('hidden-xl-down')
            $('.upload-list').removeClass('hidden-xl-down')
        }
        finder.popup();
    }

    HT.deleteImage = () => {
        $(document).on('click','.delete-image',function(){
            let _this = $(this)
            _this.parents('.ui-state-default').remove()
            if($('.ui-state-default').length === 0){
                $('.upload-list').addClass('hidden-xl-down')
                $('.click-to-upload').removeClass('hidden-xl-down')
            }
        })
    }
    $(document).ready(function(){
        HT.uploadImageToInput()
        HT.uploadAlbum();
        HT.setupCkeditor();
        HT.uploadImageAvartar();
        HT.multipleUploadImageCkeditor();
        HT.deleteImage();
    })
})( jQuery );
