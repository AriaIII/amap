<?php

namespace App\Model;

use Doctrine\DBAL\Connection;

class SupplierModel
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getSuppliers()
    {
        $sql = "SELECT * FROM supplier";
        $stmt = $this->connection->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }
}