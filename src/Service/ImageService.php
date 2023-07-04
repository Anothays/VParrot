<?php

namespace App\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
    private ParameterBagInterface $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(File $picture, ?string $folder = '', ?int $width = 300, ?int $height = 300): string
    {
//        dd($picture);
        $timestamp = time();

        // On donne un nouveau nom à l'image
//        $fichier = substr(md5(uniqid(rand(), true)), 0, 8).'.jpg';
        $fichier = $timestamp . '.jpg';

        //On récupère le nom du fichier
        $extension = '.' . $picture->getExtension();
        $filename = str_replace($extension, '', $picture->getFilename());
//        $filename = $picture->getFilename();

        // On récupère les infos de l'image
        $picture_infos = getimagesize($picture);

        if (!$picture_infos) {
            throw new Exception('Format d\'image incorrect');
        }

        // On vérifie le format de l'image
        $picture_source = match($picture->getMimeType()) {
            'image/png' => imagecreatefrompng($picture),
            'image/jpeg' => imagecreatefromjpeg($picture),
            'image/webp' => imagecreatefromwebp($picture),
            default => throw new Exception('Format d\'image incorrect'),
        };

        // On recadre l'image
        // On récupère les dimensions
        $imageWidth = $picture_infos[0];
        $imageHeight = $picture_infos[1];

        // On vérifie l'orientation de l'image
        switch ($imageWidth <=> $imageHeight) {
            case -1: //portrait
                $squareSize = $imageWidth;
                $src_x = 0;
                $src_y = ($imageHeight - $squareSize) / 2;
                break;
            case 0: //Carré
                $squareSize = $imageWidth;
                $src_x = 0;
                $src_y = 0;
                break;
            case 1: //Paysage
                $squareSize = $imageHeight;
                $src_x = ($imageWidth - $squareSize) / 2;
                $src_y = 0;
                break;
        }

        // On crée une nouvelle image vierge
        $resized_picture = imagecreatetruecolor($width, $height);
        imagecopyresampled($resized_picture, $picture_source, 0, 0, $src_x, $src_y, $width, $height, $squareSize, $squareSize);

        $path = $this->params->get('resized_images_directory'). $folder;

        // On crée le dossier de destination s'il n'existe pas
        if(!file_exists($path)) {
            mkdir($path,0777, true);
        }

        // Nouveau path de l'image cropée
        $newRelativeFilePath = $filename . '_' . $width . 'x' . $height . '_' . $fichier;

        // On stocke l'image recadrée
        imagejpeg($resized_picture, $path . '/' . $newRelativeFilePath);

        // On supprime l'image originale
        if (is_file($path . '/' . $filename . $extension)) {
            unlink($path . '/' . $filename . $extension);
        }

        return $newRelativeFilePath;
    }

    public function delete(string $fichier, ?string $folder = '', ?int $width = 300, ?int $height = 300)
    {
        if($fichier !== 'default.webp') {
            $success = false;
            $path = $this->params->get('images_directory') . $folder;
            $mini = $path . '/upload/' . $width . 'x' . $height . '/' . $fichier;
//dd($mini);
            if(file_exists($mini)){
                unlink($mini);
                $success = true;
            }
            $original = $path . '/' . $fichier;

            if(file_exists($original)) {
                unlink($mini);
                $success = true;
            }

            return $success;
        }
        return false;
    }
}