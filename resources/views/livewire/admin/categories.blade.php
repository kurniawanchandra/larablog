<div>
    <div class="row">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="h4 text-blue mb-0">Parent Categories</h4>
                    <a href="javascript:;" wire:click="addParentCategory()" class="btn btn-primary btn-sm">Add P.
                        Category</a>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped table-sm">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>N. of categories</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable_parent_categories">
                            @forelse ($pcategories as $item)
                                <tr data-index="{{ $item->id }}" data-ordering={{ $item->ordering }}>
                                {{-- <td>{{ $item->id }}</td> --}}
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td> - </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="javascript:;" wire:click="editParentCategory({{ $item->id }})" class="text-primary mx-2">
                                            <i class="dw dw-edit2"></i>
                                        </a>
                                        <a href="javascript:;" wire:click="deleteParentCategory({{ $item->id }})" class="text-danger mx-2">
                                            <i class="dw dw-delete-3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center"> 
                                    <span class="text-danger ml-1"><b>No item found !!!</b></span>
                                </td>
                            </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="h4 text-blue mb-0">Categories</h4>
                    <a href="javascript:;" wire:click="addCategory()" class="btn btn-primary btn-sm">Add Category</a>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>N. of categories</th>
                                <th>N. of parent</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>P. cat 1</td>
                                <td>5</td>
                                <td>10</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="#" class="text-primary mx-2">
                                            <i class="dw dw-edit2"></i>
                                        </a>
                                        <a href="#" class="text-danger mx-2">
                                            <i class="dw dw-delete-3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modals --}}
    <div wire:ignore.self class="modal fade" id="pcategory_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" wire:submit="{{ $isUpdateParentCategoryMode ? 'updateParentCategory()' : 'createParentCategory()' }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ $isUpdateParentCategoryMode ? 'Update Category' : 'Add Category' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                  @if($isUpdateParentCategoryMode)
                    <input type="hidden" wire:model="pcategory_id">
                  @endif
                  <div class="form-group">
                    <label for=""><b>Parent Category Name</b></label>
                    <input type="text" class="form-control" wire:model="pcategory_name" placeholder="Enter parent category name here....">
                    @error('pcategory_name')
                       <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ $isUpdateParentCategoryMode ? 'Save Changes' : 'Create'}}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="category_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" wire:submit="{{ $isUpdateCategoryMode ? 'updateCategory()' : 'createCategory()' }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ $isUpdateCategoryMode ? 'Update Category' : 'Add Category' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                  @if($isUpdateCategoryMode)
                    <input type="hidden" wire:model="category_id">
                  @endif
                  <div class="form-group">
                    <label for=""><b>Parent Category</b></label>
                    <select wire:model="parent" id="" class="custom-select">
                        <option value="0">Uncategorized</option>
                        @foreach ($pcategories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('parent')
                        <span class="text-danger ml0">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for=""><b>Category Name</b></label>
                    <input type="text" class="form-control" wire:model="category_name" placeholder="Enter category name here....">
                    @error('category_name')
                       <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ $isUpdateCategoryMode ? 'Save Changes' : 'Create'}}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
</div>