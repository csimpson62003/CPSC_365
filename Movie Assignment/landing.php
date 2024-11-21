<!DOCTYPE html>
<html>
    <head>
        <title>Movies Review</title>
        <link rel="stylesheet" href="CSS/main.css">
        <script type="text/javascript" src="JS/logout.js"></script>

    </head>
    <body>
        <div>
            <h1>
                Movies Dot Com
            </h1>
        <div id="account_info_bar">
            <?php
            $fn = $_COOKIE["first_name"];
            $ln = $_COOKIE["last_name"];
            $ln = strtoupper($ln);
            $ln = str_split($ln)[0];
            print("<h3 id=\"nameText\"> Welcome back, ". $fn . " " . $ln . "</h3>");
        ?>
        <button onclick="logout()">Logout</button>
        </div>
        

        <div class="form_container">
        <div>
            <!-- As a user, I would like to browse for movies by category that I hope I will enjoy. Effort: 2 -->
             <form action="getMovieRecommendations.php" method="GET">
             <p>Pick Movies based on a category</p>

                <select name="category" required>
                    <option value="0">All</option>
                    <option value="1">Action</option>
                    <option value="2">Animation</option>
                    <option value="3">Children</option>
                    <option value="4">Classics</option>
                    <option value="5">Comedy</option>
                    <option value="6">Documentary</option>
                    <option value="7">Drama</option>
                    <option value="8">Family</option>
                    <option value="9">Foreign</option>
                    <option value="10">Games</option>
                    <option value="11">Horror</option>
                    <option value="12">Music</option>
                    <option value="13">New</option>
                    <option value="14">Sci-Fi</option>
                    <option value="15">Sports</option>
                    <option value="16">Travel</option>
                </select>
              <p>Pick Movies based on a rating</p>
    
                    <select name="rating">
                        <!-- enum('G','PG','PG-13','R','NC-17')  -->
                        <option value="ALL">ALL</option>
                        <option value="G">G</option>
                        <option value="PG">PG</option>
                        <option value="PG-13">PG-13</option>
                        <option value="R">R</option>
                        <option value="NC-17">NC-17</option>
                    </select>
                   
                 <p>Pick Movies based on a specific actor's last name</p>
                    <input type="text" name="actorName" maxlength="50">
                    <input type="submit" name="getMoviesSubmit">
                 </form>
        </div>
    </div>
          
    </body>
</html>