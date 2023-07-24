<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>

<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };</script>
<!--end::Global Config-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('theme/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('theme/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('theme/js/scripts.bundle.js') }}"></script>
<!--end::Global Theme Bundle-->

<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('theme/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<!--end::Page Vendors-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/js/pages/widgets.js') }}"></script>
<!--end::Page Scripts-->

<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('theme/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/js/pages/crud/datatables/basic/basic.js') }}"></script>
<!--end::Page Scripts-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
<!--end::Page Scripts-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/js/pages/crud/forms/editors/summernote.js') }}"></script>
<!--end::Page Scripts-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/js/pages/crud/forms/widgets/select2.js') }}"></script>
<!--end::Page Scripts-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<!--end::Page Scripts-->

<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script src="{{ asset('js/additional-methods.js') }}"></script>


<!--begin::Page Vendors(used by this page)-->
<script src="//www.amcharts.com/lib/3/amcharts.js"></script>
<script src="//www.amcharts.com/lib/3/serial.js"></script>
<script src="//www.amcharts.com/lib/3/radar.js"></script>
<script src="//www.amcharts.com/lib/3/pie.js"></script>
<script src="//www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js"></script>
<script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js"></script>
<script src="//www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="//www.amcharts.com/lib/3/themes/light.js"></script>
<!--end::Page Vendors-->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).find('.select2').select2({});

        $(document).off('click', '.organization_selection');
        $(document).on('click', '.organization_selection', function () {
            $.ajax({
                type: 'GET',
                url: '{{ route('select.organization') }}',
                data: {
                    id: $(this).attr('data-organization-id'),
                },
                success: function (response) {
                    if (response.success) {
                        window.location.href = "{{ route('home') }}";
                    }
                }
            });
        });

        $(document).off('click', '.set_locale');
        $(document).on('click', '.set_locale', function () {
            window.location.href = "{{ route('set.locale') }}/" + $(this).attr('data-locale');
        });

        $(document).off('click', '.remove_attachment');
        $(document).on('click', '.remove_attachment', function (e) {
            e.preventDefault();
            let $_this = $(this);
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this item!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((will_delete) => {
                if (will_delete) {
                    $_this.parents('.form-group').find('input[type="hidden"]').val('');
                    $_this.parents('.form-group').find('.input_action_buttons').remove();
                    $.ajax({
                        type: 'get',
                        url: "{{ route('remove.file') }}",
                        data: {
                            module: $_this.attr('data-module'),
                            field: $_this.attr('data-field'),
                            id: $_this.attr('data-id'),
                            attachment: $_this.attr('data-attachment'),
                        },
                        success: function (response) {
                            if (!response.success) {
                                swal('Error...', response.message, 'error')
                                return false;
                            }

                            swal(response.message, {icon: "success",});
                        }
                    });
                }
            });
        });

        $(document).off('click', '.delete_item');
        $(document).on('click', '.delete_item', function () {
            let $_this = $(this);
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this item!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((will_delete) => {
                    if (will_delete) {
                        swal("Poof! Your item has been deleted!", {
                            icon: "success",
                        });
                        setTimeout(function () {
                            $_this.parents('td').find('.delete_item_form').submit();
                            $_this.parents('span').find('.delete_item_form').submit();
                        }, 1000);
                    } else {
                        // window.location.reload();
                    }
                });
        });

        $(document).off('click', '.update_state');
        $(document).on('click', '.update_state', function () {
            let $_this = $(this);
            swal({
                title: "Are you sure?",
                text: "You want to update the state!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((will_delete) => {
                    if (will_delete) {
                        $.ajax({
                            type: 'get',
                            url: "{{ route('state.update') }}",
                            data: {
                                module: $_this.attr('data-module'),
                                id: $_this.attr('data-id')
                            },
                            success: function (response) {
                                if (!response.success) {
                                    swal('Error...', response.message, 'error')
                                    return false;
                                }
                                $_this.find('i').removeAttr('class');
                                if (response.data !== undefined && response.data.is_active == 1) {
                                    $_this.find('i').attr('class', 'fa fa-check text-success');
                                } else {
                                    $_this.find('i').attr('class', 'fa fa-times text-danger');
                                }
                                swal(response.message, {icon: "success",});
                            }
                        });
                    } else {
                        // window.location.reload();
                    }
                });
        });

        init_data_table();
    });

    function init_data_table() {
        $('.data_table').DataTable({
            responsive: true,
            filter: true,
            search: true,
            bSearch: true,
            dom: `<'row'<'col-sm-12'ftr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {
                'lengthMenu': 'Display _MENU_',
            },
            // order: [[0, 'desc']],
            order: []
        });
    }

    function toast_message(type = 'success', message = 'Done') {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "linear",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        if (type == 'error') {
            toastr.error(message);
        } else {
            toastr.success(message);
        }
    }
</script>
