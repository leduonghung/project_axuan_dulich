function deleteItem(id) {

    let item = $("#deleteItem_" + id);
    let urlRequest = item.data("url"),
        _token = $('meta[name="csrf-token"]').attr('content'),
        content = item.data("message") ?? 'Thao tác xóa có thể ảnh hưởng đến dữ liệu ?',
        title = item.data("title") ?? 'Bạn muốn xóa ?',
        titleMessage = "",
        action = "";

    // if (typeof content === typeof undefined || content === false) {
    //     titleMessage = "Bạn xóa có thể những dữ liệu khác ảnh hưởng ?";
    // } else {
    //     titleMessage = content;
    // }
    if (item.data("action") == "show") {
        action = "show";
    } else {
        action = false;
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: title,
        text: content,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Có, Hãy xóa dữ liệu!",
        cancelButtonText: "Không xóa !",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: urlRequest,
                type: "DELETE",
                dataType: "JSON",
                data: {
                    _token: _token,
                    // action: action
                },
                // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                // beforeSend: function() {
                //     currentLink.html('loading...')
                // },
                success: function(data) {
                    
                },
                statusCode: {
                    200: function(data) {
                        window.setTimeout(function() {
                            $('#row_user_'+id).remove();
                        }, 900);
                        swalWithBootstrapButtons.fire({
                            title: data.title,
                            text: data.message,
                            icon: "success"
                        });
                    },
                    405: function(response) {
                        console.log(response);
                    },
                    403: function(response) {
                        message = response.responseJSON.message
                        if (isNaN(message)) message = "Bạn đã xóa thất bại";
                        swalWithBootstrapButtons.fire({
                            title: "Error!",
                            text: message,
                            icon: "error"
                        });
                    },
                    500: function(response) {
                        message = response.responseJSON.message
                        if (isNaN(message)) message = "Bạn đã xóa thất bại";
                        swalWithBootstrapButtons.fire({
                            title: "Error!",
                            text: message,
                            icon: "error"
                        });
                    }
                },
                error: function(response) {
                    swalWithBootstrapButtons.fire(
                        "Error !",
                        "bạn đã xóa thất bại ",
                        "warning"
                    );
                    // currentLink.html('loading...')
                }
            });

        //   swalWithBootstrapButtons.fire({
        //     title: "Deleted!",
        //     text: "Your file has been deleted.",
        //     icon: "success"
        //   });
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire({
            title: "Cancelled",
            text: "Your imaginary file is safe :)",
            icon: "error"
          });
        }
      });

    // swalWithBootstrapButtons
    //     .fire({
    //         title: titleHead,
    //         text: titleMessage,
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonText: "Yes, delete it!",
    //         cancelButtonText: "No, cancel!",
    //         reverseButtons: true
    //     })
    //     .then(result => {
    //         if (result.value) {
    //             $.ajax({
    //                 url: urlRequest,
    //                 type: "POST",
    //                 dataType: "JSON",
    //                 data: {
    //                     // id: id,
    //                     _token: _token,
    //                     action: action
    //                 },
    //                 // beforeSend: function() {
    //                 //     currentLink.html('loading...')
    //                 // },
    //                 success: function(data) {
    //                     if (action == "show") {
    //                         // window.location.href = data.rederect;
    //                         window.setTimeout(function() {
    //                             window.location = data.rederect;
    //                         }, 1500);
    //                     }
    //                     if (data.code == 200) {
    //                         // data - delete
    //                         console.log(item.data("delete"));
    //                         if (item.attr("data-delete")) {
    //                             // alert("true");
    //                             $("#" + item.data("delete")).remove();
    //                         } else {
    //                             // alert("false");
    //                             item.parent()
    //                                 .parent()
    //                                 .remove();
    //                         }

    //                         message = " bạn đã xóa thành công : " + data.name;
    //                     } else {
    //                         message = " bạn đã xóa thất bại";
    //                     }
    //                     swalWithBootstrapButtons.fire(
    //                         "Deleted !",
    //                         message,
    //                         "success"
    //                     );
    //                 },
    //                 statusCode: {
    //                     403: function(response) {
    //                         // console.log(response);
    //                         console.log(response.responseJSON.message);
    //                         message = response.responseJSON.message
    //                         if (isNaN(message)) message = "Bạn đã xóa thất bại";
    //                         swalWithBootstrapButtons.fire(
    //                             "Error !",
    //                             message,
    //                             "error"
    //                         );
    //                     }
    //                 },
    //                 error: function(response) {
    //                     swalWithBootstrapButtons.fire(
    //                         "Error !",
    //                         "bạn đã xóa thất bại ",
    //                         "warning"
    //                     );
    //                     // currentLink.html('loading...')
    //                 }
    //             });
    //         } else if (
    //             // Read more about handling dismissals
    //             result.dismiss === Swal.DismissReason.cancel
    //         ) {
    //             swalWithBootstrapButtons.fire(
    //                 "Cancelled",
    //                 "Bạn đã hủy thao tác xóa :)",
    //                 "error"
    //             );
    //         }
    //     });
}

