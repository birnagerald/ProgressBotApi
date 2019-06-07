<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Repository\AnimeRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiAnimeController extends AbstractController
{
    
    /**
     * @Route("/anime", name="anime_list", methods={"GET"})
     */
    public function index(AnimeRepository $repo)
    {
        $animes = $repo->findAll();
         return $this->json($animes);
    }

    // /**
    //  * @Route("/anime/{id}", name="anime_show", requirements={"id"="\d+"})
    //  */
    // public function show(Anime $anime)
    // {
    //     return $this->json($anime);
    // }

    /**
     * @Route("/anime/add", name="anime_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer, ObjectManager $manager)
    {
        $animePost = $serializer->deserialize($request->getContent(), Anime::class, 'json');
        $manager->persist($animePost);
        $manager->flush();

        return $this->json($animePost);
    }

    /**
     * @Route("/anime/{slug}/delete", name="anime_delete", methods={"DELETE"})
     */
    public function delete(Anime $anime, ObjectManager $manager)
    {
        
        $manager->remove($anime);
        $manager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }



    /**
     * @Route("/anime/{slug}", name="anime_show_by_slug", methods={"GET"})
     */
    public function showBySlug(Anime $anime)
    {
       return $this->json($anime);
    }

   

}
