@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Dashboard')
@section('content')
{{-- <div class="row">
    <div class="col-12">
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="h4 text-blue">Parent Categories</h4>
                </div>
                <div class="pull-right">
                    <a href="#" class="btn btn-primary btn-sm">Add P. Category</a>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped table-sm">
                        <thead class="bg-secondary text-white">
                            <th>#</th>
                            <th>Name</th>
                            <th>N. of categories</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>P. cat 1</td>
                                <td>5</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="" class="text-primary mx-2">
                                            <i class="dw dw-edit2"></i>
                                        </a>
                                        <a href="" class="text-danger mx-2">
                                            <i class="dw dw-delete3"></i>
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
</div> --}}

@livewire('admin.categories')

@endsection
@push('scripts')
<script>
        //parent category call modal
        window.addEventListener('showParentCategoryModalForm', function(){
            $('#pcategory_modal').modal('show');
        });
        window.addEventListener('hideParentCategoryModalForm', function(){
            $('#pcategory_modal').modal('hide');
        });
        //category call modal
        window.addEventListener('showCategoryModalForm', function(){
            $('#category_modal').modal('show');
        });
        window.addEventListener('hideCategoryModalForm', function(){
            $('#category_modal').modal('hide');
        });
        $('table tbody#sortable_parent_categories').sortable({
            cursor:"move",
            update: function(event, ui){
                $(this).children().each(function(index){
                    if($(this).attr('data-ordering') != (index + 1)){
                        $(this).attr('data-ordering',(index+1)).addClass('updated');
                    }
                });
                var positions = [];
                $('.updated').each(function(){
                    positions.push([$(this).attr('data-index'),$(this).attr('data-ordering')]);
                    $(this).removeClass('updated');
                });
                
                //alert(positions);
                Livewire.dispatch('updateCategoryOrdering',[positions]);
            }
        });

        window.addEventListener('deleteParentCategory', function(event){
            var id = event.detail[0].id;
            $().konfirma({
                title: 'Are you sure ?',
                html: 'You want to delete this parent category.',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                width: 320,
                allowOutsideClick: false,
                fontSize: '0.87rem',
                done: function(){
                    //alert('delete now !!!');
                    Livewire.dispatch('deleteCategoryAction',[id]);
                }
            });
             //alert(id);
        });

</script>
@endpush