<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class CreateImageAction extends AbstractController {

    public function __invoke(
        Request $request,
        GameRepository $gameRepository
    ): Image {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile){
            throw new BadRequestException('"file" is required');
        }

        $game = $gameRepository->find($request->get('game'));
        if (!$game){
            throw new BadRequestException('"game" is required');
        }


        $image = new Image();
        $image->setFile($uploadedFile);
        $image->setGame($game);
        return $image;
    }

}
