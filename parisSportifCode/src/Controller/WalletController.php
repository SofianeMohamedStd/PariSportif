<?php

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\AddMoneyWalletType;
use App\Repository\WalletRepository;
use App\Services\DataBaseManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WalletController extends AbstractController
{
    /**
     * @param WalletRepository $walletRepository
     * @return Response
     * @IsGranted("ROLE_USER")
     * @Route("/wallet", name="wallet")
     */
    public function index(WalletRepository $walletRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $users = $this->getUser();
        $credit = $walletRepository->find($users->getWallet()->getId());
        return $this->render('page_wallet/index.html.twig', [
            'controller_name' => 'WalletController',
            'user' => $users,
            'wallet' => $credit,
        ]);
    }

    /**
     * @param Request $request
     * @param DataBaseManager $dbmanager
     * @return Response
     * @IsGranted("ROLE_USER")
     * @Route("/wallet/add", name="wallet_add")
     */
    public function addMoney(Request $request, DataBaseManager $dbmanager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $users = $this->getUser();
        $wallet = $users->getWallet();
        $formWallet = $this->createForm(AddMoneyWalletType::class);
        $formWallet->handleRequest($request);

        if ($formWallet->isSubmitted() && $formWallet->isValid()) {
            $money = $formWallet->get('credit')->getData();
            $wallet->addToCredit($money);
            $dbmanager->insertDataIntoBase($wallet);
            $this->addFlash('success', 'la somme a bien été ajouter !');
        }
        return $this->render('page_wallet/addMoney.html.twig', [
           'controller_name' => 'WalletController',
           'user' => $users,
           'formWallet' => $formWallet->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param DataBaseManager $dbmanager
     * @return Response
     * @IsGranted("ROLE_USER")
     * @Route("/wallet/withdraw", name="wallet_draw")
     */
    public function drawMoney(Request $request, DataBaseManager $dbmanager): Response
    {
        $users = $this->getUser();
        $wallet = $users->getWallet();

        $formWallet = $this->createForm(AddMoneyWalletType::class);
        $formWallet->handleRequest($request);

        if ($formWallet->isSubmitted() && $formWallet->isValid()) {
            $money = $formWallet->get('credit')->getData();
            $limit = $wallet->getCredit();
            if ($money <= $limit) {
                $wallet->removeFromCredit($money);
                $dbmanager->insertDataIntoBase($wallet);
                $this->addFlash('success', 'la somme a bien été retirer !');
            } else {
                $formWallet->addError(new FormError('The amount is greater than your credit'));
            }
        }
        return $this->render('page_wallet/withdrawMoney.html.twig', [
            'controller_name' => 'WalletController',
            'user' => $users,
            'formWallet' => $formWallet->createView(),
        ]);
    }
}
