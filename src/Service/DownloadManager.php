<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use ZipArchive;

class DownloadManager
{
    public function zipDownload($files)
    {
        /*$document ='0af93550b8fb169c59c54b81497dd35c.jpg';

        // Create new Zip Archive.
        $zip = new \ZipArchive();
        $zipName = 'Documents.zip';


        if ($zip->open('test.zip') === TRUE) {
            if ($zip->addEmptyDir('newDirectory')) {
                $zip->open($zipName, \ZipArchive::CREATE);

                $zip->addFromString(basename($document), file_get_contents($document));

                $response = new Response(file_get_contents($zipName));
                $response->headers->set('Content-Type', 'application/zip');
                $response->headers->set('Content-Disposition', 'attachment;filename="' . $zipName . '"');
                $response->headers->set('Content-length', filesize($zipName));

                @unlink($zipName);
                return $response;
            }
            $zip->close();
        }*/

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
    }
}
