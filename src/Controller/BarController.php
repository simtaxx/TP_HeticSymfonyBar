<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\Beer;
use App\Entity\Category;

class BarController extends AbstractController
{

    private $client;
    private $categories = ['Brune', 'Ambrée', 'Blanche', 'Sans alcool'];

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    /**
    * @Route("/menu", name="menu")
    */
    public function mainMenu(string $routeName): Response {
        $normalsCategories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findByTerm('normal');

        return $this->render('partials/main_menu.html.twig', [
            'categories' => $normalsCategories,
            'routeName' => $routeName
        ]);
    }

    /**
    * @Route("/categories/{category}", name="categories")
    */
    public function category(string $category) {
        $beers = $this->getDoctrine()
            ->getRepository(Beer::class)
            ->findByCategory($category);

        return $this->render('categories/index.html.twig', [
            'title' => $category,
            'beers' => $beers
        ]);
    }

    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions() {
        return $this->render('mentions/index.html.twig', [
            'title' => 'Mentions légales',
        ]);
    }

    /**
     * @Route("/beers", name="beers")
     */
    public function beers() {
        $beerRepo = $this->getDoctrine()->getRepository(Beer::class);
        return $this->render('beers/index.html.twig', [
            'title' => 'Page beers',
            'beers' => $beerRepo->findAll()
        ]);
    }

    /**
     * @Route("/beer/{id}", name="beer")
     */
    // todo int $id
    public function beer($id) {
        $currentBeer = $this->getDoctrine()
            ->getRepository(Beer::class)
            ->findById($id);

        if (!isset($currentBeer)) {
            return $this->redirectToRoute('home');
        }

        return $this->render('beer/index.html.twig', [
            'title' => 'Beer',
            'beer' => $currentBeer
        ]);
    }

    /**
     * @Route("/home", name="home")
     */
    public function home() {
        $beerRepo = $this->getDoctrine()
            ->getRepository(Beer::class)
            ->findBy(array(), array('id' => 'DESC'), 3);

        return $this->render('home/index.html.twig', [
            'title' => "Page d'accueil",
            'beers' => $beerRepo
        ]);
    }
}
