<?php

namespace App\Controller;

use App\Model\SupplierModel;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SupplierController extends AbstractController
{
    /**
     * @Route("/supplier", name="supplier_index", methods={"GET"})
     */
    public function indexAction(SupplierModel $supplierModel)
    {
        $suppliers = $supplierModel->getSuppliers();
        return $this->json($suppliers, 200);
    }
}