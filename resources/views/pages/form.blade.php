<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                {{ __('locale.elements.is_active') }}
                {!! info_circle(config('elements.content.pages.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($page) ? 'checked="checked"' : (!empty($page) && isset($page->is_active) && $page->is_active == 1 ? 'checked="checked"' : '')) }}>
                <span class="mr-3"></span>
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active"
                   data-toggle="tab" href="#tab_english"
                   role="tab">English</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                   data-toggle="tab" href="#tab_arabic"
                   role="tab">Arabic</a>
            </li>
        </ul>
        <div class="tab-content tabs card-block py-10">
            <div class="tab-pane active" id="tab_english" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="title">
                                {{ __('locale.elements.title') }}
                                <span class="text-danger">*</span>
                                {!! info_circle(config('elements.content.pages.title')) !!}
                            </label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="{{ !empty($page) && !empty($page->title) ? $page->title : old('title') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="content">
                                {{ __('locale.elements.content') }}
                                <span class="text-danger">*</span>
                                {!! info_circle(config('elements.content.pages.content')) !!}
                            </label>
                            <textarea rows="3" cols="5" class="form-control summernote" name="content" id="content"
                                      placeholder="Type here something...">{{ !empty($page) && !empty($page->content) ? $page->content : old('content') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="meta_title">
                                {{ __('locale.elements.meta_title') }}
                                {!! info_circle(config('elements.content.pages.meta_title')) !!}
                            </label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title"
                                   value="{{ !empty($page) && !empty($page->meta_title) ? $page->meta_title : old('meta_title') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="meta_keywords">
                                {{ __('locale.elements.meta_keywords') }}
                                {!! info_circle(config('elements.content.pages.meta_keywords')) !!}
                            </label>
                            <textarea rows="3" cols="5" class="form-control" name="meta_keywords" id="meta_keywords"
                                      placeholder="Type here something...">{{ !empty($page) && !empty($page->meta_keywords) ? $page->meta_keywords : old('meta_keywords') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="meta_description">
                                {{ __('locale.elements.meta_description') }}
                                {!! info_circle(config('elements.content.pages.meta_description')) !!}
                            </label>
                            <textarea rows="3" cols="5" class="form-control" name="meta_description"
                                      id="meta_description"
                                      placeholder="Type here something...">{{ !empty($page) && !empty($page->meta_description) ? $page->meta_description : old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_arabic" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="a_title">
                                {{ __('locale.elements.title') }}
                                <span class="text-danger">*</span>
                                {!! info_circle(config('elements.content.pages.title')) !!}
                            </label>
                            <input type="text" class="form-control" id="a_title" name="a_title"
                                   value="{{ !empty($page) && !empty($page->a_title) ? $page->a_title : old('a_title') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="a_content">
                                {{ __('locale.elements.content') }}
                                <span class="text-danger">*</span>
                                {!! info_circle(config('elements.content.pages.content')) !!}
                            </label>
                            <textarea rows="3" cols="5" class="form-control summernote" name="a_content" id="a_content"
                                      placeholder="Type here something...">{{ !empty($page) && !empty($page->a_content) ? $page->a_content : old('a_content') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="a_meta_title">
                                {{ __('locale.elements.meta_title') }}
                                {!! info_circle(config('elements.content.pages.meta_title')) !!}
                            </label>
                            <input type="text" class="form-control" id="a_meta_title" name="a_meta_title"
                                   value="{{ !empty($page) && !empty($page->a_meta_title) ? $page->a_meta_title : old('a_meta_title') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="a_meta_keywords">
                                {{ __('locale.elements.meta_keywords') }}
                                {!! info_circle(config('elements.content.pages.meta_keywords')) !!}
                            </label>
                            <textarea rows="3" cols="5" class="form-control" name="a_meta_keywords" id="a_meta_keywords"
                                      placeholder="Type here something...">{{ !empty($page) && !empty($page->a_meta_keywords) ? $page->a_meta_keywords : old('a_meta_keywords') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="a_meta_description">
                                {{ __('locale.elements.meta_description') }}
                                {!! info_circle(config('elements.content.pages.meta_description')) !!}
                            </label>
                            <textarea rows="3" cols="5" class="form-control" name="a_meta_description"
                                      id="a_meta_description"
                                      placeholder="Type here something...">{{ !empty($page) && !empty($page->a_meta_description) ? $page->a_meta_description : old('a_meta_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
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
