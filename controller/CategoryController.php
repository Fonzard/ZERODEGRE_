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
        
        if($_GET["route"] === "admin_product_create")
        {
            $this->render("admin/product/create", ["categories" => $categories]);   
        }
        if($_GET["route"] === "admin_product_edit" && isset($_GET["id"]))
        {
            $this->render("admin/product/edit", ["categories" => $categories]);   
        }
        
    }
    
}