@if(!isset($request_from))
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="is_active">
                    {{ __('locale.elements.is_active') }}
                    {!! info_circle(config('elements.content.users.is_active')) !!}
                </label><br>
                <label class="checkbox mb-2">
                    <input type="checkbox" value="1" name="is_active"
                        {{ (!isset($user) ? 'checked="checked"' : (!empty($user) && isset($user->is_active) && $user->is_active == 1 ? 'checked="checked"' : '')) }}>
                    <span class="mr-3"></span>
                </label>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="group_id">
                {{ __('locale.elements.group') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.users.group')) !!}
            </label>

            @if(isset($request_from) && $request_from == 'profile')
                <p>{{ isset($user->group) && !empty($user->group->name) ? $user->group->name : '-' }}</p>
                <input type="hidden" name="group_id" value="{{ $user->group_id }}">
            @else
                <select name="group_id" id="group_id" class="form-control">
                    <option value="">Please select a value</option>
                    @foreach(\App\Providers\FormList::getGroups() as $key => $value)
                        @if(($is_root_user == 0 || auth()->user()->group_id != 1) && in_array($key, [1]))
                            <?php continue; ?>
                        @endif
                        <option value="{{ $key }}"
                            {{ !empty($user) && $user->group_id == $key ? 'selected="selected"' : '' }}
                        >{{ $value }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="name">
                {{ __('locale.elements.name') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.users.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($user) && !empty($user->name) ? $user->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="phone">
                {{ __('locale.elements.phone') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.users.phone')) !!}
            </label>
            <input type="text" class="form-control" id="phone" name="phone" maxlength="10"
                   value="{{ !empty($user) && !empty($user->phone) ? $user->phone : old('phone') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="email">
                {{ __('locale.elements.email') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.users.email')) !!}
            </label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ !empty($user) && !empty($user->email) ? $user->email : old('email') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="picture">
                {{ __('locale.elements.picture') }}
                {!! info_circle(config('elements.content.users.picture')) !!}
            </label>
            @if(isset($user) && !empty($user->picture))
                <div class="float-right input_action_buttons">
                    <a href="javascript:void(0);" target="_blank" class="remove_attachment"
                       data-module="users" data-field="picture" data-id="{{ $user->id }}">
                        Remove
                    </a>
                    &nbsp; | &nbsp;
                    <a href="{{ config('constants.s3.asset_url') . $user->picture }}"
                       target="_blank">
                        Preview
                    </a>
                </div>
            @endif
            <input type="file" class="form-control" id="picture" name="picture"
                   accept="image/*"
                   value="{{ !empty($user) && !empty($user->picture) ? $user->picture : '' }}">
            <input type="hidden" name="old_picture"
                   value="{{ !empty($user) && !empty($user->picture) ? $user->picture : '' }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="birth_date">
                {{ __('locale.elements.birth_date') }}
                {!! info_circle(config('elements.content.users.birth_Date')) !!}
            </label>
            <input type="text" class="form-control date_picker" readonly="readonly" placeholder="Select date"
                   id="birth_date" name="birth_date"
                   value="{{ !empty($user) && !empty($user->birth_date) ? \Carbon\Carbon::createFromTimestamp(strtotime($user->birth_date))->format('m/d/Y') : old('event_date') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="gender">
                {{ __('locale.elements.gender') }}
                {!! info_circle(config('elements.content.users.gender')) !!}
            </label>
            <div class="radio-inline">
                @foreach(\App\Models\User::GENDER as $key => $type)
                    <label class="radio">
                        <input type="radio" name="gender" value="{{ $type }}"
                            {{ (!isset($user) && $key == 0
                                    ? 'checked="checked"'
                                    : (!empty($user) && !empty($user->gender) && $user->gender == $type ? 'checked="checked"' : '')) }}>
                        <span></span>
                        {{ ucwords($type) }}
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>

@if(!isset($user))
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="password">
                    {{ __('locale.elements.password') }}
                    {!! info_circle(config('elements.content.users.password')) !!}
                </label>
                <input type="password" class="form-control" id="password" name="password" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="confirm_password">
                    {{ __('locale.elements.confirm_password') }}
                    {!! info_circle(config('elements.content.users.confirm_password')) !!}
                </label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="">
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="internal_notes">
                {{ __('locale.elements.internal_notes') }}
                {!! info_circle(config('elements.content.users.internal_notes')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="internal_notes" id="internal_notes"
                      placeholder="Type here something...">{{ !empty($user) && !empty($user->internal_notes) ? $user->internal_notes : old('internal_notes') }}</textarea>
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
