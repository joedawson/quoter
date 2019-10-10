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
        if($jigsaw->getEnvironment() !== 'production')
        {
            return;
        }

        $destination = $jigsaw->getDestinationPath();

        $pages = collect(scandir($destination))->reject(function($path) {
            return $this->isExcluded($path);
        });

        if($pages->count())
        {
            if(!file_exists($destination . '/pdfs'))
            {
                mkdir($destination . '/pdfs');
            }

            $pages->each(function($page) use ($destination)
            {
                $pdf = new Dompdf();

                $pdf->loadHtml(file_get_contents($destination . '/' . $page));

                $pdf->render();

                $output = $pdf->output();

                return file_put_contents($destination . '/pdfs/' . basename($page, '.html') . '.pdf', $output);
            });
        }
    }

    public function isExcluded($path)
    {
        return str_is($this->exclude, $path);
    }
}