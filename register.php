<?php

require("db.php");

if(file_exists("data.json"))
{
    $users = json_decode(file_get_contents("data.json"), true);
}

if($_REQUEST)
{
    if(isset($_POST["submit"]))
    {
        $user = new User();
        $user->name = $_POST["name"];
        $user->surname = $_POST["surname"];
        $user->email = $_POST["email"];

        $pass = $_POST["pass"];

        $user->pass = password_hash($pass, PASSWORD_DEFAULT);

        $user->store();

        $rand = rand(1000000000, 10000000000);
        $from = date("Y-m-d");
        $to = "2023-" . date("m-d");

        $users[$user->id] = [
            "member" => $rand,
            "from" => $from,
            "to" => $to
        ];

        $put = json_encode($users, JSON_PRETTY_PRINT);
        file_put_contents("data.json", $put);

        header("location: login.php");
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
            <div class="row align-items-center vh-100">
                <div class="col-12 col-md-6">
                    <div class="text-center">
                        <img src="images/account.svg" class="img-fluid" width="400">
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <form method="POST">
                                <div>
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Surname</label>
                                    <input type="text" class="form-control" name="surname" required>
                                </div>
                                <br>
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
                                    <a href="login.php" class="btn btn-link">Log in</a>
                                    <button type="submit" class="btn btn-dark" name="submit">Register</button>
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