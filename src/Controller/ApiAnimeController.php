<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\Episode;
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
     * @Route("/episode/{id}/sync", name="episode_sync_by_id", requirements={"id"="\d+"})
     */
    public function syncEpisode(Episode $episode){

        //API Url
        $url = 'https://discordapp.com/api/webhooks/589592547752673306/LemL_uLnSsbaCu55HGrICCFhsfobnIg6wez16hExCDUS18O0ilgXAgmf_k4OLW4lNdOg';
        
        //Initiate cURL.
        $ch = curl_init($url);
        
        //The JSON data.
        $data = array('embeds' => [[
                "description" => "Épisode 10/24",
                "color" => 14177041,
                "timestamp" => "2019-06-16T19:42:19.321Z",
                "footer" => [
                    "icon_url" => "https://cdn.discordapp.com/emojis/469823712720322560.png?v=1",
                    "text" => "@KnK"
                ],
                "thumbnail" => [
                    "url" => "https://pbs.twimg.com/media/D3___vjXoAA93oz.jpg:large"
                ],
                "image" => [
                    "url" => "https://kodoku-no-kawarini.moe/assets/img/caroltuesdayaffiche.jpg"
                ],
                "author" => [
                    "name" => "carole & tuesday",
                    "url" => "https://kodoku-no-kawarini.moe/carole-and-tuesday.php",
                    "icon_url" => "https://kodoku-no-kawarini.moe/assets/img/tuturu.png"
                ],
                "fields" => [
                    [
                        "name" => "Avancement:",
                        "value"=> "\n**Trad** : :white_check_mark:\n\n**Time** : :white_check_mark:\n\n**Check** : :white_check_mark:\n\n**Adapt** : :x:",
                        "inline" => true
                    ],
                    [
                        "name" => "Publié: : :x:",
                        "value" => "\n**Edit** : :x:\n\n**Qcheck** : :x:\n\n**Enco** : :x:",
                        "inline" => true
                    ]
                ]
                    ]]
                    );
        
        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($data);
        
        
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
        
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        
        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type : application/json')); 
        
        //Disable CURLOPT_SSL_VERIFYHOST and CURLOPT_SSL_VERIFYPEER by
        //setting them to false.
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //Execute the request
        $result = curl_exec($ch);

        if(curl_errno($ch)){
            echo 'Request Error:' . curl_error($ch);
        };
    }
   

}
