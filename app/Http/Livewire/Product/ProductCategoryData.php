<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\ProductCategories;


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
        $this->categoryId = null;
        $this->categoryName = null;

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

        session()->flash('success', 'Category has been created');

        $this->closeModal();
        $this->resetCreateProductCategoryForm();
    }

    public function editProductCategory($id) {
        $productCategory = ProductCategories::find($id);
        $this->categoryId = $productCategory->categoryId;
        $this->categoryName = $productCategory->categoryName;
    }

    public function deleteProductCategory($id) {
        $productCategory = ProductCategories::find($id);
        $productCategory->delete();
        $this->emit('productCategoryPostData');
    }

    

}
