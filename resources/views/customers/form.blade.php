<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                {{ __('locale.elements.is_active') }}
                {!! info_circle(config('elements.content.customers.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($customer) ? 'checked="checked"' : (!empty($customer) && isset($customer->is_active) && $customer->is_active == 1 ? 'checked="checked"' : '')) }}>
                <span class="mr-3"></span>
            </label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="type">
                Type
                {!! info_circle(config('elements.content.customers.type')) !!}
            </label>
            <div class="radio-inline">
                @foreach(\App\Models\Customer::TYPE as $key => $type)
                    <label class="radio">
                        <input type="radio" name="type" class="customer_type" value="{{ $type }}"
                            {{ (!isset($customer) && $key == 0
                                    ? 'checked="checked"'
                                    : (!empty($customer) && !empty($customer->type) && $customer->type == $type ? 'checked="checked"' : '')) }}>
                        <span></span>
                        {{ ucwords($type) }}
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    @if(auth()->user()->is_root_user == 1)
        <div class="col-md-6 organization_id_selection {{ (!isset($customer) ? 'd-none' : (!empty($customer->type) && $customer->type == 'admin' ? '' : 'd-none')) }}">
            <div class="form-group">
                <label class="form-label" for="organization_id">
                    {{ __('locale.sidebar.organizations') }}
                </label>
                <select name="organization_ids[]" id="organization_ids" class="form-control organization_ids select2" multiple>
                    @foreach(\App\Providers\FormList::getAllOrganizations() as $organizations_list)
                        <option value="{{ $organizations_list->id }}"
                            {{ isset($customer) && count($customer->admin_organizations) > 0 && in_array($organizations_list->id, $customer->admin_organizations->pluck('organization_id')->toArray()) ? 'selected="selected"' : '' }}
                        >{{ $organizations_list->name ?? '-' }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="name">
                {{ __('locale.elements.name') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.customers.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($customer) && !empty($customer->name) ? $customer->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="phone">
                {{ __('locale.elements.phone') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.customers.phone')) !!}
            </label>
            <input type="text" class="form-control" id="phone" name="phone" maxlength="10"
                   value="{{ !empty($customer) && !empty($customer->phone) ? $customer->phone : old('phone') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="email">
                {{ __('locale.elements.email') }}
                {!! info_circle(config('elements.content.customers.email')) !!}
            </label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ !empty($customer) && !empty($customer->email) ? $customer->email : old('email') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="picture">
                {{ __('locale.elements.picture') }}
                {!! info_circle(config('elements.content.customers.picture')) !!}
            </label>
            @if(isset($customer) && !empty($customer->picture))
                <div class="float-right input_action_buttons">
                    <a href="javascript:void(0);" target="_blank" class="remove_attachment"
                       data-module="customers" data-field="picture" data-id="{{ $customer->id }}">
                        Remove
                    </a>
                    &nbsp; | &nbsp;
                    <a href="{{ config('constants.s3.asset_url') . $customer->picture }}"
                       target="_blank">
                        Preview
                    </a>
                </div>
            @endif
            <input type="file" class="form-control" id="picture" name="picture"
                   accept="image/*"
                   value="{{ !empty($customer) && !empty($customer->picture) ? $customer->picture : '' }}">
            <input type="hidden" name="old_picture"
                   value="{{ !empty($customer) && !empty($customer->picture) ? $customer->picture : '' }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="birth_date">
                {{ __('locale.elements.birth_date') }}
                {!! info_circle(config('elements.content.customers.birth_Date')) !!}
            </label>
            <input type="text" class="form-control date_picker" readonly="readonly" placeholder="Select date"
                   id="birth_date" name="birth_date"
                   value="{{ !empty($customer) && !empty($customer->birth_date) ? \Carbon\Carbon::createFromTimestamp(strtotime($customer->birth_date))->format('m/d/Y') : old('event_date') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="height">
                {{ __('locale.elements.height_inch') }}
                {!! info_circle(config('elements.content.customers.height')) !!}
            </label>
            <input type="text" class="form-control" id="height" name="height"
                   value="{{ !empty($customer) && !empty($customer->height) ? $customer->height : old('height') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="weight">
                {{ __('locale.elements.weight_kg') }}
                {!! info_circle(config('elements.content.customers.weight')) !!}
            </label>
            <input type="text" class="form-control" id="weight" name="weight"
                   value="{{ !empty($customer) && !empty($customer->weight) ? $customer->weight : old('weight') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="gender">
                {{ __('locale.elements.gender') }}
                {!! info_circle(config('elements.content.customers.gender')) !!}
            </label>
            <div class="radio-inline">
                @foreach(\App\Models\User::GENDER as $key => $type)
                    <label class="radio">
                        <input type="radio" name="gender" value="{{ $type }}"
                            {{ (!isset($customer) && $key == 0
                                    ? 'checked="checked"'
                                    : (!empty($customer) && !empty($customer->gender) && $customer->gender == $type ? 'checked="checked"' : '')) }}>
                        <span></span>
                        {{ ucwords($type) }}
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>

@if(!isset($customer))
    <div class="row customer_password_section">
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="password">
                    {{ __('locale.elements.password') }}
                    {!! info_circle(config('elements.content.customers.password')) !!}
                </label>
                <input type="password" class="form-control" id="password" name="password" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="confirm_password">
                    {{ __('locale.elements.confirm_password') }}
                    {!! info_circle(config('elements.content.customers.confirm_password')) !!}
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
                {!! info_circle(config('elements.content.customers.internal_notes')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="internal_notes" id="internal_notes"
                      placeholder="Type here something...">{{ !empty($customer) && !empty($customer->internal_notes) ? $customer->internal_notes : old('internal_notes') }}</textarea>
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
