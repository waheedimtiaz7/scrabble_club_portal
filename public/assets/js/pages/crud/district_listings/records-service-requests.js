"use strict";
// Class definition

var KTDatatableRecordSelectionDemo = function() {
    var localSelectorDemo = function() {
        // enable extension
        var kt_datatable_services = $('#kt_datatable_services').DataTable({
            responsive: true,
            searching: false,
            lengthMenu: [10, 25, 50, 100],
            "order": [[ 3, "asc" ]],
            pageLength: 25,
            language: {
                'lengthMenu': 'Display _MENU_',
            },
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url : config.routes.get_service_requests,
                method: 'POST',
                data:function(d){
                    d._token=config.data.X_CSRF_TOKEN;
                    d.category_id=$( "select[name=category_id] option:checked" ).val();
                    d.search["value"]=$( "input[name=search_query]" ).val();
                },
            },
            columns: [
                {data: 'request_number', name: 'request_number'},
                {data: 'citizen.first_name', name: 'citizen.first_name'},
                {data: 'cm_branch.name', name: 'cm_branch.name'},
                {data: 'cm_branch.name_ar', name: 'cm_branch.name_ar'},
                {data: 'service.title', name: 'service.title'},
                {data: 'service.title_ar', name: 'service.title_ar'},
                {data: 'service.category.title', name: 'service.category.title'},
                {data: 'service.category.title_ar', name: 'service.category.title_ar'},
                {data: 'address', name: 'address'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status_type.title', name: 'status_type.title'},
                {data: 'notes', name: 'notes'},
            ],
        });

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                kt_datatable_services.draw();
            }
        });
        $('.search').on('click',function(e){
            if($(this).hasClass('export')){
                if($(this).hasClass('excel')){
                    $("#export_type").val("xlsx")
                }else if($(this).hasClass('csv')){
                    $("#export_type").val("csv")
                }else{
                    $("#export_type").val("pdf")
                }
                $('#search-form').submit( function(e) {
                    $(this).unbind('submit').submit();
                    kt_datatable_services.draw();
                });
            }else{
                 kt_datatable_services.draw();
            }
        });
    };


    return {
        // public functions
        init: function() {
            localSelectorDemo();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableRecordSelectionDemo.init();

});


$("#kt_datatable_services").on("click", ".delete_btn", function(){
    var _this = $(this);
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        customClass: {
            confirmButton: "btn font-weight-bold btn-success",
            cancelButton: "btn font-weight-bold btn-danger"
        },
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            var url = _this.data('href');
            var id = _this.data('id');
            /*window.location.href = url;*/
            $.ajax({
                async: "false",
                url:url,
                type:"post",
                data:{id:id, _token:config.data.X_CSRF_TOKEN},
                dataType:"json",
                success:function (data) {
                    if(data.success){
                        swal.fire({
                            text: data.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function() {
                            window.location.reload();
                        });
                    }else{
                        swal.fire({
                            text: data.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-danger"
                            }
                        });
                    }
                }
            });
        }
    })
});


$("#comment_on_service_request").on("submit",function (e) {
    e.preventDefault();
    $.ajax({
        url:$("#comment_on_service_request").attr('action'),
        type:'post',
        data:$("#comment_on_service_request").serialize(),
        success:function (data) {
            if(data.success){
                swal.fire({
                    text: data.message,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary"
                    }
                }).then(function() {
                    $("#service_request_comment_modal").modal("hide");
                    location.reload();
                });
            }else{
                swal.fire({
                    text: data.message,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-danger"
                    }
                });
            }
        }
    })
});