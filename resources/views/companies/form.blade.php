@if(!isset($request_from))
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="is_active">
                    {{ __('locale.elements.is_active') }}
                    {!! info_circle(config('elements.content.companies.is_active')) !!}
                </label><br>
                <label class="checkbox mb-2">
                    <input type="checkbox" value="1" name="is_active"
                        {{ (!isset($company) ? 'checked="checked"' : (!empty($company) && isset($company->is_active) && $company->is_active == 1 ? 'checked="checked"' : '')) }}>
                    <span class="mr-3"></span>
                </label>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="name">
                {{ __('locale.elements.name') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.companies.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($company) && !empty($company->name) ? $company->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="arabic_name">
                {{ __('locale.elements.name_arabic') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.companies.arabic_name')) !!}
            </label>
            <input type="text" class="form-control" id="arabic_name" name="arabic_name"
                   value="{{ !empty($company) && !empty($company->arabic_name) ? $company->arabic_name : old('arabic_name') }}">
        </div>
    </div>
    @if(!isset($company))
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="prefix">
                {{ __('locale.elements.prefix') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.companies.prefix')) !!}
            </label>
            <input type="text" class="form-control" id="prefix" name="prefix" maxlength="4"
                   value="{{ !empty($company) && !empty($company->prefix) ? $company->prefix : old('prefix') }}">
        </div>
    </div>
    @endif
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="phone">
                {{ __('locale.elements.phone') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.companies.phone')) !!}
            </label>
            <input type="text" class="form-control" id="phone" name="phone" maxlength="10"
                   value="{{ !empty($company) && !empty($company->phone) ? $company->phone : old('phone') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="email">
                {{ __('locale.elements.email') }}
                {!! info_circle(config('elements.content.companies.email')) !!}
            </label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ !empty($company) && !empty($company->email) ? $company->email : old('email') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="contact_name">
                {{ __('locale.elements.contact_person_name') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.companies.contact_name')) !!}
            </label>
            <input type="text" class="form-control" id="contact_name" name="contact_name"
                   value="{{ !empty($company) && !empty($company->contact_name) ? $company->contact_name : old('contact_name') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="contact_phone">
                {{ __('locale.elements.contact_person_phone') }}
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.companies.contact_phone')) !!}
            </label>
            <input type="text" class="form-control" id="contact_phone" name="contact_phone" maxlength="10"
                   value="{{ !empty($company) && !empty($company->contact_phone) ? $company->contact_phone : old('contact_phone') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="contact_email">
                {{ __('locale.elements.contact_person_email') }}
                {!! info_circle(config('elements.content.companies.contact_email')) !!}
            </label>
            <input type="text" class="form-control" id="contact_email" name="contact_email"
                   value="{{ !empty($company) && !empty($company->contact_email) ? $company->contact_email : old('contact_email') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="internal_notes">
                {{ __('locale.elements.address') }}
                {!! info_circle(config('elements.content.companies.address')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="address" id="address"
                      placeholder="Type here something...">{{ !empty($company) && !empty($company->address) ? $company->address : old('address') }}</textarea>
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
