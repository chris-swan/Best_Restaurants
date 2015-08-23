<?php

    class Restaurant
    {
        private $name;
        private $phone_number;
        private $address;
        private $id;
        private $cuisine_id;

        function __construct($name, $phone_number, $address, $id, $cuisine_id)
        {
            $this->name = $name;
            $this->phone_number = $phone_number;
            $this->address = $address;
            $this->id = $id;
            $this->cuisine_id = $cuisine_id;
        }
        
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }
        
        function getName()
        {
            return $this->name;
        }
        
 		function setNumber($new_number)
        {
            $this->phone_number = (string) $new_number;
        }

        function getNumber()
        {
            return $this->phone_number;
        }
        
        function setAddress($address)
        {
            $this->address = (string) $new_address;
        }
        
        function getAddress(){
            return $this->address;
        }
        
        function getId()
        {
            return $this->id;
        }
        
        function getCuisineId()
        {
            return $this->cuisine_id;
        }
        
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants (name, phone_number, address, cuisine_id) VALUES ('{$this->getName()}', '{$this->getNumber()}', '{$this->getAddress()}', {$this->getCuisineId()})");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        
        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $phone_number = $restaurant['phone_number'];
                $address = $restaurant['address'];
                $id = $restaurant['id'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant($name, $phone_number, $address, $id, $cuisine_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }
        
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }
        
        static function find($search_id)
        {
            $found_restaurant = null;
            $restaurants = Restaurant::getAll();
            foreach($restaurants as $restaurant) {
                $restaurant_id = $restaurant->getId();
                if ($restaurant_id == $search_id) {
                    $found_restaurant = $restaurant;
                }
            }
            return $found_restaurant;
        }
        
        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }
        
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE id = {$this->getId()};");
        }
    }
 ?>
