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
            // Get the head from the first page...
            $this->dom->load($jigsaw->readOutputFile($pages->first()));

            // Prepare the HTML...
            $html = '<!DOCTYPE html>';
            $html .= '<html lang="en">';
            $html .= '<head>'. $this->dom->find('head')->innerHtml .'</head>';

            // Fetch the inner HTML from each page...
            $pages = $pages->map(function($page) use($jigsaw) {
                $this->dom->load($jigsaw->readOutputFile($page));

                return $this->dom->find('body')->innerHtml;
            });

            // Append the HTMl from pages to the output...
            $html .= implode('', $pages->all());

            // Close off the output...
            $html .= '</body></html>';

            // Replacing asset path to be relative to PDF
            $html = preg_replace('/\"\/assets*/', '"./assets', $html);

            // Prepare the destination...
            $destination = $jigsaw->getDestinationPath();

            // Create a new PDF and implode the HTML from the collection...
            $pdf = new Dompdf();
            $pdf->setBasePath($destination);
            $pdf->loadHtml($html);
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