(function($) {
    "use strict"
    var HT = {}
    HT.seoPreview = ()=>{
        $('input[name=name]').on('blur', function(e){
            let value = e.target.value.replace(/^\|+|\|+$/g, ""), canonical = HT.change_to_slug(value)
            let meta_title = $('input[name=meta_title]').val()
            if(meta_title === ''){
                $('.meta_title').html(value)
                $('input[name=meta_title]').val(value)
            } 
            $(".slugName,input[name=canonical]").val(canonical);
            $('.title-canonical').children('a').attr('href',BASE_URL+ '/'+ canonical).html(BASE_URL+ '/'+ canonical)

            
            // console.log();
        })
        $('input[name=meta_title]').on('keyup', function(e){
            let value_title = e.target.value.replace(/^\|+|\|+$/g, "")
            $('.meta_title').html(value_title)
        })
        $('input[name=canonical]').on('keyup', function(e){
            let canonical = e.target.value.replace(/^\|+|\|+$/g, "")
            $('.title-canonical').children('a').attr('href',BASE_URL+ '/'+ canonical).html(BASE_URL+ '/'+ canonical)
            // console.log(canonical);
        })
        $('textarea[name=meta_description]').on('keyup', function(e){
            let description = e.target.value.replace(/^\|+|\|+$/g, "")
            // console.log(e.target);
            $('.meta_description').html(description)
        })

        // CKEDITOR.instances['ck_meta_description'].on('change', function() { 
        //     let description = this.getData().replace(/^\|+|\|+$/g, "")
        //     $('.meta_description').html(description)
        //     console.log(description);
        //   });

    }
    HT.change_to_slug = (str)=> {
        // Chuyển hết sang chữ thường
        str = str.toLowerCase();
        // xóa dấu
        str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
        str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
        str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
        str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
        str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
        str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
        str = str.replace(/(đ)/g, 'd');
        // str = str.replace(/(-)/g, '');
    
        // Xóa ký tự đặc biệt
        str = str.replace(/([^0-9a-z-\s])/g, '');
    
        // Xóa khoảng trắng thay bằng ký tự -
        str = str.replace(/(\s+)/g, '-');
    
        // xóa phần dự - ở đầu
        str = str.replace(/^-+/g, '');
    
        // xóa phần dư - ở cuối
        str = str.replace(/-+$/g, '');
    
        // return
        return str;
    }
    $(document).ready(function(){
        HT.seoPreview()
        // $(".nameforSlug").on('blur', function () {
        //     let name = $(this).val();
        //     if (name != '') {
        //         $(".slugName").val(HT.change_to_slug(name));
        //         // $(".titleName").val(name);
        //     }
        // });
        
    })
})( jQuery );