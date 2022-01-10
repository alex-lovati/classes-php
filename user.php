<?php
class User
{
    private $id = "";
    public $login = "";
    public $email = "";
    public $firstname = "";
    public $lastname = "";

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $bdd = mysqli_connect("localhost", "root", "", "classes");
        $query2 = "SELECT login FROM utilisateurs WHERE login = \"$login\"";
        $confirmpass = 'led4';
        $query = mysqli_query($bdd, $query2);
        $resultat = mysqli_fetch_all($query);

        if (!empty($resultat)) {
            echo "Le login existe déjà";
        }
        else if ($password != $confirmpass)
        {
            echo "Les mots de passes ne sont pas identiques";
        } else {
            $requete_register = "INSERT INTO `utilisateurs`(`id`, `login`, `password`, `email`, `firstame`, `lastname`) VALUES (NULL, \"$login\",\"$password\",\"$email\",\"$firstname\",\"$lastname\")";
            $query_register = mysqli_query($bdd, $requete_register);
            echo "Votre compte à été créer";
        }
    }

    public function connect($login, $password)
    {
        $bdd = mysqli_connect("localhost", "root", "", "classes");
        $query2 = "SELECT * FROM utilisateurs WHERE login = '" . $login . "'";
        $query = mysqli_query($bdd, $query2);
        $resultat = mysqli_fetch_row($query);
        if ($password == $resultat[2]) {
            $this->id = $resultat[0];
            $this->login = $resultat[1];
            $this->password = $resultat[2];
            $this->email = $resultat[3];
            $this->firstname = $resultat[4];
            $this->lastname = $resultat[5];
            echo "Connecté";
        } else {
            echo "Mot de passe incorrect";
        }
    }

public function disconnect()
{
    unset($_SESSION['login']);
}

public function delete()
{
    $bdd = mysqli_connect("localhost", "root", "", "classes");
    $login = $_SESSION['login'];
    $query2 = "SELECT * FROM utilisateurs WHERE login = '" . $login . "'";
    $query = mysqli_query($bdd, $query2);
    $resultat = mysqli_fetch_row($query);
    $requete = "DELETE FROM `classes`.`utilisateurs` WHERE login = '" . $login . "'";
    $query = mysqli_query($bdd, $requete);
    echo "Utilisateur supprimé";
    unset($_SESSION['login']);
}

public function update($login, $password, $email, $firstname, $lastname)
{
    $bdd = mysqli_connect("localhost", "root", "", "classes");
    $requete = "UPDATE `utilisateurs` SET `login` = '" . $login . "', `password` = '" . $password . "', `email` = '" . $email . "', `firstame` = '" . $firstname . "', `lastname` = '" . $lastname . "' WHERE login = '" . $this->login . "'";
    $query = mysqli_query($bdd, $requete);
    echo "</br>Votre nouveau login est  \"$login\" ";
}

public function isConnected()
{
    $bdd = mysqli_connect("localhost", "root", "", "classes");

    if (isset($_SESSION)) 
    {
        echo "Bonjour vous êtes connecté";
    } 
    else 
    {
        echo "Vous n'êtes pas connecté";
    }
}

public function getAllInfos()
{
    
    if (NULL != $this->id)
    {
        return [$this->id,$this->login,$this->password,$this->email,$this->firstname,$this->lastname];
    }
}

    public function getLogin()
    {
        if (NULL != $this->id)
        {
            return $this->login;
        }
    }
    public function getEmail()
    {
        if (NULL != $this->id)
        {
            return $this->email;
        }

        return $this->email;
    }

    public function getFirstname()
    {
        if (NULL != $this->id)
        {
            return $this->firstname;
        }

        return $this->firstname;
    }

    public function getLastname()
    {
        if (NULL != $this->lastname)
        {
            return $this->lastname;
        }

        return $this->lastname;
    }

    public function refresh()
    {
        $bdd = mysqli_connect("localhost", "root", "", "classes");
        $query2 = "UPDATE INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('?','?','?','?','?')";
        $query = mysqli_query($bdd, $query2);
        $resultat = mysqli_fetch_row($query);
            
        $this->id = $resultat[0];
        $this->login = $resultat[1];
        $this->password = $resultat[2];
        $this->email = $resultat[3];
        $this->firstname = $resultat[4];
        $this->lastname = $resultat[5];

        return $this ;
    }
}
?>