<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="name">
                Name
                <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($server_key) && !empty($server_key->name) ? $server_key->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="app_id">
                App ID
                <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="app_id" name="app_id"
                   value="{{ !empty($server_key) && !empty($server_key->app_id) ? $server_key->app_id : old('app_id') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="app_key">
                App Key
                <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="app_key" name="app_key"
                   value="{{ !empty($server_key) && !empty($server_key->app_key) ? $server_key->app_key : old('app_key') }}">
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
