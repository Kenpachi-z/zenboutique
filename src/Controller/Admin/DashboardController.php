<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Produit;
use App\Entity\User;
use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ){
        
    }






    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        $url = $this->adminUrlGenerator
        ->setController(OrderCrudController::class)
        ->generateUrl();

        return $this->redirect($url);

     // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
       

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('French boutique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('orders', 'fas fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Categorie', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-tag', Produit::class);
        yield MenuItem::linkToCrud('Carriers', 'fas fa-truck', Carrier::class);
    }
}
