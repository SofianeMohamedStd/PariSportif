<?php


namespace App\Controller;


use App\Form\DocumentType;
use App\Services\DataBaseManager;
use App\Services\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    /**
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param DataBaseManager $dbManager
     * * @IsGranted("ROLE_USER")
     * @return RedirectResponse|Response
     * @Route("/document/new", name="app_document_new")
     */
    public function new(Request $request,FileUploader $fileUploader,DataBaseManager $dbManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $users = $this->getUser();
        $document = $users->getDocument();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $document->setBrochureFilename($brochureFileName);
            }
            $dbManager->insertDataIntoBase($document);
            return $this->redirectToRoute('app_document_new');
        }
        return $this->render('document/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}