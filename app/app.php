<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

    $app = new Silex\Application();
    
    $server = 'mysql:host=localhost;dbname=best_eats';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    
    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
       ));
    
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });
    
    $app->post("/cuisines", function() use ($app) {
       $cuisine = new Cuisine($_POST['flavor']);
       $cuisine->save();
       return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });
    
    $app->post("/delete_cuisines", function() use ($app) {
        Cuisine::deleteAll();
        $cuisines = [];
        return $app['twig']->render('index.html.twig', array('cuisines' => $cuisines));
    });
    
    $app->get("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('restaurants.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });
    
    $app->get("/restaurants/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        return $app['twig']->render('place.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });
    
    $app->post("/restaurants", function() use ($app) {
        $name = $_POST['name'];
        $phone_number = "placeholder";
        $address = "placeholder";
        $cuisine_id = $_POST['cuisine_id'];
        $restaurant = new Restaurant($name, $phone_number, $address, $id = null, $cuisine_id);
        $restaurant->save();
    return $app['twig']->render('restaurants.html.twig', array('cuisine' => Cuisine::find($cuisine_id), 'restaurants' => Restaurant::getAll()));
	});

	$app->post("/delete_restaurants", function() use ($app) {
		Restaurant::deleteAll();
     	$restaurants = [];
     	return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
 	});
    
    return $app;
    
 ?>