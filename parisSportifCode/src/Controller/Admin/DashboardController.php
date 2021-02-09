<?php

namespace App\Controller\Admin;

use App\Entity\Competition;
use App\Entity\Equipe;
use App\Entity\EvenementSport;
use App\Entity\Joueurs;
use App\Entity\Sport;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(BetCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ParisSportifCode');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Sport','fas fa-list',Sport::class);
        yield MenuItem::linkToCrud('Teams','fas fa-list',Equipe::class);
        yield MenuItem::linkToCrud('Players','fas fa-list',Joueurs::class);
        yield MenuItem::linkToCrud('Event','fas fa-list',EvenementSport::class);
        yield MenuItem::linkToCrud('Competition','fas fa-list',Competition::class);
        yield MenuItem::linktoRoute('Payment','fas fa-list','payment_admin');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
