@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('notification'))
                        <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">{{ __('locale.elements.heading_title.cms_page_manage') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('pages', 'manage') !!}
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $redirect_route = !empty($page)
                        ? route('pages.update', $page->id)
                        : route('pages.store');
                    ?>
                    <form action="{{ $redirect_route }}" method="post"
                          enctype="multipart/form-data" class="page_form" id="page_form">
                        {{ csrf_field() }}
                        @if(isset($page) && !empty($page))
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <input type="hidden" name="id" class="page_id"
                               value="{{ isset($page) && isset($page->id) && $page->id > 0 ? $page->id : 0 }}">

                        <input type="hidden" name="slug"
                               value="{{ isset($page) && !empty($page->slug) ? $page->slug : '' }}">

                        <x-hidden-organization-input/>
                        @include('pages.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            let KTSummernoteDemo = function () {
                let demos = function () {
                    $('.summernote').summernote({
                        height: 150
                    });
                }
                return {
                    init: function () {
                        demos();
                    }
                };
            }();

            $('.page_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    title: 'required',
                    content: 'required',
                    a_title: 'required',
                    a_content: 'required'
                }
            });
        });
    </script>
@stop
