<?php

class ProductManager extends AbstractManager {
    
    public function getAllProducts() : array
    {
        $class = "Product";
        $query = ("SELECT * FROM products");
        $results = $this->getResult($query, null, $class, false);
        // var_dump($results);
        return $results;
    }

    public function getProductByName(string $name) : ? User
    {
        $class = "Product";
        $query = "SELECT * FROM products WHERE products.name = :name";
        $parameters = array(":name" => name);
        
        $result = $this->getResult($query, $parameters, $class, true);
        return $result;
    }
    
    public function getProductById(int $id)
    {
        $class = "Product";
        $query = "SELECT * FROM products WHERE products.id = :id";
        $parameters = array(":id" => $id);
        
        $result = $this->getResult($query, $parameters, $class, true);
        return $result;
    }
    
    public function getProductsByPriceAscending() : ?Product 
    {
        $class = "Product";
        $query = "SELECT * FROM products ORDER BY price ASC";
        $parameters = null;
        
        $results = $this->getResult($query, $parameters, $class, false);
        
        return $results;
        
    }
    
    public function create(Product $product) : ?Product
    {
        $query = "INSERT INTO products(name, price, description, quantity, category_id, media_id) VALUES (:name, :price, :description, :quantity, :category_id, :media_id)";
        $parameters = array("name" => $product->getName(), "price" => $product->getPrice(), "description" => $product->getDescription(), "quantity" => $product->getQuantity(), "category_id" => $product->getCategoryId(), "media_id" =>$product->getMediaId());
        
        $this->getQuery($query, $parameters);
        
        // Obtenez l'ID inséré
        $lastInsertId = $this->connex->lastInsertId();
        
        // A vérifier !!!
        $product->setId($lastInsertId);
        return $product;
    }
    
    public function delete(int $productId): void
    {
        $query = "DELETE FROM products WHERE id = :id";
        $parameters = array("id" => $productId);
        
        $this->getQuery($query, $parameters, true);
    }
    
    public function edit(Product $product) : void
    {
        $query ="UPDATE products SET name = :name, price = :price, description = :description, quantity = :quantity, category_id = :category_id, media_id = :media_id WHERE products.id = :id";
        $parameters = array("name" => $product->getName(), "price" => $product->getPrice(), "description" => $product->getDescription(), "quantity" => $product->getQuantity(), "category_id" => $product->getCategoryId(), "media_id" => $product->getMediaId(), "id" => $product->getId());
        
        $this->getQuery($query, $parameters);
    }
}