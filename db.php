<?php

require("config.php");

class User
{
    private $id;
    private $name;
    private $surname;
    private $email;
    private $pass;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        return $this->$name = $value;
    }

    public function store()
    {
        $mysqli = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_DATABASE);
        $query = "INSERT INTO users(name, surname, email, pass)
        VALUES(
            '" . $this->name . "',
            '" . $this->surname . "',
            '" . $this->email . "',
            '" . $this->pass . "'
        )";
        $mysqli->query($query);
        $this->id = $mysqli->insert_id;
        $mysqli->close();
    }

    public function auth()
    {
        $mysqli = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_DATABASE);
        $query = "SELECT * FROM users WHERE email =" . "'" . $this->email . "'";
        $result = $mysqli->query($query);
        if($row = $result->fetch_assoc())
        {
            $this->id = $row["id"];
            $this->name = $row["name"];
            $this->surname = $row["surname"];
            $this->email = $row["email"];
            $this->pass = $row["pass"];
        }
        $mysqli->close();
    }

    public function edit()
    {
        $mysqli = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_DATABASE);
        $query = "SELECT * FROM users WHERE id =" . $this->id;
        $result = $mysqli->query($query);
        if($row = $result->fetch_assoc())
        {
            $this->id = $row["id"];
            $this->name = $row["name"];
            $this->surname = $row["surname"];
            $this->email = $row["email"];
            $this->pass = $row["pass"];
        }
        $mysqli->close();
    }

    public function update()
    {
        $mysqli = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_DATABASE);
        $query = "UPDATE users SET
        name = '" . $this->name . "',
        surname = '" . $this->surname . "',
        email = '" . $this->email . "',
        pass = '" . $this->pass . "' WHERE id =" . $this->id;
        $mysqli->query($query);
        $mysqli->close();
    }

    public function destroy()
    {
        $mysqli = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_DATABASE);
        $query = "DELETE FROM users WHERE id =" . $this->id;
        $mysqli->query($query);
        $mysqli->close();
    }
}

?>