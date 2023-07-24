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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.cms_pages') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('pages', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>{{ __('locale.elements.index') }}</th>
                            <th>{{ __('locale.elements.title') }}</th>
                            <th>{{ __('locale.elements.content') }}</th>
                            <th>{{ __('locale.elements.is_active_q') }}</th>
                            <th>{{ __('locale.elements.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $index => $page)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ isset($page) && !empty($page->title) ? $page->title : '-' }}</td>
                                <td>
                                    @if(isset($page) && !empty($page->content))
                                        <span class="text-primary cursor-pointer"
                                              data-toggle="popover" data-placement="top"
                                              data-content="{{ $page->content }}">
                                            <i class="fa fa-paragraph"></i>
                                        </span>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td>{!! prepare_active_button('pages', $page) !!}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('pages', $page->slug, $accesses_urls) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
