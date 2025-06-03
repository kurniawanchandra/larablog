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
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>P. cat 1</td>
                                <td>5</td>
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

        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="h4 text-blue mb-0">Categories</h4>
                    <a href="#" class="btn btn-primary btn-sm">Add Category</a>
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
            <form class="modal-content" wire:submit="{{ $isUpdateParentCategoryMode ? 'updateParentCategory()' : 'addParentCategory()' }}">
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

    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
</div>