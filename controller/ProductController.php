<?php

class ProductController extends AbstractController{

    private CategoryManager $cm;
    private ProductManager $pm;
    private MediaManager $mm;
    private MediaController $mc;
    
    public function __construct()
    {
        $this->cm = new CategoryManager();
        $this->pm = new ProductManager();
        $this->mm = new MediaManager();
        $this->mc =new MediaController();
    }
    
    public function productIndex()
    {
        $categories = $this->cm->getAllCategoriesProducts();
        $products = $this->pm->getAllProducts();
        
        if (empty($products)) {
            $_SESSION['message'] = "Aucun produit n'a été trouvé en base de données.";
            header("location: /ZERODEGRE_/product");
            return;
        }
    
        // Crée un tableau pour regrouper les produits par catégorie
        $productsByCategory = [];
    
        foreach ($products as $product) {
            $categoryId = $product->getCategoryId();
            $categoryName = $this->cm->getCategoriesProductsName($categoryId);
            
            // Extraction de la valeur 'name' du tableau associatif
            $categoryName = $categoryName['name'];

            if (!isset($productsByCategory[$categoryName])) {
                $productsByCategory[$categoryName] = [];
            }
    
            $productWithMedias = $this->mc->getProductWithMedia($product->getId());
    
            if ($productWithMedias === null) {
                // Aucune média associée à cet article, gérer l'erreur ici
                $_SESSION['message'] = "Aucun média n'est associé à ce produit en base de données.";
                header("location: /ZERODEGRE_/product");
                return;
            } else {
                $productsByCategory[$categoryName][] = $productWithMedias;
            }
        }
    
        $this->render("product/index", [
            "productsByCategory" => $productsByCategory,
            "categories" => $categories
        ]);
    }
    
    public function show($productId)
    {
        $product = $this->mc->getProductWithMedia($productId);
        $categoryId = $product->getCategoryId();
        $categoryName = $this->cm->getCategoriesProductsName($categoryId);
        $this->render("product/show", ["product" => $product, "categoryName" => $categoryName]);
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
        } else {
            $categories = $this->cm->getAllCategoriesProducts();
            $this->render("admin/product/create", ["categories" => $categories]); 
        }
    }
    
    public function editProduct($productId) : void
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

            if (isset($_POST['productMediaId'])) 
            {
                $mediaId = $_POST['productMediaId'];
                $media = $this->mm->getMediaById($mediaId);
      
                $media->setUrl($url);
                $media->setAltText($altText);
                $this->mm->editMedia($media);
                $editedMedia = $this->mm->getMediaById($media->getId());

            } else {
                $media = new Media($url, $altText);
                $this->mm->insertMedia($media);
                $mediaId = $media->getid();
                $editedMedia = $this->mm->getMediaById($mediaId);
            }
            
            $product->setName($name);
            $product->setPrice($price);
            $product->setDescription($description);
            $product->setQuantity($quantity);
            $product->setCategoryId($categotyId);
            $product->setMediaId($editedMedia->getId());
            
            $this->pm->edit($product);

            $_SESSION['message'] = "Le produit ". $name ." a bien été modifié";
            header("Location: /ZERODEGRE_/admin/product");
        } else {
            $product = $this->pm->getProductById($productId);
            $mediaId = $product->getMediaId();
            $media = $this->mm->getMediaById($mediaId);
            $categories = $this->cm->getAllCategoriesProducts();
            
            $this->render("admin/product/edit", ["product" => $product, "media" => $media, "categories" => $categories]);
        }
    }
    
    public function deleteProduct()
    {
        if(isset($_GET['id']))
        {
            $productId = $_GET['id'];
            $this->pm->delete($productId);
            $newProductList = $this->pm->getAllProducts();
            // Ne marche pas, Prendre le temps de trouver la soluce !!!!!!!!
                if (empty($newProductList)) {
                    echo json_encode(array("success" => false, "message" => "Aucun produit disponible."));
                } else {
                    $responseData = array('success' => true, 'message' => 'Produit supprimé avec succès.', 'products' => $newProductList);
                    echo json_encode($responseData);
                }
        } else {
            echo json_encode(array("success" => false, "message" => "Le produit n'a pas été supprimé."));
        }
    }
}
