(function($) {
    "use strict"
    var HT = {}

    HT.getLocation0 = (Select2_id) =>{
        $('#' + Select2_id).select2(
            {
                theme: "bootstrap4",
                allowClear:true,
                placeholder: '-- Chọn tỉnh --'
            }
        ).on('select2:select', function () {
            let _this = $(this)
            let options = {
                'data' : {
                    'target': _this.attr('data-target'),
                    id: _this.val()
                },
                'url': '/admin/ajax/location/index'
            }
            $.ajax({
                url: options.url,
                type: 'GET',
                dataType: 'html',
                data: options.data,
                beforeSend: function() {
                    $('#select2-distric_id-container').parent().addClass('loading')
                },
                success: function(data) {
                    // console.log(data);
                    
                },
                statusCode: {
                    200: function(data) {
                        


                        $('#'+_this.attr('data-target')+'_id').prop("disabled", false).html(data).select2(
                            {
                                theme: "bootstrap4",
                                allowClear:true,
                                placeholder: '-- Chọn Phường/Xã --'
                        })
                        
                    },
                    403: function(data) {
                        $.toast({
                            heading: 'Dữ liệu chưa update !',
                            text: 'Quận/Huyện '+ label +' không có xã/Phường nào',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'warning',
                            hideAfter: 34500, 
                            stack: 6
                        });
                    },
                },
                error: function(jqXHR, statusText, errorThrown) { // if error occured
                    console.log('Lỗi : ' +statusText +' => '+ errorThrown);
                }
            })
        })
        .on("select2:unselect", function(e) {
            let selected = '';
            if (Select2_id=='province_id') {
                selected = $('#district_id, #ward_id')
            } else {
                selected = $('#ward_id')
            }
            selected.prop('disabled', true).html(null)
            .select2({
                theme: "bootstrap4",
                placeholder: '-- Select --'
            });
        });
    }
    HT.sendDataTogetLocation0 = (options) =>{
        
        $.ajax({
                url: options.url,
                type: 'GET',
                dataType: 'html',
                data: options.data,
                beforeSend: function() {
                    // $('#select2-distric_id-container').parent().addClass('loading')
                },
                success: function(data) {
                    if(district_id !== '' && options.data.target =='district'){
                        $('#district_id').val(district_id).trigger('change')
                    }
                },
                statusCode: {
                    200: function(data) {
                        $('#'+options.data.target+'_id').prop("disabled", false).html(data).select2({
                            theme: "bootstrap4",
                            allowClear:true,
                            placeholder: '-- Chọn Phường/Xã --'
                        })
                    },
                    403: function(data) {
                        $.toast({
                            heading: 'Dữ liệu chưa update !',
                            text: 'Không có xã/Phường nào',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'warning',
                            hideAfter: 34500, 
                            stack: 6
                        });
                    },
                },
                error: function(jqXHR, statusText, errorThrown) { // if error occured
                    console.log('Lỗi : ' +statusText +' => '+ errorThrown + jqXHR);
                }
            })
    }
    HT.getLocation1 = (Select2_id) =>{
        $('.location').select2(
            {
                theme: "bootstrap4",
                allowClear:true,
                placeholder: '-- Chọn tỉnh --'
            }
        ).on('select2:select', function () {
            let _this = $(this)
            let options = {
                'data' : {
                    id: _this.val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                'target': _this.attr('data-target')
            }
            HT.sendDataTogetLocation(options)
        })
        .on("select2:unselect", function(e) {
            let selected = '';
            if (Select2_id=='province_id') {
                selected = $('#district_id, #ward_id')
            } else {
                selected = $('#ward_id')
            }
            selected.prop('disabled', true).html(null)
            .select2({
                theme: "bootstrap4",
                placeholder: '-- Select --'
            });
        });
    }
    HT.getLocation = () =>{
        $('.location').select2(
            {
                theme: "bootstrap4",
                allowClear:true,
                placeholder: '-- Chọn --'
            }
        ).on('select2:select', function () {
            let _this = $(this)
            let options = {
                'data' : {
                    id: _this.val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                'target': _this.attr('data-target')
            }
            HT.sendDataTogetLocation(options)
        })
        .on("select2:unselect", function(e) {
            let _this = $(this), id_selected = _this.attr('id')
            // console.log(_this.attr('id'));
            let selected = '';
            if (id_selected=='province_id') {
                selected = $('#district_id, #ward_id')
            } else {
                selected = $('#ward_id')
            }
            selected.prop('disabled', true).html(null)
            .select2({
                theme: "bootstrap4",
                placeholder: '-- Select --'
            });
        });
        // =============================
        // $(document).on('change','.location', function(){
        //     let _this = $(this)
        //     let options = {
        //         'data' : {
        //             id: _this.val(),
        //             _token: $('meta[name="csrf-token"]').attr('content')
        //         },
        //         'target': _this.attr('data-target')
        //     }
        //     // HT.sendDataTogetLocation(options)
        // });
    }
    HT.sendDataTogetLocation = (options) =>{
        $.ajax({
            url: '/admin/ajax/location/index',
            type: 'GET',
            dataType: 'html',
            data: options,
            success: function(data) { 
                
                $('#'+options.target+'_id').prop("disabled", false).html(data).select2({
                    theme: "bootstrap4",
                    allowClear:true,
                    placeholder: '-- Chọn Phường/Xã --'
                })

                // console.log(data);
                if(district_id != '' && options.target == 'district'){
                    $('#district_id').val(district_id).trigger('change');
                }
                if(ward_id != '' && options.target == 'ward'){
                    $('#ward_id').val(ward_id).trigger('change');
                }
            },
            error: function(jqXHR, statusText, errorThrown) { // if error occured
                console.log('Lỗi : ' +statusText +' => '+ errorThrown + jqXHR);
            }
        })
    }
    HT.Province = () =>{
        $("#province_id").select2(
            {
                theme: "bootstrap4",
                allowClear:true,
                placeholder: '-- Chọn tỉnh --'
            }
        ).on('select2:select', function () {
            let _this = $(this),label = _this.find('option:selected').text()
            
            let options = {
                'data' : {
                    'target': _this.attr('data-target'),
                    id: _this.val()
                },
                'url': '/admin/ajax/location/index'
            }
            HT.sendDataTogetLocation(options)
            
        })
        .on("select2:unselect", function(e) {
            // $('#distric_id').select2('destroy');
            if(_this.attr('data-target') === 'district') $('#distric_id, #ward_id').prop('disabled', true).html(null)
            if(_this.attr('data-target') === 'ward')  $('#ward_id').prop('disabled', true).html(null)
            .select2({
                theme: "bootstrap4",
                placeholder: '-- Select --'
            });
        });
    }
    HT.District = () =>{
        $("#district_id").select2(
            {
                theme: "bootstrap4",
                allowClear:true,
                placeholder: '-- Chọn Quận/Huyện --'
            }
        ).on('select2:select', function () {
            let _this = $(this)
            let options = {
                'data' : {
                    'target': _this.attr('data-target'),
                    id: _this.val()
                },
                'url': '/admin/ajax/location/index'
            }
            // console.log(options);
            HT.sendDataTogetLocation(options)
        })
        .on("select2:unselect", function(e) {
            $('#ward_id').prop('disabled', true).html(null)
            .select2({
                theme: "bootstrap4",
                placeholder: '-- Select --'
            });
        });
    }

    HT.LoadCity = ()=>{
        // console.log(province_id);
        if(province_id != ''){
            $('#province_id').val(parseInt(province_id)).trigger('change');
        }
    }
    
    $(document).ready(function() {
        
        HT.getLocation()
        HT.LoadCity()
    })
    
})( jQuery );