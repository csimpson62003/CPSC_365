<!DOCTYPE html>
<html>
    <head>
        <title>MovieDotCom</title>
        <link rel="stylesheet" type="text/css" href="CSS/searched.css">
    </head>
    <body>
    <a href="index.html" style="text-decoration:none;">
    <div class="header">
        <h1>Movies Dot Com</h1>
    </div>
    </a>

    <div class="content">
    <?php

    $server = "localhost";
    $user = "root";
    $password = "root";
    $db = "sakila";
    try{
        $conn = new PDO("mysql:host=$server;dbname=$db", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if(isset($_GET['getMovieCategoriesSubmit'])){

            $category = strip_tags($_GET['category']);
            $select = "select title, description, film.rating, film_category.category_id, film.film_id from film, film_category where film_category.film_id = film.film_id and film_category.category_id = :categoryID;";

            $query = $conn->prepare($select);
            $query->bindParam(":categoryID", $category, PDO::PARAM_INT);
            $query->execute();

            $result = $query->setFetchMode(PDO::FETCH_ASSOC);
            while($row  = $query->fetch()){
                print("<div class='movie'>");
                print("<h3 class='movie-title'>" . $row['title'] . " <span class='rating-label'>(" .$row['rating'] . ")</span></h3>");
                print("<p class='movie-description'>" . $row['description'] . "</p>");

                $film_id = strip_tags($row['film_id']);
                $AllActors = "select first_name, last_name from actor, film_actor, film where actor.actor_id = film_actor.actor_id and film_actor.film_id = film.film_id and film.film_id = :filmID;";
                $actorQuery = $conn->prepare($AllActors);
                $actorQuery->bindParam(":filmID", $film_id, PDO::PARAM_INT);
                $actorQuery->execute();

                print("<ul class='actors-list'>");
                while($actor = $actorQuery->fetch()){
                    print("<li class='actor-name'>" . $actor["first_name"] . " " . $actor["last_name"] . "</li>");
                }
                $actorQuery = null;
                print("</ul>");

                print("</div>");
            }
        } else if (isset($_GET['getMovieRatingSubmit'])) {

            $category = strip_tags($_GET['category']);
            $rating = strip_tags($_GET['rating']);
            $select = "select title, description, film.film_id, film.rating, film_category.category_id from film, film_category where film_category.film_id = film.film_id and film_category.category_id = :categoryID and rating = :ratingEnum;";

            $query = $conn->prepare($select);
            $query->bindParam(":categoryID", $category, PDO::PARAM_INT);
            $query->bindParam(":ratingEnum", $rating, PDO::PARAM_STR);
            $query->execute();

            $result = $query->setFetchMode(PDO::FETCH_ASSOC);
            while($row  = $query->fetch()){
                print("<div class='movie'>");
                print("<h3 class='movie-title'>" . $row['title'] . " <span class='rating-label'>(" .$row['rating'] . ")</span></h3>");
                print("<p class='movie-description'>" . $row['description'] . "</p>");

                $film_id = strip_tags($row['film_id']);
                $AllActors = "select first_name, last_name from actor, film_actor, film where actor.actor_id = film_actor.actor_id and film_actor.film_id = film.film_id and film.film_id = :filmID;";
                $actorQuery = $conn->prepare($AllActors);
                $actorQuery->bindParam(":filmID", $film_id, PDO::PARAM_INT);
                $actorQuery->execute();

                print("<ul class='actors-list'>");
                while($actor = $actorQuery->fetch()){
                    print("<li class='actor-name'>" . $actor["first_name"] . " " . $actor["last_name"] . "</li>");
                }
                $actorQuery = null;
                print("</ul>");

                print("</div>");
            }
        } else if (isset($_GET['getMovieActorSubmit'])) {

            $actor = "%" . strip_tags($_GET['actorName']) . "%";
            $select = "select title, description, film.film_id, film.rating from film, actor, film_actor where film_actor.actor_id = actor.actor_id and film_actor.film_id = film.film_id and actor.last_name LIKE :actorLastName; ";

            $query = $conn->prepare($select);
            $query->bindParam(":actorLastName", $actor, PDO::PARAM_STR);
            $query->execute();

            $result = $query->setFetchMode(PDO::FETCH_ASSOC);
            while($row  = $query->fetch()){

                print("<div class='movie'>");
                print("<h3 class='movie-title'>" . $row['title'] . " <span class='rating-label'>(" .$row['rating'] . ")</span></h3>");
                print("<p class='movie-description'>" . $row['description'] . "</p>");

                $film_id = strip_tags($row['film_id']);
                $AllActors = "select first_name, last_name from actor, film_actor, film where actor.actor_id = film_actor.actor_id and film_actor.film_id = film.film_id and film.film_id = :filmID;";
                $actorQuery = $conn->prepare($AllActors);
                $actorQuery->bindParam(":filmID", $film_id, PDO::PARAM_INT);
                $actorQuery->execute();

                print("<ul class='actors-list'>");
                while($actor = $actorQuery->fetch()){
                    print("<li class='actor-name'>" . $actor["first_name"] . " " . $actor["last_name"] . "</li>");
                }
                $actorQuery = null;
                print("</ul>");

                print("</div>");
            }
        }

        $conn = null; // Disconnects the connection
    } catch(PDOException $e) {
        print("<div class='error'>Failed to connect: " . $e->getMessage() . "</div>");
    }

    ?>
    </div>

    </body>
</html>