<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ParentCategory;
use App\Models\Category;

class Categories extends Component
{
    public $isUpdateParentCategoryMode = false;
    public $pcategory_id, $pcategory_name;

    public $isUpdateCategoryMode = false;
    public $category_id, $parent = 0, $category_name;

    protected $listeners = [
        'updateCategoryOrdering',
        'deleteCategoryAction'
    ] ;
    
    /**
     * addParentCategory
     *
     * @return void
     */
    public function addParentCategory()
    {
        //dd('addParentCategory terpanggil');
        //dd("Show add parent category modal from");
        $this->pcategory_id = null;
        $this->pcategory_name = null;
        $this->isUpdateParentCategoryMode = false;
        $this->showParentCategoryModalForm();
    }

    public function createParentCategory()
    {
        //dd($this->request()->all());
       //dd($this->pcategory_name);
        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name',
        ],[
            'pcategory_name.required'=> 'Parent category field is required',
            'pcategory_name.unique'=>'Parent category name is already exists'
        ]);

        //store new parent category
        $pcategory = new ParentCategory();
        $pcategory->name = $this->pcategory_name;
        $saved = $pcategory->save();

        if($saved)
        {
            $this->hideParentCategoryModalForm();
            $this->dispatch('showToastr',['type'=>'success','message'=> 'New parent category has been created succesfully']);
        }else{
            $this->dispatch('showToastr',['type'=>'error','message'=> 'Something went wrong']);
        }
    }

    public function editParentCategory($id)
    {
        $pcategory = ParentCategory::findOrFail($id);
        $this->pcategory_id = $pcategory->id ;
        $this->pcategory_name = $pcategory->name;
        $this->isUpdateParentCategoryMode = true;
        $this->showParentCategoryModalForm();
    }

    public function updateParentCategory()
    {
        $pcategory = ParentCategory::findOrFail($this->pcategory_id);

        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name,'.$pcategory->id
        ],[
            'pcategory_name.required'=>'Parent category field is required.',
            'pcategory_name.unique'=> 'Parent category name is taken.'
        ]);

        //update parent category
        $pcategory->name = $this->pcategory_name;
        $pcategory->slug = null;
        $updated = $pcategory->save();

        if($updated){
            $this->hideParentCategoryModalForm();
            $this->dispatch('showToastr',['type'=> 'success','message'=>'Parent category has been updated succesfully']);
        }else{
            $this->dispatch('showToastr',['type'=> 'error','message'=>'Something went wrong']);
        }
    }
    //end method
    public function updateCategoryOrdering($positions){
        //dd($positions);
        foreach( $positions as $position ){
            $index = $position[0];
            $new_position = $position[1];
            ParentCategory::where('id',$index)->update([
                'ordering'=> $new_position
            ]);
            $this->dispatch('showToastr',['type'=> 'success','message'=> 'Parent Categories ordering has been updated succesfully']);
        }
    }
    
    /**
     * deleteParentCategory
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteParentCategory($id){
        $this->dispatch('deleteParentCategory',['id'=>$id]);
    }

    public function deleteCategoryAction($id){
        $pcategory = ParentCategory::findOrFail($id);
        
        //check if this parent category as children

        //del parent category
        $delete = $pcategory->delete();
        if( $delete ){
            $this->dispatch('showToastr',['type'=>'success','message'=> 'Parent category has been deleted succesfully']);
        }else{
            $this->dispatch('showToastr',['type'=> 'error','message'=>'Something went wrong']);
        }
    }
    /**
     * showParentCategoryModalForm
     *
     * @return void
     */
    public function showParentCategoryModalForm()
    {
        $this->resetErrorBag();
        $this->dispatch('showParentCategoryModalForm');
    }

    public function hideParentCategoryModalForm()
    {
        $this->dispatch('hideParentCategoryModalForm');
        $this->isUpdateParentCategoryMode = false;
        $this->pcategory_id = $this->pcategory_name = null;
    }

    public function addCategory()
    {
        //dd('addCategory terpanggil');
        $this->category_id = null;
        $this->parent = 0 ;
        $this->category_name = null;
        $this->isUpdateCategoryMode = false;
        $this->showCategoryModalForm();
    }

    public function createCategory()
    {
        $this->validate([
            'category_name' => 'required|unique:categories,name',
        ],[
            'category_name.required'=> 'Category field is required',
            'category_name.unique'=> 'Category name is already exists.',
        ]);

        //store new Category
        $category = new Category();
        $category->parent = $this->parent;
        $category->name = $this->category_name;
        $saved = $category->save();

        if( $saved){
            $this->hideCategoryModalForm();
            $this->dispatch('showToastr',['type'=> 'success','message'=> 'New Category has been created succesfully']);
        }else{
            $this->dispatch('showToastr',['type'=> 'error','message'=> 'Something went wrong']);
        }
    }

    public function showCategoryModalForm(){
        $this->resetErrorBag();
        $this->dispatch('showCategoryModalForm');
    }

    public function hideCategoryModalForm()
    {
        $this->dispatch('hideCategoryModalForm');
        $this->isUpdateParentCategoryMode = false;
        $this->category_id = $this->category_name = null;
        $this->parent = 0;
    }

    public function render()
    {
        return view('livewire.admin.categories',[
            'pcategories'=>ParentCategory::orderBy('ordering','asc')->get(),
        ]);
    }
}
