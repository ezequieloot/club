<?php

session_start();

require("db.php");

if(!isset($_COOKIE["id"]))
{
    header("location: login.php");
}

if(file_exists("data.json"))
{
    $partner = json_decode(file_get_contents("data.json"), true);
}

$userCookie = new User();

$userCookie->id = $_COOKIE["id"];
$userCookie->edit();

$_SESSION["id"] = $_COOKIE["id"];
$_SESSION["name"] = $userCookie->name;
$_SESSION["surname"] = $userCookie->surname;
$_SESSION["email"] = $userCookie->email;
$_SESSION["pass"] = $userCookie->pass;

if(isset($_GET["exit"]))
{
    session_destroy();
    setcookie("id", "", time() - 200);
    header("location: login.php");
}

if($_REQUEST)
{
    if(isset($_POST["submit"]))
    {
        $user = new User();
        $user->id = $_SESSION["id"];
        $user->name = $_POST["name"];
        $user->surname = $_POST["surname"];
        $user->email = $_POST["email"];

        if($_POST["pass"] == "")
        {
            $pass = $_SESSION["pass"];
        }
        else
        {
            $pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
        }
        $user->pass = $pass;
        $user->update();
        header("location: index.php");
    }
    if(isset($_GET["destroy"]) && isset($_GET["id"]))
    {
        $user = new User();
        $user->id = $_GET["id"];
        $user->destroy();
        unset($partner[$_GET["id"]]);
        file_put_contents("data.json", json_encode($partner, JSON_PRETTY_PRINT));
        session_destroy();
        setcookie("id", "", time() - 200);
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
        <div class="container" id="home">
            <br>
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h1 class="display-1">Club</h1>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <nav class="navbar sticky-top navbar-expand-lg bg-dark">
            <div class="container">
                <a href="#home" class="btn btn-dark">Home</a>
                <a href="#member" class="btn btn-dark">Member</a>
                <a href="#profile" class="btn btn-dark">Profile</a>
                <a href="index.php?exit" class="btn btn-danger">Exit</a>
            </div>
        </nav>
        <div class="container" id="member">
            <br>
            <div class="row mb-5">
                <div class="col-12">
                    <h4 class="display-4">Hi <em><?php echo ucfirst($_SESSION["name"]) . " " . ucfirst($_SESSION["surname"]); ?></em></h4>
                    <p>Welcome to the club, contact <b>0810-345-CLUB</b> for more information!</p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12 col-md-6">
                    <img src="images/card.svg" class="img-fluid" width="500">
                </div>
                <div class="col-12 col-md-6">
                    <div class="card shadow bg-dark">
                        <div class="card-body">
                            <h5 class="text-white"><?php echo strtoupper($_SESSION["name"]. " " . $_SESSION["surname"]); ?></h5>
                            <p class="text-white display-3">Member: <?php echo $partner[$_SESSION["id"]]["member"]; ?></p>
                            <p class="text-muted">From: <?php echo $partner[$_SESSION["id"]]["from"]; ?></p>
                            <p class="text-muted">To: <?php echo $partner[$_SESSION["id"]]["to"]; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <hr>
        <div class="bg-light">
            <div class="container" id="profile">
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="display-4">Profile</h4>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <form method="POST">
                                    <div>
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo $_SESSION["name"]; ?>" required>
                                    </div>
                                    <br>
                                    <div>
                                        <label class="form-label">Surname</label>
                                        <input type="text" class="form-control" name="surname" value="<?php echo $_SESSION["surname"]; ?>" required>
                                    </div>
                                    <br>
                                    <div>
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo $_SESSION["email"]; ?>" required>
                                    </div>
                                    <br>
                                    <div>
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="pass">
                                    </div>
                                    <br>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-dark" name="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-8 mt-4 mt-lg-0">
                        <img src="images/mornings.svg" class="img-fluid" width="700">
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="alert alert-danger">
            <div class="container">
                <br>
                <div class="row">
                    <div class="col-12">
                        <p>Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please click <a href="index.php?destroy&id=<?php echo $_SESSION["id"]; ?>" class="alert-link">here</a> to to permanently delete your account!</p>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="bg-dark">
            <div class="container">
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <p class="text-muted">Copyright &copy; Club</p>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </section>
</body>
</html>