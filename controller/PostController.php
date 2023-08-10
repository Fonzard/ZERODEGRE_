<?php
class PostController extends Controller
{
    public function show($params)
    {
        // Récupérer l'identifiant du produit depuis les paramètres de la route
        $postId = $params['id'];
        
        // Récupérer les détails du produit à partir de la base de données (ou autre source)
        $post = $this->postManager->getPostById($postId);
        
        // Afficher la vue des détails du produit avec les données
        $this->render('post/show', ['post' => $post]);
    }
}

?>