function changeActive(e, id) {
    let item = $("#changeActive_" + id);
    console.log(e);
    let titleMessage = "",
    //     titleHead = "",
        content = e.getAttribute("data-message"),
        title = e.getAttribute("data-title");

    // if (content == null) content = e.getAttribute("data-message");
    // if (title == null) title = e.getAttribute("data-title");
    if (typeof title === typeof undefined || title === false) {
        titleHead = "Bạn muốn thay đổi ?";
    } else {
        titleHead = title;
    }
    // if (typeof content === typeof undefined || content === false) {
    //     titleMessage = "Bạn xóa có muốn thay đổi trạng thái ?";
    // } else {
    //     titleMessage = content;
    // }
    let url = e.getAttribute("data-url"),
        field = e.getAttribute("data-field"),
        _token = $('meta[name="csrf-token"]').attr('content');

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "mr-2 btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons
        .fire({
            title: title,
            text: content,
            icon: "warning",
            // type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, change it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true,
        })
        .then(result => {

            if (result.value) {
                // alert(url)
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'html',
                    data: {
                        id: id,
                        field: field,
                        _token: _token
                    },
                    beforeSend: function() {
                        // <button data-field="status" data-message="{{ ($user->status==0)?'Bạn muốn user : '.$user->name.' kích hoạt ?':'Bạn muốn user : '.$user->name.' Ẩn ?' }}" data-url="{{ route('admin.user.loadAjax') }}" onclick="changeActive(this,{{$user->id}})" type="button" class="btn btn-sm waves-effect waves-light btn-rounded {{ $user->status ? 'btn-outline-info':'btn-outline-warning' }}"> {!! $user->status? 'Kích hoạt' : ' &nbsp; Ẩn &nbsp; ' !!} </button>
                        // item.html("loading...");
                    },
                    statusCode: {
                        200: function(response) {
                            switch (field) {
                                case "status":
                                    message = "Bạn đã thay đổi trạng thái thành công";
                                    break;
                                case "vertical_menu":
                                    message = "Bạn đã thay đổi trạng thái thành công";
                                    break;

                                case "deleted_at":
                                    {
                                        message = "Bạn đã thay đổi trạng thái thành công";
                                        // $("#productsDelete_" + id).remove();
                                        // console.log("#productsDelete_"+id);
                                        window.location.href = response
                                        // console.log(response);
                                        break;
                                    }

                                default:
                                    message = "Bạn đã xóa thất bại";
                                    break;
                            }

                            item.html(response);
                            swalWithBootstrapButtons.fire(
                                "Changed !",
                                message,
                                "success"
                            );
                        },
                        201: function(response) {
                            // console.log(response);
                            // message = response.responseJSON.message

                            // swalWithBootstrapButtons.fire(
                            //     "Error !",
                            //     response,
                            //     "error"
                            // );
                        },
                        500: function(response) {
                            // message = response.responseJSON.message
                            console.log(response);
                            swalWithBootstrapButtons.fire(
                                "Error !",
                                message,
                                "error"
                            );
                        }
                    },
                    success: function(data) {

                    },
                    error: function(error) {
                        // console.log(error);
                        // console.log(response.message);
                        swalWithBootstrapButtons.fire(
                            "Error !",
                            "Your data fail change .",
                            "warning"
                        );
                        // currentLink.html('loading...')
                    }
                });
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                // swalWithBootstrapButtons.fire(
                //     "Cancelled",
                //     "Your imaginary file is safe :)",
                //     "error"
                // );
            }
        });
}

