<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                {{ __('locale.elements.is_active') }}
                {!! info_circle(config('elements.content.groups.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($group) ? 'checked="checked"' : (!empty($group) && isset($group->is_active) && $group->is_active == 1 ? 'checked="checked"' : '')) }}>
                <span class="mr-3"></span>
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="name">
                {{ __('locale.elements.name') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.groups.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($group) && !empty($group->name) ? $group->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                {{ __('locale.elements.description') }}
                {!! info_circle(config('elements.content.groups.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($group) && !empty($group->description) ? $group->description : old('description') }}</textarea>
        </div>
    </div>
</div>

<div class="row system_modules">
    <div class="col-md-12">
        <div class="form-group">
            <br>
            <p>
                <strong>{{ __('locale.elements.system_modules') }}</strong>
                {!! info_circle(config('elements.content.groups.system_modules')) !!}
            </p>
            <hr>

            <?php $system_modules = \App\Models\Group::SYSTEM_MODULES; ?>
            @if(!empty($system_modules) && count($system_modules) > 0)
                <div class="row">
                    <?php $index = 0; ?>
                    @foreach($system_modules['navigation'] as $navigation_heading => $system_modules)
                        <div class="col-md-12 mt-5 mb-5">
                            <h4><strong>{{ ucwords(str_replace(array('-', '_'), ' ', $navigation_heading)) }}</strong></h4>
                        </div>

                        @if(!empty($system_modules))
                            @foreach($system_modules as $key => $system_module)
                                <div class="col-md-2 parent_module">
                                    <p class="mb-5">
                                        <strong>{{ ucwords(str_replace(array('-', '_'), ' ', $key)) }}</strong></p>

                                    <label class="checkbox mb-5">
                                        <input type="checkbox" class="select_all_checkboxes">
                                        <span class="mr-3"></span>
                                        Select ALL
                                    </label>

                                    @foreach($system_module as $module)
                                        <label class="checkbox mb-2">
                                            <input type="checkbox" class="system_module_checkboxes"
                                                   name="system_modules[]"
                                                   value="{{ $module }}"
                                                {{ isset($selected_access) && in_array($module, $selected_access) ? 'checked="checked"' : '' }}>
                                            <span class="mr-3"></span>

                                            <?php
                                            $module_name = str_replace(array('_', '.'), array(' ', ' '), explode('.', $module))[1];

                                            switch ($module_name) {
                                                case 'index':
                                                    $module_display_name = 'listing';
                                                    break;
                                                case 'show':
                                                    $module_display_name = 'read';
                                                    break;
                                                case 'edit':
                                                    $module_display_name = 'update';
                                                    break;
                                                default:
                                                    $module_display_name = $module_name;
                                                    break;
                                            }
                                            ?>

                                            {{ ucwords($module_display_name) }}
                                        </label>
                                    @endforeach
                                    <br>
                                    <?php $index++; ?>
                                </div>
                            @endforeach
                        @endif

                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
