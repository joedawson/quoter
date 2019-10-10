<?php

namespace App\Listeners;

use Dompdf\Dompdf;
use TightenCo\Jigsaw\Jigsaw;

class GeneratePDF
{
    protected $exclude = [
        '.', '..', 'assets'
    ];

    public function handle(Jigsaw $jigsaw)
    {
        $destination = $jigsaw->getDestinationPath();

        $pages = collect(scandir($destination))->reject(function($path) {
            return $this->isExcluded($path);
        });

        if($pages->count())
        {
            $pdf = new Dompdf();

            $pages->each(function($page) use ($pdf, $destination) {
                return $pdf->loadHtml(file_get_contents($destination . '/' . $page));
            });

            $pdf->render();

            $output = $pdf->output();

            file_put_contents($destination . '/' . 'file.pdf', $output);
        }
    }

    public function isExcluded($path)
    {
        return str_is($this->exclude, $path);
    }
}