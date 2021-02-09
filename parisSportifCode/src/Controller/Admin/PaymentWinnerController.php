<?php


namespace App\Controller\Admin;


use App\Repository\BetUserRepository;
use App\Security\EmailForWinner;
use App\Services\DataBaseManager;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentWinnerController extends AbstractController
{
    private EmailForWinner $EmailForWinner;

    public function __construct(EmailForWinner $EmailForWinner)
    {
        $this->EmailForWinner = $EmailForWinner;
    }
    /**
     * @param BetUserRepository $betUserRepository
     * @return Response
     * @Route("/admin/payment", name="payment_admin")
     */
    public function index(BetUserRepository $betUserRepository): Response
    {
        $BetUsers = $betUserRepository->findAll();

        return  $this->render('payment/index.html.twig',[
            'UsersWinner' => $BetUsers,
        ]);
    }

    /**
     * @Route("/admin/payment/user",name="payment_admin_user")
     * @param BetUserRepository $betUserRepository
     * @param DataBaseManager $baseManager
     * @return Response
     */
    public function paymentUser(BetUserRepository $betUserRepository,
                                DataBaseManager $baseManager): Response
    {
        $BetUsers = $betUserRepository->findAll();
        foreach($BetUsers as $betUser)
        {
            $UserPrediction = $betUser->getBet()->isResultBet();
            if($UserPrediction == true)
            {
                $wallet = $betUser->getUser()->getWallet();
                $emailUser = $betUser->getUser()->getEmail();
                $wallet->addToCredit($betUser->getGainPossible());
                $baseManager->insertDataIntoBase($wallet);
                $this->EmailForWinner->sendEmailToWinner(
                    (new TemplatedEmail())
                        ->from('equipeParis@test.com')
                        ->to($emailUser)
                        ->htmlTemplate('payment/winner_email.html.twig')
                        ->subject('You Win a bet')
                );

            }
        }
        return $this->redirectToRoute('admin');

    }


}