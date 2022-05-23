<?php

namespace App\Model;

use PDOException;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;

class SupplierModel
{
    private $connection;

    public function __construct(Connection $connection)
    { 
        try {
            //code...
            $this->connection = $connection;
            $this->connection->connect();
        } catch (\Exception $exception) {
            echo 'Erreur de connexion...<br>';
            echo $exception->getMessage();
            exit;
        }
    }

    public function getSuppliers()
    {
        $sql = "SELECT * FROM supplier";
        $stmt = $this->connection->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getSupplier($id)
    { 
        $sql = "SELECT * FROM supplier WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $result = $stmt->executeQuery([
            'id' => $id,
        ]);

        return $result->fetchAssociative();
    }

    public function create($firstname, $lastname, $email)
    {
        $sql = "INSERT INTO supplier (firstname, lastname, email) VALUES(:firstname, :lastname, :email)";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email
        ]);
    }

    public function getSupplierByEmail($email)
    {
        $sql = 'SELECT * FROM supplier WHERE email = :email';
        $stmt = $this->connection->prepare($sql);
        $result = $stmt->executeQuery([
            'email' => $email
        ]);

        return $result->fetchAssociative();
    }

    public function getEmail($email)
    {
        $sql = "SELECT email FROM supplier WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $result = $stmt->executeQuery([
            'email' => $email
        ]);
        return $result->fetchAssociative();
    }
}