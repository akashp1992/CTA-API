<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                {{ __('locale.elements.is_active') }}
                {!! info_circle(config('elements.content.organizations.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($organization) ? 'checked="checked"' : (!empty($organization) && isset($organization->is_active) && $organization->is_active == 1 ? 'checked="checked"' : '')) }}>
                <span class="mr-3"></span>
            </label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_RTL_enabled">
                {{ __('locale.elements.is_RTL_enabled') }}
                {!! info_circle(config('elements.content.organizations.is_RTL_enabled')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_RTL_enabled"
                    {{ isset($organization) && $organization->is_RTL_enabled == 1 ? 'checked="checked"' : '' }}>
                <span class="mr-3"></span>
            </label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_time_print">
                Print Time On Invoice
                {!! info_circle(config('elements.content.organizations.is_time_print')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_time_print"
                    {{ (!isset($organization) ? 'checked="checked"' : (!empty($organization) && isset($organization->is_time_print) && $organization->is_time_print == 1 ? 'checked="checked"' : '')) }}>
                <span class="mr-3"></span>
            </label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_name_print">
                Print Name On Invoice
                {!! info_circle(config('elements.content.organizations.is_name_print')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_name_print"
                    {{ (!isset($organization) ? 'checked="checked"' : (!empty($organization) && isset($organization->is_name_print) && $organization->is_name_print == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.organizations.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name" minlength="3" 
                   value="{{ !empty($organization) && !empty($organization->name) ? $organization->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="identifier">
                {{ __('locale.elements.identifier') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.organizations.identifier')) !!}
            </label>
            @if(isset($organization) && !empty($organization->identifier))
                <div class="float-right">
                    <a href="javascript:void(0);"
                       data-href="{{ 'https://' . $organization->identifier . '.ridesglobal.fun' }}"
                       onclick="copyText($(this))">
                        Copy Console URL
                    </a>
                </div>
            @endif

            <input type="text" class="form-control" id="identifier" name="identifier"
                   value="{{ !empty($organization) && !empty($organization->identifier) ? $organization->identifier : old('identifier') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="start_date">
                {{ __('locale.elements.start_date') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.organizations.start_date')) !!}
            </label>
            <input type="text" class="form-control start_date_picker" readonly="readonly" placeholder="Select date"
                   id="start_date" name="start_date"
                   value="{{ !empty($organization) && !empty($organization->start_date)
                                ? \Carbon\Carbon::createFromTimestamp(strtotime($organization->start_date))->format('m/d/Y')
                                : old('start_date') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="end_date">
                {{ __('locale.elements.end_date') }}
                {!! info_circle(config('elements.content.organizations.end_date')) !!}
            </label>
            <input type="text" class="form-control end_date_picker" readonly="readonly" placeholder="Select date"
                   id="end_date" name="end_date"
                   value="{{ !empty($organization) && !empty($organization->end_date)
                                ? \Carbon\Carbon::createFromTimestamp(strtotime($organization->end_date))->format('m/d/Y')
                                : old('end_date') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="start_time">
                {{ __('locale.elements.start_time') }}
                <span class="text-danger">*</span>
            </label>
            <input name="start_time" id="start_time" class="form-control time_picker" value="{{ !empty($organization) && !empty($organization->start_time)
                ? \Carbon\Carbon::createFromTimestamp(strtotime($organization->start_time))->format('H:i')
                : old('start_time') }}" autocomplete="off">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="end_time">
                {{ __('locale.elements.end_time') }}
                <span class="text-danger">*</span>
            </label>
            <input name="end_time" id="end_time" class="form-control time_picker" value="{{ !empty($organization) && !empty($organization->end_time)
                ? \Carbon\Carbon::createFromTimestamp(strtotime($organization->end_time))->format('H:i')
                : old('end_time') }}" autocomplete="off">
        </div>
    </div>
    
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="business_type">
                {{ __('locale.elements.business_type') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.organizations.business_type')) !!}
            </label>
            <input type="text" class="form-control" id="business_type" name="business_type"
                   value="{{ !empty($organization) && !empty($organization->business_type) ? $organization->business_type : old('business_type') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="business_email">
                {{ __('locale.elements.business_email') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.organizations.business_email')) !!}
            </label>
            <input type="text" class="form-control" id="business_email" name="business_email"
                   value="{{ !empty($organization) && !empty($organization->business_email) ? $organization->business_email : old('business_email') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="civil_id_number">
                {{ __('locale.elements.civil_id_number') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.organizations.civil_id_number')) !!}
            </label>
            <input type="text" class="form-control" id="civil_id_number" name="civil_id_number"
                   value="{{ !empty($organization) && !empty($organization->civil_id_number) ? $organization->civil_id_number : old('civil_id_number') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="attachment">
                {{ __('locale.elements.attachment') }}
                {!! info_circle(config('elements.content.organizations.attachment')) !!}
            </label>
            @if(isset($organization) && !empty($organization->attachment))
                <div class="float-right input_action_buttons">
                    <a href="javascript:void(0);" target="_blank" class="remove_attachment"
                       data-module="organizations" data-field="attachment" data-id="{{ $organization->id }}">
                        Remove
                    </a>
                    &nbsp; | &nbsp;
                    <a href="{{ config('constants.s3.asset_url') . $organization->attachment }}"
                       target="_blank">
                        Preview
                    </a>
                </div>
            @endif
            <input type="file" class="form-control" id="attachment" name="attachment"
                   accept="image/jpg,image/png,image/jpeg"
                   value="{{ !empty($organization) && !empty($organization->attachment) ? $organization->attachment : '' }}">
            <input type="hidden" name="old_attachment"
                   value="{{ !empty($organization) && !empty($organization->attachment) ? $organization->attachment : '' }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="contact_person">
                {{ __('locale.elements.contact_person') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.organizations.contact_person')) !!}
            </label>
            <input type="text" class="form-control" id="contact_person" name="contact_person"
                   value="{{ !empty($organization) && !empty($organization->contact_person) ? $organization->contact_person : old('contact_person') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="phone">
                {{ __('locale.elements.phone') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.organizations.phone')) !!}
            </label>
            <input type="text" class="form-control" id="phone" name="phone" maxlength="10"
                   value="{{ !empty($organization) && !empty($organization->phone) ? $organization->phone : old('phone') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="email">
                {{ __('locale.elements.email') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.organizations.email')) !!}
            </label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ !empty($organization) && !empty($organization->email) ? $organization->email : old('email') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="users_count">
                {{ __('locale.elements.users_count') }}
                {!! info_circle(config('elements.content.organizations.users_count')) !!}
            </label>
            <input type="number" class="form-control" id="users_count" name="users_count"
                   min="0" max="10"
                   value="{{ !empty($organization) && !empty($organization->users_count) ? $organization->users_count : old('users_count') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="autocomplete">
                {{ __('locale.elements.location') }}
                <span class="text-danger">*</span>
            </label>
            <input type="text" id="autocomplete" class="form-control" name="location"
                   placeholder="Enter a location"
                   value="{{ !empty($organization) && !empty($organization->location) ? $organization->location : old('location') }}"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="currency_code">{{ __('locale.elements.currency') }}</label>
            <select name="currency_code" id="currency_code" class="form-control">
                <option value="">Please select a currency</option>
                @foreach(\App\Models\Organization::CURRENCIES as $currency_code => $currency_name)
                    <option value="{{ $currency_code }}"
                        {{ !empty($organization) && isset($organization->currency_code) && $organization->currency_code == $currency_code ? 'selected="selected"' : '' }}
                    >{{ $currency_name  . ' ( ' . $currency_code . ' )' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="payment_gateway">
                {{ __('locale.elements.payment_gateway') }}
            </label>
            <select name="payment_gateway" id="payment_gateway" class="form-control">
                <option value="">Please select a value</option>
                @foreach(\App\Models\Organization::PAYMENT_GATEWAYS as $key => $payment_gateway)
                    <option value="{{ $payment_gateway }}"
                        {{ !empty($organization) && isset($organization->payment_gateway) && $organization->payment_gateway == $payment_gateway ? 'selected="selected"' : '' }}
                    >{{ ucwords(str_replace('-', ' ', $payment_gateway)) }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                {{ __('locale.elements.description') }}
                {!! info_circle(config('elements.content.organizations.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($organization) && !empty($organization->description) ? $organization->description : old('description') }}</textarea>
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
