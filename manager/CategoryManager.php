<?php

class CategoryManager extends AbstractManager {
    
    //Générale CategoriesProducts
    public function getAllCategoriesProducts()
    {
        $class = "Category";
        $query = "SELECT * FROM categories_products";
        $results = $this->getResult($query, null, $class, false);
        return $results;
    }
    
    public function getCategoriesProductsName($categoryId) 
    {
        
        $query = "SELECT categories_products.name FROM categories_products WHERE categories_products.id = :categoryId";
        $parameters = array(':categoryId' => $categoryId);
        
        $result = $this->getQuery($query, $parameters, true);
        return $result;

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
    
    public function deleteCategoriesProducts(int $categoryId) : void
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
    //Générale Categories Post
    public function getAllCategoriesPost()
    {
        $class = "Category";
        $query = "SELECT * FROM categories_post";
        $results = $this->getResult($query, null, $class, false);
        return $results;
    }

    public function getCategoriesPostName($categoryId) 
    {
        
        $query = "SELECT name FROM categories_post WHERE id = :categoryId";
        $parameters = array(':categoryId' => $categoryId);
        
        $result = $this->getQuery($query, $parameters, true);
        return $result;

    }
}