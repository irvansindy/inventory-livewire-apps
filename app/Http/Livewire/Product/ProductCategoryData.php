<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\ProductCategories;
Use Alert;

class ProductCategoryData extends Component
{
    public $allDataProductCategory, $categoryId, $categoryName;
    public $search;
    public $isModalOpen = 0;
    public $isEditModalOpen = 0;
    public $isDeleteModalOpen = 0;
    public $limitPerPage = 10;
    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'productCategory' => 'productCategoryPostData'
    ];

    public function productCategoryPostData() {
        $this->limitPerPage = $this->limitPerPage + 1;  
    }

    public function render()
    {
        $categories = ProductCategories::latest()->paginate($this->limitPerPage);

        if($this->search !== null) {
            $categories = ProductCategories::where('categoryName',  'LIKE', '%'.$this->search.'%')
            ->paginate($this->limitPerPage);
        }

        $this->emit('productCategoryPostData');
        return view('livewire.product.product-category-data', ['categories' => $categories]);
    }

    public function openModal() {
        $this->isModalOpen = true;
    }

    public function openEditModal() {
        $this->isEditModalOpen = true;
    }

    public function openDeleteModal() {
        $this->isDeleteModalOpen = true;
    }

    public function closeModal() {
        $this->isModalOpen = false;
        $this->isEditModalOpen = false;
        $this->isDeleteModalOpen = false;
    }

    public function resetCreateProductCategoryForm(){
        $this->categoryId = '';
        $this->categoryName = '';

    }

    public function createCategory() {
        $this->resetCreateProductCategoryForm();
        $this->openModal();
    }

    public function storeProductCategory(){
        $this->validate([
            'categoryName' => 'required|string|min:3|max:255',
        ]);

        ProductCategories::create([
            'categoryName' => $this->categoryName,
        ]);

        alert()->success('SuccessAlert','Product category has been created successfully.');

        $this->closeModal();
        $this->resetCreateProductCategoryForm();
    }

    public function editProductCategory($id) {
        $productCategory = ProductCategories::findOrFail($id);
        $this->categoryId = $id;
        $this->categoryName = $productCategory->categoryName;
        $this->openEditModal();
    }

    public function updateProductCategory() {
        $this->validate([
            'categoryName' => 'required|string|min:3|max:255',
        ]);

        $productCategory = ProductCategories::findOrFail($this->categoryId);
        $productCategory->update([
            'categoryName' => $this->categoryName,
        ]);

        alert()->success('SuccessAlert','Product category has been updated successfully.');

        $this->closeModal();
        $this->resetCreateProductCategoryForm();
    }

    public function confirmDeleteProductCategory($id) {
        $productCategory = ProductCategories::findOrFail($id);
        $this->categoryId = $id;
        $this->categoryName = $productCategory->categoryName;
        $this->openDeleteModal();
    }

    public function deleteProductCategory() {
        $productCategory = ProductCategories::findOrFail($this->categoryId);
        $productCategory->delete();

        alert()->success('SuccessAlert','Product category has been deleted successfully.');

        $this->closeModal();
        $this->resetCreateProductCategoryForm();
    }

    

}