changeStatus = (item,id) =>{
    let option = {
        'value' : parseInt(item.getAttribute('data-value')),
        'model' :item.getAttribute('data-model'),
        'field' :item.getAttribute('data-field'),
        'id'   : id,
        'url' : item.getAttribute('data-url'),
        '_token' : $('meta[name="csrf-token"]').attr('content')
    }, content = item.getAttribute("data-message"),
    title = item.getAttribute("data-title");
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "mr-2 btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons
        .fire({
            title: title,
            text: content,
            icon: "warning",
            // type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, change it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true,
        })
        .then(result => {

            if (result.value) {
                $.ajax({
                    url: option.url,
                    type: "GET",
                    dataType: "html",
                    data: option,
                    // beforeSend: function() {
                    //     currentLink.html('loading...')
                    // },
                    success: function(data) {
                        
                    },
                    statusCode: {
                        200: function(data) {
                            $('#changeActive_'+id).html(data);
                            let status = option.value == 1 ? 0 : 1
                            // console.log($('#checkBoxItem_'+id));
                            $('#checkBoxItem_'+id).attr("data-status", status)
                            // document.getElementById("test").setAttribute("id", document.getElementById("test").getAttribute("id") + " test2")
                            // $('#checkBoxItem_'+id).data("status", status);
                            $.toast({
                                heading: 'Thao tác thành công !',
                                text: content,
                                position: 'top-right',
                                loaderBg:'#ff6849',
                                icon: 'info',
                                hideAfter: 4500,
                                stack: 6
                            });

                        },
                        405: function(response) {
                            console.log(response);
                        },
                        403: function(response) {
                            message = response.responseJSON.message
                            if (isNaN(message)) message = "Bạn đã thay đổi trạng thái thất bại";
                            swalWithBootstrapButtons.fire({
                                title: "Error!",
                                text: message,
                                icon: "error"
                            });
                        },
                        500: function(response) {
                            message = response.responseJSON.message
                            if (isNaN(message)) message = "Bạn đã thay đổi trạng thái thất bại";
                            swalWithBootstrapButtons.fire({
                                title: "Error!",
                                text: message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(response) {
                        swalWithBootstrapButtons.fire(
                            "Error !",
                            "bạn đã thay đổi trạng thái thất bại ",
                            "warning"
                        );
                    }
                });
            }else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                // swalWithBootstrapButtons.fire(
                //     "Cancelled",
                //     "Your imaginary file is safe :)",
                //     "error"
                // );
            }
        });
}

getCheckBoxIds = (status)=>{
    let array = []; 
    $('.checkBoxItem:checkbox:checked').map(function(e){
        let item = $(this)
        if(status){
            if(item.data('status') === 0) array.push(item.val()); 
        }else{
            if(item.data('status') === 1) array.push(item.val()); 
        }
    })
    return array
}

changeStatusAll = (item)=>{
    let status =parseInt(item.getAttribute('data-value')), checkBoxIds = getCheckBoxIds(status);
    let option = {
        'value' : status,
        'model' :item.getAttribute('data-model'),
        'field' :item.getAttribute('data-field'),
        'id'   : checkBoxIds,
        'url' : item.getAttribute('data-url'),
        '_token' : $('meta[name="csrf-token"]').attr('content')
    }, content = item.getAttribute("data-message"),
    title = item.getAttribute("data-title");
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "mr-2 btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons
        .fire({
            title: title,
            text: content,
            icon: "warning",
            // type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, change it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true,
        })
        .then(result => {

            if (result.value) {
                
                $.ajax({
                    type: "GET",
                    url: option.url,
                    data: option,
                    dataType: "json",
                    success: function (response) {
                        
                    },
                    statusCode: {
                        200: function(data) {
                            let response = data.data
                            Object.keys(response).forEach(key => {
                            let status = response[key]['status']

                            $('#checkBoxItem_'+key).attr("data-status", response[key]['status'])
                            let button = $('#changeActive_'+key).children('button')
                            button.html(response[key]['label']);
                            button.attr('data-value', status);
                            if (status) {
                                $(button).removeClass('btn-outline-warning').addClass('btn-outline-info');
                            } else {
                                $(button).removeClass('btn-outline-info').addClass('btn-outline-warning');
                            }
                            });
                            
                            $.toast({
                                heading: title,
                                text: 'Bạn thay đổi trạng thái thành công !',
                                position: 'top-right',
                                loaderBg:'#ff6849',
                                icon: 'info',
                                hideAfter: 4500,
                                stack: 6
                            });

                        },
                        405: function(response) {
                            console.log(response);
                        },
                        403: function(response) {
                            let message =  response.responseJSON.message
                            if (isNaN(message)) message = "Bạn đã cập nhật thất bại";
                            swalWithBootstrapButtons.fire({
                                title: "Error!",
                                text: message,
                                icon: "error"
                            });
                        },
                        500: function(response) {
                            console.log(response);
                            // if (isNaN(message)) message = "Bạn đã thay đổi trạng thái thất bại";
                            // swalWithBootstrapButtons.fire({
                            //     title: "Error!",
                            //     text: message,
                            //     icon: "error"
                            // });
                        }
                    },
                    error: function(response) {
                        // console.log(response.responseJSON.message);
                        let message =  response.responseJSON.message
                            if (isNaN(message)) message = "Bạn đã cập nhật thất bại";
                        swalWithBootstrapButtons.fire({
                            title: "Error!",
                            text: message,
                            icon: "error"
                        });
                    }
                });
                
            }else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                // swalWithBootstrapButtons.fire(
                //     "Cancelled",
                //     "Your imaginary file is safe :)",
                //     "error"
                // );
            }
        });

    // console.log(searchIDs);
}
deleteItemAll = ()=>{
    let searchIDs = $('.checkBoxItem:checkbox:checked').map(function(){
                
        return $(this).val();
        
    });
    console.log(searchIDs);
}
$(document).ready(function(evt) {
    if($('#checkAll').length){
        $('#checkAll').on('click', function(){
            let isChecked = $(this).prop('checked')
            if (isChecked) {
                $('.checkBoxItem').prop('checked',isChecked)
            } else {
                $('.checkBoxItem').prop('checked',false)
            }
        })
    }
    /* Hien thi trang thai voi nut bam */
    let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });
    /* Hien thi trang thai voi nut bam */
    
    /* validate cho nhập số */
    $("input[data-type='money'],input[data-type='number']").each(function() {
        $(this).on('keypress keydown', function(event) {
            var charCode = evt.which ? evt.which : event.keyCode;
            // console.log(charCode);
            if (charCode < 48 && charCode > 46 && charCode != 8) {
                // console.log(charCode);
                return false;
            }
            // if (charCode < 46 && charCode != 8) {
            //     console.log(charCode);
            //     return false;
            // }
            if ((charCode > 57 && charCode < 96) || charCode > 105) {
                // console.log(charCode);
                return false;
            }
            return true;
        });
    });

    /* SỬ DỤNG LOAD AJAX TRONG MODAL  */
    let select2LoadAjax = $(".select2.mySelect2Ajax");
    select2LoadAjax.each(function() {
        let that = $(this),
            drop_parent = false;
        /* kiểm tra có phải nằm trong Modal #myModalModalLG */
        if ($(this).parents("#myModalModalLG ").length) {
            drop_parent = $("#myModalModalLG");
        }
        // console.log(dropdownParent);
        $(this).select2({
            // theme: "bootstrap4",
            placeholder: $(this).data("placeholder"),
            allowClear: Boolean($(this).data("allow-clear")),
            // debug: true
            // placeholder: "--Select a..--",
            dropdownParent: drop_parent,
            ajax: {
                url: that.data("url"),
                dataType: "json",
                type: "GET",
                quietMillis: 50,
                // delay: 250,
                data: function(params) {
                    var queryParameters = {
                        name: params.term
                    };
                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        // results: data
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            };
                        })
                    };
                }
            }
        });
    });

    /* SỬ DỤNG LOAD AJAX TRONG MODAL myModalModalLG */

    $(".chekboxMy.material-inputs").click(function() {
        // console.log($(this).prop('checked'));
        if ($(this).prop("checked")) {
            $("label.label_chekboxMy").text(" Kích hoạt ");
        } else {
            $("label.label_chekboxMy").text(" Ẩn ");
        }
    });

    $("input[data-type='money']").on({
        keyup: function() {
            formatCurrency($(this));
        },
        blur: function() {
            formatCurrency($(this), "blur");
        }
    });

    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        // get input value
        var input_val = input.val();
        // don't validate empty input
        if (input_val === "") {
            return;
        }
        // original length
        var original_len = input_val.length;
        // initial caret position
        var caret_pos = input.prop("selectionStart");
        // check for decimal
        if (input_val.indexOf(",") >= 0) {
            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(",");
            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            // add commas to left side of number
            left_side = formatNumber(left_side);
            // validate right side
            right_side = formatNumber(right_side);
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);
            // join number by .
            input_val = left_side + "," + right_side;
            // input_val = "$" + left_side + "," + right_side;
        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;
            // final formatting
            // if (blur === "blur") {
            //   input_val += ".00";
            //   // input_val += ".00";
            // }
        }
        // send updated string to input
        input.val(input_val);
        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    
});