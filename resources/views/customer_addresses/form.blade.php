<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="name">
                Name
                <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($address) && !empty($address->name) ? $address->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="phone">
                Phone
                <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="phone" name="phone"
                   value="{{ !empty($address) && !empty($address->phone) ? $address->phone : old('phone') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="block">Block</label>
            <input type="text" class="form-control" id="block" name="block"
                   value="{{ !empty($address) && !empty($address->block) ? $address->block : old('block') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="street">Street</label>
            <input type="text" class="form-control" id="street" name="street"
                   value="{{ !empty($address) && !empty($address->street) ? $address->street : old('street') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="house_name">House Name</label>
            <input type="text" class="form-control" id="house_name" name="house_name"
                   value="{{ !empty($address) && !empty($address->house_name) ? $address->house_name : old('house_name') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="avenue">Avenue</label>
            <input type="text" class="form-control" id="avenue" name="avenue"
                   value="{{ !empty($address) && !empty($address->avenue) ? $address->avenue : old('avenue') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="floor">Floor</label>
            <input type="text" class="form-control" id="floor" name="floor"
                   value="{{ !empty($address) && !empty($address->floor) ? $address->floor : old('floor') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="flat">Flat</label>
            <input type="text" class="form-control" id="flat" name="flat"
                   value="{{ !empty($address) && !empty($address->flat) ? $address->flat : old('flat') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="landmark">Landmark</label>
            <input type="text" class="form-control" id="landmark" name="landmark"
                   value="{{ !empty($address) && !empty($address->landmark) ? $address->landmark : old('landmark') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">Description</label>
            <textarea rows="3" cols="5" class="form-control" name="description"
                      id="description" placeholder="Type here something..."
            >{{ !empty($address) && !empty($address->description) ? $address->description : old('description') }}</textarea>
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
