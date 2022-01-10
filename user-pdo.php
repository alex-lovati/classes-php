<?php
session_start();
class User
{
    // Les objets:
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;


    public function __construct()
    {
    }

    // REQUETE PRECISE SI BESOIN
    // public function __destruct()
    // {

    // }


    public function register($login, $password, $email, $firstname, $lastname)
    {
        try {
            $connexion = new PDO('mysql:host=localhost;dbname=classes;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $requete = $connexion->query("INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login', '$password','$email','$firstname','$lastname')");

        $requete2 = $connexion->query("SELECT * FROM utilisateurs WHERE login = '$login'");
        $resultat = $requete2->fetch();

        return $resultat;
    }

    public function connect($login, $password)
    {
        try {
            $connexion = new PDO('mysql:host=localhost;dbname=classes;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $requete3 = $connexion->query("SELECT * FROM utilisateurs WHERE login = '$login'");
        $resultat2 = $requete3->fetch();

        if ($password == $resultat2['password']) {
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            $this->id = $resultat2['id'];
            $this->login = $resultat2['login'];
            $this->email = $resultat2['email'];
            $this->firstname = $resultat2['firstname'];
            $this->lastname = $resultat2['lastname'];
        }

        $info = array($this->id, $this->login, $this->email, $this->firstname, $this->lastname);
        return $info;
    }

    public function disconnect()
    {
        session_unset();
        session_destroy();
        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstname = null;
        $this->lastname = null;
    }

    public function delete()
    {
        try {
            $connexion = new PDO('mysql:host=localhost;dbname=classes;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $requete = $connexion->query("DELETE FROM utilisateurs WHERE login = '$this->login'");
        $this->disconnect();
    }

    public function update($login, $password, $email, $firstname, $lastname)
    {
        try {
            $connexion = new PDO('mysql:host=localhost;dbname=classes;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $requete = $connexion->query("UPDATE utilisateurs SET login = '$login', password='$password', email='$email', firstname='$firstname', lastname ='$lastname' WHERE login = '$this->login'");
    }

    public function isConnected()
    {
        if (isset($this->login)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllInfos()
    {
        $info = array($this->id, $this->id, $this->login, $this->email, $this->firstname, $this->lastname);
        return $info;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function refresh()
    {
        try {
            $connexion = new PDO('mysql:host=localhost;dbname=classes;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $refresh = $connexion->query("SELECT * FROM utilisateurs WHERE login = '$this->login'");
        $resultatrefresh = $refresh->fetch();
        $this->id = $resultatrefresh['id'];
        $this->login = $resultatrefresh['login'];
        $this->email = $resultatrefresh['email'];
        $this->firstname = $resultatrefresh['firstname'];
        $this->lastname = $resultatrefresh['lastname'];
    }
}
?>