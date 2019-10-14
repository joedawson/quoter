<?php

namespace App\Listeners;

use Dompdf\Dompdf;
use TightenCo\Jigsaw\Jigsaw;

class GeneratePDF
{
    public function handle(Jigsaw $jigsaw)
    {
        if($jigsaw->getEnvironment() !== 'production') return;

        $pages = collect($jigsaw->getOutputPaths())->reject(function($path) {
            return $this->isExcluded($path);
        })->map(function($path) {
            return $path . '/index.html';
        });

        if($pages->count())
        {
            $destination = $jigsaw->getDestinationPath();

            $pdf = new Dompdf();

            $pdf->setBasePath($destination);

            $pages->each(function($page) use ($pdf, $destination, $jigsaw)
            {
                $pdf->loadHtml($jigsaw->readOutputFile($page));
            });

            $pdf->render();

            return file_put_contents($destination . '/build.pdf', $pdf->output());
        }
    }

    public function isExcluded($path)
    {
        return starts_with($path, '/assets');
    }
}