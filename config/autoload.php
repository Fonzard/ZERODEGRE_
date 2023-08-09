<?php

require "./models/Album.php";
require "./models/Artist.php";
require "./models/Category.php";
require "./models/Media.php";
require "./models/Post.php";
require "./models/Product.php";
require "./models/Song.php";
require "./models/User.php";

require "./manager/AbstractManager.php";
require "./manager/AlbumManager.php";
require "./manager/ArtistManager.php";
require "./manager/CategoryManager.php";
require "./manager/MediaManager.php";
require "./manager/PostManager.php";
require "./manager/ProductManager.php";
require "./manager/UserManager.php";
require "./manager/SongManager.php";

require "./controller/AbstractController.php";
require "./controller/AdminController.php";
require "./controller/AlbumController.php";
require "./controller/ArtistController.php";
require "./controller/AuthController.php";
require "./controller/CategoryController.php";
require "./controller/HomeController.php";
require "./controller/MediaController.php";
require "./controller/PostController.php";
require "./controller/ProductController.php";
require "./controller/SongController.php";

require "./service/Router.php";

?>