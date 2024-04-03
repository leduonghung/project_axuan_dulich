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
    HT.uploadAlbum = () => {
        $(document).on('click', '.upload-picture', function(e){
            HT.browseServerAlbum();
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
                { name: 'document',    groups: [ 'mode', 'document', 'doctools'] },
                { name: 'others' },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup','colors','styles','indent'  ] },
                { name: 'paragraph',   groups: [ 'list', '', 'blocks', 'align', 'bidi' ] },
            ],
            removeButtons: 'Save,NewPage,Pdf,Preview,Print,Find,Replace,CreateDiv,SelectAll,Symbol,Block,Button,Language,Flash',
            removePlugins: "exportpdf,easyimage,cloudservices",
        
        });
    }
    
    HT.setupCkFinder2 = (object, type) => {
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function( fileUrl, data ) {
            // object.val(fileUrl)
            object.val(fileUrl.replace('/public/', ''))
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
            fileUrl = fileUrl.replace('/public/', '')
            object.children('img').attr('src',fileUrl)
            object.siblings('input.upload-image-avartar').val(fileUrl)
        }
        finder.popup();
    }
    $(document).ready(function(){
        HT.uploadImageToInput()
        HT.setupCkeditor();
        HT.uploadImageAvartar();

        
    })
})( jQuery );