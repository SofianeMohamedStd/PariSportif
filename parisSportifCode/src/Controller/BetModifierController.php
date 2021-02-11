<?php

namespace App\Controller;

use App\Repository\BetUserRepository;
use App\Repository\WalletRepository;
use App\Services\DataBaseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BetModifierController extends AbstractController
{
    /**
     * @Route("/bet/betmodifier{id}", name="betmodifier{id}")
     * @param int $id
     * @param BetUserRepository $betUserRepository
     * @return Response
     */
    public function redirectToBetModification(
        int $id, 
        BetUserRepository $betUserRepository,
        WalletRepository $walletRepository
        ): Response
    {

        $user = $this->getUser();
        $targetBet = $betUserRepository->find($id);
        $wallet = $walletRepository->find($user->getWallet()->getId());

        return $this->render('bet_modifier/index.html.twig', [
            'controller_name' => 'BetModifierController',
            'users' => $user,
            'wallet' => $wallet,
            'targetBet' => $targetBet
        ]);
    }


    /**
     * @Route("/bet/modifiedamount{id}", name="betmodifiedamount{id}")
     * @param int $id
     * @param BetUserRepository $betUserRepository
     * @param Request $request
     * @param DataBaseManager $dbmanager
     * @return Response
     */
    public function redirectToBetModified(
        int $id,
        BetUserRepository $betUserRepository,
        Request $request,
        DataBaseManager $dbmanager,
        WalletRepository $walletRepository
        ): Response
    {

        $targetBet = $betUserRepository->find($id);
        $ancienMontant = $targetBet->getAmountBet();
        $nouveauMontant = $request->query->get('montant');
        //remborser puis soustraire le nouveau montant
        $user = $this->getUser();
        $wallet1 = $walletRepository->find($user->getWallet()->getId());
        $wallet = $user->getWallet();
        $walletAmount = $user->getWallet()->getCredit();
        $wallet->addToCredit($ancienMontant);
        $wallet->removeFromCredit($nouveauMontant);
        $dbmanager->insertDataIntoBase($wallet);
        $targetBet->setAmountBet($nouveauMontant, $walletAmount);
        $dbmanager->insertDataIntoBase($targetBet);

        return $this->render('bet_modifier/modified.html.twig', [
            'controller_name' => 'BetModifierController',
            'targetBet' => $targetBet,
            'wallet' => $wallet1,
            'users' => $user,
            'ancienMontant' => $ancienMontant,
            'nouveauMontant' => $nouveauMontant
            
        ]);
    }


    /**
     * @Route("/bet/betdeletionconfirmation{id}", name="confirm_delete{id}")
     * @param int $id
     * @param BetUserRepository $betUserRepository
     * @return Response
     */

    public function redirectToBetDeletion(
        int $id,
        BetUserRepository $betUserRepository,
        WalletRepository $walletRepository): Response
    {
        $user = $this->getUser();
        $wallet1 = $walletRepository->find($user->getWallet()->getId());
        $targetBet = $betUserRepository->find($id);

        return $this->render('bet_modifier/deletion.html.twig', [
            'controller_name' => 'BetModifierController',
            'wallet' => $wallet1,
            'users' => $user,
            'targetBet' => $targetBet
        ]);
    }

    /**
     * @Route("/bet/betdeleted{id}", name="betdeleted{id}")
     * @param int $id
     * @param BetUserRepository $betUserRepository
     * @param DataBaseManager $dbmanager
     * @return Response
     */
    public function redirectToBetDeleted(
        int $id,
        BetUserRepository $betUserRepository,
        DataBaseManager $dbmanager,
        WalletRepository $walletRepository    
    ): Response
    {

        $targetBet = $betUserRepository->find($id);
        //refund amount to wallet
        $user = $this->getUser();
        $wallet = $user->getWallet();
        $wallet1 = $walletRepository->find($user->getWallet()->getId());
        $betAmount = $targetBet->getAmountBet();
        $walletAmount = $user->getWallet()->getCredit();
        $walletAmount += $betAmount;
        $wallet->addToCredit($betAmount);
        $dbmanager->insertDataIntoBase($wallet);
        //remove from db
        $dbmanager->removeDataFromBase($targetBet);


        return $this->render('bet_modifier/betDeleted.html.twig', [
            'controller_name' => 'BetModifierController',
            'wallet' => $wallet1,
            'users' => $user,
            'targetBet' => $targetBet,
            'credit' => $walletAmount
        ]);
    }


}
