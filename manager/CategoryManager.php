<?php

class CategoryManager extends AbstractManager {
    
    //A vérifier
    //Générale CategoriesProducts
    public function getAllCategoriesProducts()
    {
        $class = "Category";
        $query = "SELECT * FROM categories_products";
        $results = $this->getResult($query, null, $class, false);
        return $results;
    }
    
    
    public function createCategoriesProducts(Category $category)
    {
        $query = "INSERT INTO categories_products(name) VALUES (:name)";
        $parameters = array("name" => $category->getName());
        $this->getQuery($query, $parameters);
        
        $lastInsertId = $this->connex->lastInsertId();
        
        // A vérifier !!!
        $category->setId($lastInsertId);
        return $category;
    }
    
    public function deleteCategoriesProducts(in $categoryId) : void
    {
        $query = "DELETE FROM categories_products WHERE id = :id";
        $parameters = array("id" => $categoryId);
        
        $this->getQuery($query, $parameters, true);
    }

    public function editCategoriesProducts(Category $category) : void
    {
        $query ="UPDATE categories_products SET name = :name";
        $parameters = array("name" => $category->getName());
        
        $this->getQuery($query, $parameters);
    }
    
}