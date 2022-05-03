<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\User;
use App\Exception\MyException;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Rest\Get('/anime/{id}', name: 'get_anime')]
    #[Rest\View(serializerGroups: ['get_anime'])]
    public function getAnime($id, ManagerRegistry $doctrine)
    {
        $animeRepos = $doctrine->getRepository(Anime::class);
        $anime = $animeRepos->find($id);

        if($anime == null)
        {
            throw new MyException('Wrong anime id');
        }

        return $anime;
    }

    #[Rest\Get('/user/{username}/animelist', name: 'get_anime_list')]
    #[Rest\View(serializerGroups: ['get_anime', 'user_list'])]
    public function getAnimeList($username, ManagerRegistry $doctrine)
    {
        $userRepos = $doctrine->getRepository(User::class);
        $user = $userRepos->findOneBy(['username' => $username]);

        if($user == null)
        {
            throw new MyException('User doesn\'t exists');
        }

        return $user;
    }
}
