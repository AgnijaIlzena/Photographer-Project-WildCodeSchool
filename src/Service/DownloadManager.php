<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use ZipArchive;

class DownloadManager
{
    /*public function zipDownload($files)
    {
       $pathdir = "/uploads/";
        $nomzip = "test.zip";

        $zip = new ZipArchive();
        if ($zip -> open($nomzip, ZipArchive::CREATE) === true) {
            dd($pathdir);
            $dir = opendir($pathdir);

            while ($fichier = readdir($dir)) {
                if (is_file($pathdir . $fichier)) {
                    $fichier = '0af93550b8fb169c59c54b81497dd35c.jpg';
                    $zip -> addFile($pathdir . $fichier, $fichier);
                }
            }
            $zip ->close();
        }
    }*/
}
