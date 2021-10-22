(function($) {
    'use strict';

    //services data table
    $(document).ready(function()
    {

        var searchable = [];
        var selectable = [];


        var dTable = $('#services_table').DataTable({

            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            processing: true,
            responsive: true,
            serverSide: true,
            language: {
                processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
            },
            scroller: {
                loadingIndicator: false
            },
            pagingType: "full_numbers",
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
            ajax: {
                url: '/tenant/service/get-list/'+$("#tenant_uuid").val(),
                type: "get"
            },
            columns: [
                /*{data:'serial_no', name: 'serial_no'},*/
                {data:'uuid', name: 'uuid'},
                {data:'name', name: 'name', orderable: true, searchable: true},
                {data:'type', name: 'type'},
                {data:'created_by', name: 'create_by'},
                //only those have manage_user permission will get access
                {data:'action', name: 'action'}

            ],
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-sm btn-info',
                    title: 'Services',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-sm btn-success',
                    title: 'Services',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-sm btn-warning',
                    title: 'Services',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible',
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm btn-primary',
                    title: 'Services',
                    pageSize: 'A2',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-sm btn-default',
                    title: 'Services',
                    // orientation:'landscape',
                    pageSize: 'A2',
                    header: true,
                    footer: false,
                    orientation: 'landscape',
                    exportOptions: {
                        // columns: ':visible',
                        stripHtml: false
                    }
                }
            ],
            initComplete: function () {
                var api =  this.api();
                api.columns(searchable).every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    input.setAttribute('placeholder', $(column.header()).text());
                    input.setAttribute('style', 'width: 140px; height:25px; border:1px solid whitesmoke;');

                    $(input).appendTo($(column.header()).empty())
                        .on('keyup', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });

                    $('input', this.column(column).header()).on('click', function(e) {
                        e.stopPropagation();
                    });
                });

                api.columns(selectable).every( function (i, x) {
                    var column = this;

                    var select = $('<select style="width: 140px; height:25px; border:1px solid whitesmoke; font-size: 12px; font-weight:bold;"><option value="">'+$(column.header()).text()+'</option></select>')
                        .appendTo($(column.header()).empty())
                        .on('change', function(e){
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column.search(val ? '^'+val+'$' : '', true, false ).draw();
                            e.stopPropagation();
                        });

                    $.each(dropdownList[i], function(j, v) {
                        select.append('<option value="'+v+'">'+v+'</option>')
                    });
                });
            }
        });
    });
    $('select').select2();

    $('#editServiceModal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var type = button.data('type');
        var event = button.data('event');
        console.log(id);

        $("#editServiceModal").find("#service_id").val(id);
        $("#editServiceModal").find("#edit_name").val(name);
        $("#editServiceModal").find("#edit_type").val(type);
        $("#editServiceModal").find("#edit_event").val(event);
    })

    $('#categoryView').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var label = button.data('label');
        var description = button.data('description');

        $("#categoryView").find("#editId").val(id);
        $("#categoryView").find("#editLabel").val(label);
        $("#categoryView").find("#editDescription").val(description);
    })

})(jQuery);
