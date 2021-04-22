<?php

namespace App\Model;

class ProfileManager extends AbstractManager
{
    public const TABLE = 'profiles';

    public function insert($lastName, $firstName, $email, $password, $sexe, $birthday)
    {
        $query = 'INSERT INTO profiles (lastname, firstname, email, pswd, gender,birthday)
                    VALUES (:lastname, :firstname, :email, :pswd, :gender, :birthday);';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':lastname', $lastName, \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $firstName, \PDO::PARAM_STR);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':pswd', $password, \PDO::PARAM_STR);
        $statement->bindValue(':gender', $sexe, \PDO::PARAM_BOOL);
        $statement->bindParam(':birthday', $birthday, \PDO::PARAM_STR);
        $statement->execute();
    }



    public function selectOne($email, $password)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT  id from profiles WHERE email=:email AND  pswd=:pswd");
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':pswd', $password, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public function update($email, $password, $birthday, $id): bool
    {
        $statement = $this->pdo->prepare("UPDATE  profiles SET email=:email, pswd=:pswd, 
            birthday=:birthday WHERE id =:id");
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':pswd', $password, \PDO::PARAM_STR);
        $statement->bindParam(':birthday', $birthday, \PDO::PARAM_STR);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);

        return $statement->execute();
    }
}