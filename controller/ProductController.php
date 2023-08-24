<?php

class ProductController extends AbstractController{

    private ProductManager $pm;
    private MediaManager $mm;
    
    public function __construct()
    {
        $this->pm = new ProductManager();
        $this->mm = new MediaManager();
    }
 
    public function createProduct() : void 
    {
        if (isset($_POST["product-form"]) && $_POST["product-form"] === "submit") 
        {
            $name = $this->clean($_POST["product-name"]);
            $price = $this->clean($_POST["product-price"]);
            $description = $this->clean($_POST["product-description"]);
            $quantity = $this->clean($_POST["product-quantity"]);
            $categoryId = $_POST["product-categoryId"];
            $url = $this->clean($_POST["product-url"]);
            $altText = $this->clean($_POST["product-altText"]);
            
            //Instancier un média 
            $media = new Media($url, $altText);
            $this->mm->insertMedia($media);
            $mediaId = $media->getId();
            
            $product = new Product ($name, $price, $description, $quantity, $categoryId, $mediaId);
            $this->pm->create($product);
            
            //Peut être changer la route 
            header("location: /ZERODEGRE_/admin/product");
            $_SESSION['message'] = "Le produit". $name ." a bien été créé";
        } 
    }
    
    public function editProduct() : void
    {
        
        if (isset($_POST["product-edit-form"]) && $_POST["product-edit-form"] === "submit") 
        {
            $name = $this->clean($_POST["product-name"]);
            $price = $this->clean($_POST["product-price"]);
            $description = $this->clean($_POST["product-description"]);
            $quantity = $this->clean($_POST["product-quantity"]);
            $categotyId = $this->clean($_POST["product-categoryId"]);
            $url = $this->clean($_POST["product-url"]);
            $altText = $this->clean($_POST["product-altText"]);
            
            $product = $this->pm->getProductById($_GET["id"]);
            
            //Editer un média 
            //A faire
            $mediaId = $this->mm->getMediaIdByUrl($url);
            
            $product->setName($name);
            $product->setPrice($price);
            $product->setDescription($description);
            $product->setQuantity($quantity);
            $product->setCategoryId($categotyId);
            $product->setMediaId($mediaId);
            
            
            
            $this->pm->edit($product);
            
           
            $_SESSION['message'] = "Le produit ". $name ." a bien été modifié";
            header("Location: /ZERODEGRE_/admin/product");
                
        } 
    }
    
    public function deleteProduct()
    {
        if(isset($_GET['id']))
        {
                $productId = $_GET['id'];
                $this->pm->delete($productId);
                $newProductList = $this->pm->getAllProducts();
                echo json_encode($newProductList);
        } else {
                echo json_encode(array("errors" => "Le produit n'a pas été supprimé"));
        }
    }
    
    
    
}