<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="CSS/main.css">
</head>
<body>
<div>

<a href="index.php" style="text-decoration:none;">
   
        <h1 class="header">Movies Dot Com</h1>
    </a>
    <?php
        include "Model/MovieDatabaseConnection.php";
        $model = new MovieModel();

        
        print("<div class=\"form_container\">");
        
        // Login form
        print("<form action=\"create.php\" method=\"POST\">");
        print("<p>First Name</p>");
        print("<input type=\"text\" name=\"first_name\" required>");
        print("<p>Last Name</p>");
        print("<input type=\"text\" name=\"last_name\" required>");
        print("<p>Email</p>");
        print("<input type=\"text\" name=\"email\" required>");
        print("<p>Store Address</p>");
        print("<select name=\"store_address\" required>");
        $store_adrs = $model->getStoreAddresses();
        for( $i = 0; $i < count($store_adrs); $i++ ){
            print("<option>". $store_adrs[$i]["address"] ." ". $store_adrs[$i]["city"]."</option>");
        }
        print("</select>");
        print("<input type=\"submit\" name=\"create_account\" value=\"Create Account\">");
        print("</form>");

        print("</div>"); 


        if(isset($_POST["create_account"])){
            if(!$model->getUser($_POST["email"])){
            $model->createUser($_POST["first_name"],$_POST["last_name"],$_POST["email"],$_POST["store_address"]);
            header("Location: index.php");

            }else{
                print("USER ALREADY IN SYSTEM");
            }
        }
    ?>
    </div>
</body>
</html>
