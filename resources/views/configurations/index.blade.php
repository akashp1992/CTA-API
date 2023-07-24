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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.configurations') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('configurations') !!}
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('configurations.update') }}" method="post"
                          enctype="multipart/form-data" class="configuration_form" id="configuration_form">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs tabs" role="tablist">
                                    @if(isset($configurations) && count($configurations) > 0)
                                        @foreach($configurations as $configuration_key => $configuration)
                                            <li class="nav-item">
                                                <a class="nav-link <?php echo $configuration_key == 0 ? 'active' : '' ?>"
                                                   data-toggle="tab" href="#tab_{{ $configuration_key }}"
                                                   role="tab">{{ ucwords($configuration->display_text) }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="tab-content tabs card-block py-10">
                                    @if(isset($configurations) && count($configurations) > 0)
                                        @foreach($configurations as $configuration_key => $configuration)
                                            <div
                                                class="tab-pane <?php echo $configuration_key == 0 ? 'active' : '' ?>"
                                                id="tab_{{ $configuration_key }}" role="tabpanel">

                                                @if(isset($configuration->child_configurations) && count($configuration->child_configurations) > 0)
                                                    <div class="row">
                                                        @foreach($configuration->child_configurations as $child_configuration)
                                                            @if($child_configuration->input_type == 'text')
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                               for="{{ $child_configuration->key }}">
                                                                            {{ ucwords($child_configuration->display_text) }}
                                                                            {!! info_circle(config('elements.content.configurations.' . $child_configuration->key)) !!}
                                                                        </label>
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="{{ $child_configuration->key }}"
                                                                               name="configurations[{{ $child_configuration->parent_id }}][{{ $child_configuration->key }}]"
                                                                               value="{{ $child_configuration->value }}">
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if($child_configuration->input_type == 'select')
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                               for="{{ $child_configuration->key }}">
                                                                            {{ ucwords($child_configuration->display_text) }}
                                                                            {!! info_circle(config('elements.content.configurations.' . $child_configuration->key)) !!}
                                                                        </label>

                                                                        <?php $options = !empty($child_configuration->options) ? json_decode($child_configuration->options) : [] ?>
                                                                        <select
                                                                            name="configurations[{{ $child_configuration->parent_id }}][{{ $child_configuration->key }}]"
                                                                            class="form-control"
                                                                            id="{{ $child_configuration->key }}">
                                                                            <option value="">Please select a value
                                                                            </option>
                                                                            @foreach($options as $option)
                                                                                <option value="{{ $option }}"
                                                                                    {{ $option == $child_configuration->value ? 'selected="selected"' : '' }}
                                                                                >{{ $option }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if($child_configuration->input_type == 'file')
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                               for="{{ $child_configuration->key }}">{{ ucwords($child_configuration->display_text) }}</label>

                                                                        @if(isset($child_configuration->value) && !empty($child_configuration->value))
                                                                            <a href="{{ config('constants.s3.asset_url') . $child_configuration->value }}"
                                                                               target="_blank"
                                                                               class="float-right">
                                                                                <i class="fa fa-image"></i>
                                                                            </a>
                                                                        @endif

                                                                        <input type="file"
                                                                               class="form-control"
                                                                               id="{{ $child_configuration->key }}"
                                                                               name="configurations[{{ $child_configuration->parent_id }}][{{ $child_configuration->key }}]"
                                                                               value="{{ $child_configuration->value }}">
                                                                        <input type="hidden"
                                                                               name="configurations[{{ $child_configuration->parent_id }}][{{ $child_configuration->key }}]"
                                                                               value="{{ $child_configuration->value }}">
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if($child_configuration->input_type == 'textarea')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                               for="{{ $child_configuration->key }}">{{ ucwords($child_configuration->display_text) }}</label>
                                                                        <textarea rows="5" cols="5"
                                                                                  class="form-control"
                                                                                  name="configurations[{{ $child_configuration->parent_id }}][{{ $child_configuration->key }}]"
                                                                                  {{ $child_configuration->key }}
                                                                                  placeholder="Type here something...">{{ $child_configuration->value }}</textarea>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button type="submit"
                                                                        class="btn btn-primary">Submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        //
    </script>
@stop
