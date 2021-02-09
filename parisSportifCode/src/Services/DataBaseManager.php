<?php
namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DataBaseManager extends AbstractController
{
    public function insertDataIntoBase(object $object)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist ($object);
        $entityManager->flush ();
    }

    public function removeDataFromBase(object $object)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($object);
        $entityManager->flush ();
    }

}