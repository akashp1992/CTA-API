<option value="">Please select a value</option>
@if(count($categories) > 0)
    @foreach($categories as $key => $category)
        <option value="{{ $category->id }}"
            {{ isset($selected_category_id) && $selected_category_id == $category->id ? 'selected="selected"' : '' }}
        >{{ $category->name }}</option>
    @endforeach
@endif
