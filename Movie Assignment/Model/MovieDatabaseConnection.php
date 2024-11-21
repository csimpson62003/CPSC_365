<?php

class MovieModel{

private $server = "localhost";
private $user = "m0v1eSD0tC0m";
private $password = "MoV13S4L1FeE";
private $db = "sakila";
public $conn = null;
public function __construct(){
try{
    $this->conn = new PDO("mysql:host=$this->server;dbname=$this->db", $this->user, $this->password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(e){
    echo "Cant connect to database";
}
}
public function getConnection(){
    return $this->conn;
}
public function closeConnection(){
    $this->conn = null;
}


public function getMovies($category = null, $rating = null, $actor = null) {
    // Base SQL query
    $select = "SELECT title, description, film.film_id, film.rating 
               FROM film, film_category, actor, film_actor 
               WHERE film_category.film_id = film.film_id 
               AND film_actor.film_id = film.film_id 
               AND film_actor.actor_id = actor.actor_id";

    // Add conditions based on parameters
    if ($category !== null) {
        $select .= " AND film_category.category_id = :categoryID";
    }

    if ($rating !== null) {
        $select .= " AND film.rating = :ratingEnum";
    }

    if ($actor !== null) {
        $select .= " AND actor.last_name LIKE :actorLastName";
    }
    $select .= " limit 200;";

    $query = $this->conn->prepare($select);

    // Bind parameters
    if ($category !== null) {
        $query->bindParam(":categoryID", $category, PDO::PARAM_INT);
    }
    if ($rating !== null) {
        $query->bindParam(":ratingEnum", $rating, PDO::PARAM_STR);
    }
    if ($actor !== null) {
        $actor = '%' . $actor . '%'; // Add wildcard for LIKE
        $query->bindParam(":actorLastName", $actor, PDO::PARAM_STR);
    }

    $query->execute();
    return $query->fetchAll();
}


public function getCategoryFromId($id){
    if($id==0){
        return "All";
    }
    try{
    $select = "select name from category where category_id = :id";
    $query = $this->conn->prepare($select);
    $query->bindParam(":id", $id, PDO::PARAM_STR);
    $query->execute();

    $result = $query->setFetchMode(PDO::FETCH_ASSOC);
    return ($query->fetch())['name'];
    }catch(PDOException $e){
        return $e->getMessage();
    }
}public function getActors($film_id){

    $AllActors = "select first_name, last_name from actor, film_actor, film where actor.actor_id = film_actor.actor_id and film_actor.film_id = film.film_id and film.film_id = :filmID;";
    $actorQuery = $this->conn->prepare($AllActors);
    $actorQuery->bindParam(":filmID", $film_id, PDO::PARAM_INT);
    $actorQuery->execute();
    return $actorQuery->fetchAll();
}

public function isValidUser($email): mixed{
    $user = "select first_name, last_name, email from customer where email = :email;";
    $query = $this->conn->prepare(query: $user);
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->execute();
    $query = $query->fetchAll();

    if(count($query)==0){
        return null;
    }
    return $query[0];
}
public function getUser($email): mixed {
    try{
        //First we add the address to the database.
        $selector = "select email, first_name, last_name from customer where email = :email;";
        $query = $this->conn->prepare($selector);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        $query = $query->fetchAll();
        if(count($query)== 0){
            return false;
        }
        return $query[0];
    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
    
}


public function createUser($first_name,$last_name,$email,$address){
    try{
    //First we add the address to the database.
    $store_id = " select store_id from store, address where address.address_id = store.address_id and address.address = :address;";
    $store = $this->conn->prepare($store_id);
    $store->bindParam(":address", $address, PDO::PARAM_INT);
    $store->execute();
    $store = $store->fetch();
    $store_id = $store["store_id"];



// Get the current datetime
    $currentDateTime = date('Y-m-d H:i:s');

    $newUser = "INSERT INTO customer (store_id, first_name, last_name, email, address_id, active, create_date) VALUES (:store_id, :first, :last, :email, 5, 1, :dateTime);";
    $query = $this->conn->prepare($newUser);
    $query->bindParam(":store_id", $store_id, PDO::PARAM_INT);
    $query->bindParam(":first", $first_name, PDO::PARAM_STR);
    $query->bindParam(":last", $last_name, PDO::PARAM_STR);
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->bindParam(":dateTime", $currentDateTime, PDO::PARAM_STR);

    $query->execute();
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
public function getCountries(){
    $country = "select country from country;";
    $query = $this->conn->prepare(query: $country);
    $query->execute();
    return $query->fetchAll();
}

public function getStoreAddresses(){
    $country = "select address, city from address, store, city where address.address_id = store.address_id and address.city_id = city.city_id;";
    $query = $this->conn->prepare(query: $country);
    $query->execute();
    return $query->fetchAll();
}


}
?>