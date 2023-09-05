<?php

class ProductController extends AbstractController{

    private CategoryManager $cm;
    private ProductManager $pm;
    private MediaManager $mm;
    
    public function __construct()
    {
        $this->cm = new CategoryManager();
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
                var_dump($editedMedia);

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
// 'success' => boolean true
//   'message' => string 'Produit supprimé avec succès.' (length=31)
//   'products' => 
//     array (size=6)
//       0 => 
//         object(Product)[32]
//           private ?int 'id' => int 32
//           private string 'name' => string 'Casquette de baseball' (length=21)
//           private ?float 'price' => float 14.99
//           private string 'description' => string 'Casquette classique pour un style d�contract�.' (length=46)
//           private int 'quantity' => int 200
//           private ?int 'category_id' => int 1
//           private ?int 'media_id' => int 1
//       1 => 
//         object(Product)[31]
//           private ?int 'id' => int 53
//           private string 'name' => string 'Chemise �l�gante' (length=16)
//           private ?float 'price' => float 39.99
//           private string 'description' => string 'Chemise formelle pour des occasions sp�ciales.' (length=46)
//           private int 'quantity' => int 50
//           private ?int 'category_id' => int 1
//           private ?int 'media_id' => int 1
//       2 => 
//         object(Product)[38]
//           private ?int 'id' => int 54
//           private string 'name' => string 'Chaussures de sport l�g�res' (length=27)
//           private ?float 'price' => float 59.99
//           private string 'description' => string 'Chaussures confortables pour le sport et les loisirs.' (length=53)
//           private int 'quantity' => int 80
//           private ?int 'category_id' => int 1
//           private ?int 'media_id' => int 2
//       3 => 
//         object(Product)[39]
//           private ?int 'id' => int 55
//           private string 'name' => string 'Robe de soir�e' (length=14)
//           private ?float 'price' => float 79.95
//           private string 'description' => string 'Robe �l�gante pour les soir�es et les �v�nements.' (length=49)
//           private int 'quantity' => int 30
//           private ?int 'category_id' => int 2
//           private ?int 'media_id' => int 1
//       4 => 
//         object(Product)[40]
//           private ?int 'id' => int 57
//           private string 'name' => string 'Montre classique' (length=16)
//           private ?float 'price' => float 129.99
//           private string 'description' => string 'Montre intemporelle pour un style sophistiqu�.' (length=46)
//           private int 'quantity' => int 40
//           private ?int 'category_id' => int 1
//           private ?int 'media_id' => int 1
//       5 => 
//         object(Product)[41]
//           private ?int 'id' => int 58
//           private string 'name' => string 'Chemise �l�gante' (length=16)
//           private ?float 'price' => float 39.99
//           private string 'description' => string 'Chemise formelle pour des occasions sp�ciales.' (length=46)
//           private int 'quantity' => int 50
//           private ?int 'category_id' => int 1
//           private ?int 'media_id' => int 1