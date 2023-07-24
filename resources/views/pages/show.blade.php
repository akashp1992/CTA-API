@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">{{ __('locale.elements.heading_title.cms_page_detail') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('pages', 'display', $page->slug) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.is_active') }}</strong><br>
                            {!! prepare_active_button('pages', $page) !!}
                        </div>
                    </div>

                    <ul class="nav nav-tabs tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active"
                               data-toggle="tab" href="#tab_english"
                               role="tab">English</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               data-toggle="tab" href="#tab_arabic"
                               role="tab">Arabic</a>
                        </li>
                    </ul>
                    <div class="tab-content tabs card-block py-10">
                        <div class="tab-pane active" id="tab_english" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <strong>{{ __('locale.elements.title') }}</strong><br>
                                    {{ isset($page) && !empty($page->title) ? $page->title : '-' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-5">
                                    <strong>{{ __('locale.elements.content') }}</strong><br>
                                    {!! isset($page) && !empty($page->content) ? $page->content : '-' !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <strong>{{ __('locale.elements.meta_title') }}</strong><br>
                                    {{ isset($page) && !empty($page->meta_title) ? $page->meta_title : '-' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <strong>{{ __('locale.elements.meta_keywords') }}</strong><br>
                                    {!! isset($page) && !empty($page->meta_keywords) ? $page->meta_keywords : '-' !!}
                                </div>
                                <div class="col-md-6 mb-5">
                                    <strong>{{ __('locale.elements.meta_description') }}</strong><br>
                                    {!! isset($page) && !empty($page->meta_description) ? $page->meta_description : '-' !!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_arabic" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <strong>{{ __('locale.elements.title') }}</strong><br>
                                    <span
                                        class="arabic_text">{{ isset($page) && !empty($page->a_title) ? $page->a_title : '-' }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-5">
                                    <strong>{{ __('locale.elements.content') }}</strong><br>
                                    <span class="arabic_text">
                                        {!! isset($page) && !empty($page->a_content) ? $page->a_content : '-' !!}
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <strong>{{ __('locale.elements.meta_title') }}</strong><br>
                                    <span class="arabic_text">
                                        {{ isset($page) && !empty($page->a_meta_title) ? $page->a_meta_title : '-' }}
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <strong>{{ __('locale.elements.meta_keywords') }}</strong><br>
                                    <span class="arabic_text">
                                        {!! isset($page) && !empty($page->a_meta_keywords) ? $page->a_meta_keywords : '-' !!}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <strong>{{ __('locale.elements.meta_description') }}</strong><br>
                                    <span class="arabic_text">
                                        {!! isset($page) && !empty($page->a_meta_description) ? $page->a_meta_description : '-' !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            //
        });
    </script>
@stop
