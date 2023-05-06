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
                url : config.routes.get_address_update_requests,
                method: 'POST',
                data:function(d){
                    d._token=config.data.X_CSRF_TOKEN;
                    d.search["value"]=$( "input[name=search_query]" ).val();
                },
            },
            columns: [
                {data: 'id'},
                {data: 'user.first_name', name: 'user.first_name'},
                {data: 'user.id_number', name: 'user.id_number'},
                {data: 'cm_branch.name', name: 'cm_branch.name'},
                {data: 'cm_branch.name_ar', name: 'cm_branch.name_ar'},
                {data: 'district.name', name: 'district.name'},
                {data: 'district.name_ar', name: 'district.name_ar'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
                {data: 'actions',searchable:false,sortable:false},
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


$("#reject_address_update_request").on("submit",function (e) {
    e.preventDefault();
    $.ajax({
        url:$("#reject_address_update_request").attr('action'),
        type:'post',
        data:$("#reject_address_update_request").serialize(),
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
                    $("#address_update_request_modal").modal("hide");
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