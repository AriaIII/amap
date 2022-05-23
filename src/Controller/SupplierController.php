<?php

namespace App\Controller;

use App\Model\SupplierModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->json($suppliers, Response::HTTP_OK);
    }

    /**
     * @Route("/supplier/{id}", name="supplier_show", methods={"GET"})
     */
    public function showAction($id, SupplierModel $supplierModel)
    {
        dump($id);
        $supplier = $supplierModel->getSupplier($id);

        return $this->json($supplier, Response::HTTP_OK);
    }

    /**
     * @Route("/supplier", name="supplier_create", methods={"POST"})
     */
    public function createAction(Request $request, SupplierModel $supplierModel)
    {
        $data = json_decode($request->getContent());
        if (empty($data->firstname) || empty($data->lastname) || empty($data->email)) {
            return new Response('Les champs firstname, lastname, email sont obligatoires.', Response::HTTP_BAD_REQUEST);
        }

        $firstname = $this->testInput($data->firstname);
        $lastname = $this->testInput($data->lastname);
        $email = $this->testInput($data->email);

        if ($supplierModel->getEmail($email)) {
            return new Response('Cet email existe déjà.', Response::HTTP_BAD_REQUEST);
        }

        $supplierModel->create($firstname, $lastname, $email);

        $supplier = $supplierModel->getSupplierByEmail($email);

        return $this->json($supplier, Response::HTTP_CREATED);
    }

    // nettoie les données reçues
    private function testInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}