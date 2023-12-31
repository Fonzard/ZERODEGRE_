<?php
class PostController extends AbstractController
{
    private CategoryManager $cm;
    private PostManager $pm;
    private MediaManager $mm;
    private MediaController $mc;
    
    public function __construct ()
    {
        $this->cm = new CategoryManager();
        $this->pm = new PostManager();
        $this->mm = new MediaManager();
        $this->mc = new MediaController();
    }
    
    public function editPost() {
        if (isset($_POST["post-edit-form"]) && $_POST["post-edit-form"] === "submit") {
            // Récupérer les données du formulaire
            $postId = $_POST['post_id'];
            $title = $_POST['post_title'];
            $content = $_POST['post_content'];
            $date = $_POST['post_date'];
            $author = $_POST['post_author'];
            $categoryId = $_POST['post_category'];
            $url = $_POST['post-url'];
            $altText = $_POST['post-altText'];

            // Valider et mettre à jour le post
            $post = $this->pm->getPostById($postId);

            if (isset($_POST['postMediaId'])) 
            {
                $mediaId = $_POST['postMediaId'];
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
            // Mettre à jour les propriétés du post
            $post->setTitle($title);
            $post->setContent($content);
            $post->setDate($date);
            $post->setAuthor($author);
            $post->setCategoryId($categoryId);
            $post->setMediaId($editedMedia->getId());
            var_dump($post);
            // Mettre à jour le post dans la base de données
            $this->pm->updatePost($post);

            $_SESSION['message'] = "L'article' ". $title ." a bien été modifié";
            // Rediriger vers la liste des posts ou une autre page
            header('Location: /ZERODEGRE_/admin/post');
            
        } else {
            // Afficher le formulaire d'édition
            $postId = $_GET['id'];
            $post = $this->pm->getPostById($postId);
            $categories = $this->cm->getAllCategoriesPost();
            $mediaId = $post->getMediaId();
            $media = $this->mm->getMediaById($mediaId);
            $this->render('admin/post/edit', ['post' => $post, "media" => $media, 'categories' => $categories]);
        }
    }

    public function createPost() {
        if (isset($_POST["post-form"]) && $_POST["post-form"] === "submit") {
            // Récupérer les données du formulaire
            $title = $this->clean($_POST['post-title']);
            $content = $this->clean($_POST['post-content']);
            $date = $_POST['post-date'];
            $author = $this->clean($_POST['post-author']);
            $categoryId = $_POST['post-categoryId'];
            $url = $this->clean($_POST['post-url']);
            $altText = $this->clean($_POST['post-altText']);
            //Instancier un média 
            $media = new Media($url, $altText);
            $this->mm->insertMedia($media);
            $mediaId = $media->getId();
            // Créer un nouvel objet Post
            $post = new Post($title, $content, $date, $author, $categoryId, $mediaId);
            // Ajouter le post à la base de données
            $this->pm->createPost($post);

            $_SESSION['message'] = "L'article ". $title ." a bien été créé avec succés". $date;
            // Rediriger vers la liste des posts ou une autre page
            header('Location: /ZERODEGRE_/admin/post');
        } else {
            // Afficher le formulaire de création
            $categories = $this->cm->getAllCategoriesPost();
            $this->render('admin/post/create', ['categories' => $categories]);
        }
    }
    public function deletePost() 
    {
        if (isset($_GET['id'])) 
        {
            $postId = $_GET['id'];
            $this->pm->deletePost($postId);
            $_SESSION["message"] = "L'article a été supprimé avec succès.";
            header('Location: /ZERODEGRE_/admin/post');
        } else {
            $_SESSION["message"] = "L'article n'a  pas été supprimé.";
            header('Location: /ZERODEGRE_/admin/post');
        }
    }

    public function postIndex()
    {
        $categories = $this->cm->getAllCategoriesPost();
        $posts = $this->pm->getAllPost();
        if (empty($posts)) {
        
            $_SESSION['message'] = "Aucun article n'a été trouvé en base de données.";
            header("location: /ZERODEGRE_/post");
            return;
        }

        $categoriesNames = [];
        $postsWithMedias = [];

        foreach ($posts as $post) {
            $categoryId = $post->getCategoryId();
            $categoryName = $this->cm->getCategoriesPostName($categoryId);
            $categoriesNames[] = $categoryName;
        
            $postWithMedias = $this->mc->getPostWithMedia($post->getId());

            if ($postWithMedias === null) {
                // Aucune média associée à cet article, gérer l'erreur ici
                $_SESSION['message'] = "Aucun média n'est associé à cet article en base de données.";
                header("location: /ZERODEGRE_/post");
                return;
            } else {
                $postsWithMedias[] = $postWithMedias;
            }
        }
        $this->render("post/index", ["posts" => $posts, "categoriesNames" => $categoriesNames, "postsWithMedias" => $postsWithMedias, "categories" => $categories]);
    }

    public function show($postId)
    {
        $post = $this->mc->getPostWithMedia($postId);
        $categoryId = $post->getCategoryId();
        $categoryName = $this->cm->getCategoriesPostName($categoryId);
        $this->render("post/show", ["post" => $post, "categoryName" => $categoryName]);
    }
}

?>