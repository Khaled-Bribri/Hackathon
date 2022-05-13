<?php

namespace App\Model;

class ProductManager extends AbstractManager
{
    public const TABLE = 'products';

    /**
     * Insert new item in database
     */
    public function insert($name, $dateCreation, $dateExpiration): string
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`,`DateCreation`,`DateExpiration`) 
        VALUES (:name,:DateCreation,:DateExpiration)");
        $statement->bindValue('name', $name, \PDO::PARAM_STR);
        $statement->bindValue('DateCreation', $dateCreation, \PDO::PARAM_STR);
        $statement->bindValue('DateExpiration', $dateExpiration, \PDO::PARAM_STR);
        $statement->execute();
        return $this->pdo->lastInsertId();
    }



    /**
     * select one item from database by id
     */
    public function selectOneById(int $id): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Update item in database
     */
    public function update(array $items): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name,`DateCreation` = now(),
        `DateExpiration` = :DateExpiration WHERE id=:id");
        $statement->bindValue('id', $items['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $items['name'], \PDO::PARAM_STR);
        $statement->bindValue('DateExpiration', $items['DateExpiration'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    /**
     * Delete item in database
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
