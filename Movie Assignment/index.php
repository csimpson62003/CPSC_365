<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix-Themed Login</title>
    <link rel="stylesheet" href="CSS/main.css">
</head>
<body>
    <div>
    <?php
        include "Model/MovieDatabaseConnection.php";
        $model = new MovieModel();

        if(isset($_COOKIE["email"])){
            header('location: landing.php');
            exit();
        }
        

        print("<div>");
        print("<h1>Login</h1>");
        
        print("<div class=\"form_container\">");
        
        // Login form
        print("<form action=\"index.php\" method=\"POST\">");
        print("<p>Username</p>");
        print("<input type=\"text\" name=\"email\" required placeholder=\"Enter your email\">");
        print("<input type=\"submit\" name=\"loginSubmit\" value=\"Login\">");
        print("</form>");

        // Create Account form
        print("<form action=\"create.php\" method=\"POST\">");
        print("<input type=\"submit\" name=\"createAccount\" value=\"Create Account\">");
        print("</form>");
        
        print("</div>"); // Close form_container
        print("</div>"); // Close main div

        // PHP for handling login attempt
        if (isset($_POST["loginSubmit"])) {
            $email = $_POST["email"];
            $userInfo = $model->getUser($email);
            if ($userInfo != null) {
                //Setting cookies
                setcookie("first_name", $userInfo["first_name"],0,"/");
                setcookie("last_name", $userInfo["last_name"],0,"/");
                setcookie("email", $userInfo["email"],0,"/");
                header(header: "Location: landing.php");
            } else {
                print("<p id=\"no_account_text\" style=\"color: #e50914; text-align: center; margin-top: 10px;\">No account found. Please try again or create a new account.</p>");
            }
        }
    ?>
    </div>
</body>
</html>
