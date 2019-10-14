<?php

namespace App\Listeners;

use Dompdf\Dompdf;
use TightenCo\Jigsaw\Jigsaw;
use PHPHtmlParser\Dom;

class GeneratePDF
{
    protected $dom;

    public function __construct()
    {
        $this->dom = new Dom;
    }

    public function handle(Jigsaw $jigsaw)
    {
        if($jigsaw->getEnvironment() !== 'production') return;

        // Get all generated pages...
        $pages = collect($jigsaw->getOutputPaths())->reject(function($path) {
            return $this->isExcluded($path);
        })->map(function($path) {
            return $path . '/index.html';
        });

        // If we have pages...
        if($pages->count())
        {
            // Fetch the inner HTML from each page...
            $html = $pages->map(function($page) use ($jigsaw) {
                $this->dom->load($jigsaw->readOutputFile($page));

                return $this->dom->find('body')->innerHtml;
            });

            // Prepare the destination...
            $destination = $jigsaw->getDestinationPath();

            // Create a new PDF and implode the HTML from the collection...
            $pdf = new Dompdf();
            $pdf->setBasePath($destination);
            $pdf->loadHtml(implode('', $html->all()));
            $pdf->render();

            // Save the PDF...
            return file_put_contents($destination . '/build.pdf', $pdf->output());
        }
    }

    public function isExcluded($path)
    {
        return starts_with($path, '/assets');
    }
}