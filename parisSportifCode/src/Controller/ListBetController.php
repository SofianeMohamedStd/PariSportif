<?php

namespace App\Controller;

use App\Entity\BetUser;
use App\Form\PayementBetType;
use App\Repository\BetRepository;
use App\Repository\BetUserRepository;
use App\Services\DataBaseManager;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListBetController extends AbstractController
{
    /**
     * @param int $betid
     * @param BetRepository $betUserRepository
     * @return Response
     * @Route("/indexuser/choice/bet/{betid}", name="choice_bet")
     */

    public function index(int $betid,BetRepository $betUserRepository, DataBaseManager $dbmanager): Response
    {
        $user = $this->getUser();
        $bet = $betUserRepository->find($betid);
        $BetCart = new BetUser();
        $BetCart->setBet ($bet);
        $BetCart->setUser ($user);

        $dbmanager->insertDataIntoBase($BetCart);

        return $this->redirectToRoute('index_user');
    }

    /**
     * @param BetUserRepository $betUserRepository
     * @param Request $request
     * @param DataBaseManager $dbmanager
     * @return Response
     * @Route("/message", name="message", methods="GET")
     */
    public function payementBet(BetUserRepository $betUserRepository,
                                Request $request,
                                DataBaseManager $dbmanager): Response
    {
        $sum = $request->query->get("sum");
        $bitId = $request->query->get("message");

        $user = $this->getUser();
        $walletC = $user->getWallet();
        $wallet = $user->getWallet()->getCredit();
        $bet = $betUserRepository->find($bitId);
        $coteBet = $bet->getBet ()->getCote ();
        if($bet->getAmountBet () == null) {
            $bet -> setAmountBet ( $sum , $wallet );
            $bet -> setGainPossible ($sum, $coteBet);
            $walletC -> removeFromCredit ( $sum );
            $dbmanager->insertDataIntoBase($walletC);
            $dbmanager->insertDataIntoBase($bet);
        }else{
            $walletC->addToCredit($bet->getAmountBet ());
            $bet -> setAmountBet ( $sum , $wallet );
            $bet -> setGainPossible ($sum, $coteBet);
            $walletC -> removeFromCredit ( $sum );
            $dbmanager->insertDataIntoBase($walletC);
            $dbmanager->insertDataIntoBase($bet);
        }

        return $this->redirectToRoute('index_user');


    }
}
