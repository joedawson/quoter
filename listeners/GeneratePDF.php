<?php

namespace App\Listeners;

use TightenCo\Jigsaw\Jigsaw;

use PHPHtmlParser\Dom;
use Spatie\Browsershot\Browsershot;

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
                return $this->dom->load($jigsaw->readOutputFile($page))
                                 ->find('body')
                                 ->innerHtml;
            });

            // Append the HTMl from pages to the output...
            $html .= implode('', $pages->all());

            // Close off the output...
            $html .= '</body></html>';

            // Create the PDF...
            return Browsershot::html($html)
                              ->showBackground()
                              ->save($jigsaw->getDestinationPath() . '/build.pdf');
        }
    }

    public function isExcluded($path)
    {
        return starts_with($path, '/assets');
    }
}