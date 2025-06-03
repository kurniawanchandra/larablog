<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a wire:click="selectTab('general_settings')"
                    class="nav-link {{ $tab == 'general_settings' ? 'active' : '' }}" data-toggle="tab"
                    href="#general_settings" role="tab" aria-selected="true">General Settings</a>
            </li>
            <li class="nav-item">
                <a wire:click="selectTab('logo_favicon')" class="nav-link {{ $tab == 'logo_favicon' ? 'active' : '' }}"
                    data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="false">Logo & Favicon</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade {{ $tab == 'general_settings' ? 'active show' : '' }}" id="general_settings"
                role="tabpanel">
                <div class="pd-20">
                    <form wire:submit='updateSiteInfo()'>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site Title</b></label>
                                    <input type="text" class="form-control" wire:model="site_title"
                                        placeholder="Enter Site Title">
                                    @error('site_title')
                                    <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site Email</b></label>
                                    <input type="text" class="form-control" wire:model="site_email"
                                        placeholder="Enter Site Email">
                                    @error('site_email')
                                    <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site phone number</b></label>
                                    <input type="text" class="form-control" wire:model="site_phone"
                                        placeholder="Enter Phone Number">
                                    @error('site_phone_number')
                                    <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site Meta Keywords<small> (Optional)</small></b></label>
                                    <input type="text" class="form-control" wire:model="site_meta_keywords"
                                        placeholder="Eg: ecommerce, free api, laravel">
                                    @error('site_meta_keywords')
                                    <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for=""><b>Site Meta Description</b><small>(Optional)</small></label>
                            <textarea class="form-control" id="4" rows="4"
                                placeholder="Type site meta Description..."></textarea>
                            @error('site_meta_description')
                            <span class="text-danger ml-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'logo_favicon' ? 'active show' : '' }}" id="logo_favicon"
                role="tabpanel">
                <div class="pd-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Site Logo</h6>
                            <div class="mb-2 mt-1" style="max-width: 200px">
                                <img wire:ignore src="" alt="" class="img-thumbnail"
                                    data-ijabo-default-img="/images/site/{{ isset(settings()->site_logo) ? settings()->site_logo : '' }}"
                                    id="preview_site_logo">
                            </div>
                            <form action="{{ route('admin.update_logo') }}" method="POST" enctype="multipart/form-data"
                                id="updateLogoForm">
                                @csrf
                                <div class="mb0">
                                    <input type="file" name="site_logo" id="" class="form-control">
                                    <span class="text-danger ml-1"></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Change Logo</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h6>Site Favicon</h6>
                            <div class="mb-2 mt-1" style="max-width: 100px">
                                <img wire:ignore src="" alt="" class="img-thumbnail"
                                    data-ijabo-default-img="/images/site/{{ isset(settings()->site_favicon) ? settings()->site_favicon : ''}}"
                                    id="preview_site_favicon">
                            </div>
                            <form action="{{ route('admin.update_favicon') }}" method="POST" enctype="multipart/form-data" id="updateFaviconForm">
                                @csrf
                                <div class="mb-2">
                                    <input type="file" name="site_favicon" id="" class="form-control">
                                    <span class="text-danger ml-1"></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Change Favicon</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>