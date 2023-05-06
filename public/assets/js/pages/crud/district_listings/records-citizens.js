"use strict";
// Class definition

var KTDatatableRecordSelectionDemo = function() {

    var localSelectorDemo = function() {
        var data=$("#kt_datatable_citizens").DataTable({
            responsive: true,
            searching: false,
            lengthMenu: [10, 25, 50, 100],
            pageLength: 25,
            language: {
                'lengthMenu': 'Display _MENU_',
            },
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url : config.routes.get_citizens_list,
                method: 'POST',
                data: function (d) {
                    d._token=config.data.X_CSRF_TOKEN;
                    d.search["value"]=$( "input[name=search_query]" ).val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'first_name'},
                {data: 'street_address', name: 'street_address'},
                {data: 'id_number', name: 'id_number'},
                {data: 'cm_branch.name', name: 'cm_branch.name'},
                {data: 'fixed_line_contact', name: 'fixed_line_contact'}
            ]
        });

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                data.draw();
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
                    data.draw();
                });
            }else{
              data.draw();
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



$("#kt_datatable_citizens").on("click", ".delete_btn", function(){
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