<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    
    require_once "src/Cuisine.php";
    // require_once "src/Restaurant.php";
    
    $server = 'mysql:host=localhost;dbname=best_eats_test';
    $username = 'root';
    $password = 'root';
    
    $DB = new PDO($server, $username, $password);
    
    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }
        function test_getFlavor()
        {
            //Arrange
            $flavor = "Pizza";
            $test_Cuisine = new Cuisine($flavor);
            
            //Act
            $result = $test_Cuisine->getFlavor();
            
            //Assert
            $this->assertEquals($flavor, $result);
        }
        function test_getId()
        {
            //Arrange
            $flavor = "Pizza";
            $id = 1;
            $test_Cuisine = new Cuisine($flavor, $id);
            
            //Act
            $result = $test_Cuisine->getId();
            
            //Assert
            $this->assertEquals(true, is_numeric($result));
        }
        function test_save()
        {
            //Arrange
            $flavor = "Pizza";
            $test_Cuisine = new Cuisine($flavor);
            $test_Cuisine->save();
            
            //Act
            $result = Cuisine::getAll();
            
            //Assert
            $this->assertEquals($test_Cuisine, $result[0]);
        }
        function test_getAll()
        {
            //Arrange
            $flavor = "Pizza";
            $flavor2 = "Burgers";
            $test_Cuisine = new Cuisine($flavor);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($flavor2);
            $test_Cuisine2->save();
            
            //Act
            $result = Cuisine::getAll();
            
            //Assert
            $this->assertEquals([$test_Cuisine, $test_Cuisine2], $result);
        }
        function test_deleteAll()
        {
            //Arrange
            $flavor = "Pizza";
            $flavor2 = "Burgers";
            $test_Cuisine = new Cuisine($flavor);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($flavor2);
            $test_Cuisine2->save();
            
            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();
            
            //Assert
            $this->assertEquals([], $result);
        }
        function test_find()
        {
            //Arrange
            $name = "Pizza";
            $name2 = "Burgers";
            $test_Cuisine = new Cuisine($name);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($name2);
            $test_Cuisine2->save();
           
            //Act
            $result = Cuisine::find($test_Cuisine->getId());
           
            //Assert
            $this->assertEquals($test_Cuisine, $result);
        }
        function test_getRestaurants()
        {
            //Arrange
           $flavor = "Pizza";
           $id = null;
           $test_cuisine = new Cuisine($flavor, $id);
           $test_cuisine->save();
           $test_cuisine_id = $test_cuisine->getId();
           $name = "Burger Bash";
           $phone_number = "555-666-7777";
           $address = "8020 Ground Chuck";
           $test_restaurant = new Restaurant($name, $phone_number, $address, $id, $test_cuisine_id);
           $test_restaurant->save();
           $name2 = "Pizza Party";
           $phone_number2 = "555-666-7747";
           $address2 = "1234 Pepperoni Lane";
           $test_restaurant2 = new Restaurant($name2, $phone_number2, $address2, $id, $test_cuisine_id);
           $test_restaurant2->save();
           
           //Act
           $result = $test_cuisine->getRestaurants();
           
           //Assert
           $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }
        function testUpdate()
        {
            //Arrange
            $flavor = "Pizza";
            $id = null;
            $test_cuisine = new Cuisine($flavor, $id);
            $test_cuisine->save();
            $new_flavor = "Burgers";
            //Act
            
            $test_cuisine->update($new_flavor);
            //Assert
            
            $this->assertEquals("Burgers", $test_cuisine->getFlavor());
        }
        function testDelete()
        {
            
            //Arrange
            $flavor = "Pizza";
            $id = null;
            $test_cuisine = new Cuisine($flavor, $id);
            $test_cuisine->save();
            $flavor2 = "Burgers";
            $test_cuisine2 = new Cuisine($flavor2, $id);
            $test_cuisine2->save();
            
            //Act
            $test_cuisine->delete();
            
            //Assert
            $this->assertEquals([$test_cuisine2], Cuisine::getAll());
        }
        function testDeleteCuisineRestaurants()
        {
            //Arrange
            $flavor = "Pizza";
            $id = null;
            $test_cuisine = new Cuisine($flavor, $id);
            $test_cuisine->save();
            $name = "Pizza Party";
            $phone_number = "123-123-1234";
            $address = "1234 Pepporoni Lane";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $phone_number, $address, $id, $cuisine_id);
            $test_restaurant->save();
            
            //Act
            $test_cuisine->delete();
            
            //Assert
            $this->assertEquals([], Restaurant::getAll());
        }
    }
 ?>