<?php

use TightenCo\Jigsaw\Jigsaw;

/** @var $container \Illuminate\Container\Container */
/** @var $events \TightenCo\Jigsaw\Events\EventBus */

$events->afterBuild(function (Jigsaw $jigsaw) {
    // we need to take the HTML at this point
    // generate a PDF
    // profit!
});