<?php

class CategoryController extends AbstractController{

    private CategoryManager $cm;
    
    public function __construct()
    {
        $this->cm = new CategoryManager();
    }
    
    public function manageCategoryProduct()
    {
        $categories = $this->cm->getAllCategoriesProducts();
        if(true)
        {
            $this->render("admin/product/create", ["categories" => $categories]);   
        }
        else
        {
            $this->render("admin/product/edit", ["categories" => $categories]);   
        }
        
    }
    
}