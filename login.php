<?php

require("db.php");

if($_REQUEST)
{
    if(isset($_POST["submit"]))
    {
        $user = new User();
        $user->email = $_POST["email"];
        $user->auth();

        $pass = $_POST["pass"];

        if(password_verify($pass, $user->pass))
        {
            $hr = time() + 200;

            setcookie("id", $user->id, $hr);

            header("location: index.php");
        }
        else
        {
            echo "<div class='alert alert-danger'>Incorrect email or password!</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club</title>
    <!---->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <!---->
    <section>
        <div class="container">
            <br>
            <div class="row">
                <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <form method="POST">
                                <div>
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="pass" required>
                                </div>
                                <br>
                                <div class="text-end">
                                    <a href="register.php" class="btn btn-link">Register</a>
                                    <button type="submit" class="btn btn-dark" name="submit">Log in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>