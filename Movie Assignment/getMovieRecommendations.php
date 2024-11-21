<!DOCTYPE html>
<html>
    <head>
        <title>MovieDotCom</title>
        <link rel="stylesheet" type="text/css" href="CSS/searched.css">
    </head>
    <body>
    <a href="landing.php" style="text-decoration:none;">
    <div class="header">
        <h1>Movies Dot Com</h1>
    </div>
    </a>

    <div class="content">
    <?php
    include 'Model/MovieDatabaseConnection.php';

    $model = new MovieModel();
    $conn = $model->getConnection();

    $movies = null;


    if(isset($_GET['getMoviesSubmit'])){
        $category = $_GET["category"];
        $rating = $_GET["rating"];
        $actor_last = strip_tags($_GET["actorName"]);
        $searchHeading = null;
        if($category == 0){
            $category = null;
        }else{
            $searchHeading = "Category: ".$model->getCategoryFromId(strip_tags($_GET['category']));

        }
        if($rating == "ALL"){
            $rating = null;
        }else{
            if($searchHeading != null){
                $searchHeading .=", ";
            }
            $searchHeading.= "Rating: ".$rating; 
        }
        if($actor_last == "" || $actor_last == null){
            $actor_last = null;
        }else{
            if($searchHeading != null){
                $searchHeading .=", ";
            }
            $searchHeading.= "Last Name: ".$actor_last; 
        }

        if($searchHeading){
            print("<h2>".$searchHeading."</h2>");
        }else{
            print("<h2>Showing 200 movies. To see more specific movies, redifine your search!</h2>");
        }

        $movies = $model->getMovies($category, $rating, $actor_last);
        if(count($movies) == 0){
            print("<h2>No movies found, redefine your search");
        }
    }

        for($i=0; $i<count($movies); $i++){
            print("<div class='movie'>");
            print("<h3 class='movie-title'>" . ($movies[$i])['title'] . " <span class='rating-label'>(" .($movies[$i])['rating'] . ")</span></h3>");
            print("<p class='movie-description'>" . ($movies[$i])['description'] . "</p>");
            $actor = $model->getActors(strip_tags(($movies[$i])['film_id']));
            print("<ul class='actors-list'>");
            for($j=0; $j<count($actor); $j++){
                print("<li class='actor-name'>" . ($actor[$j])["first_name"] . " " . ($actor[$j])["last_name"] . "</li>");
            }
            print("</ul>");

            print("</div>");
        }
        

        $model->closeConnection();
    ?>
    </div>

    </body>
</html>