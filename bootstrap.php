<?php

use TightenCo\Jigsaw\Jigsaw;
use App\Listeners\GeneratePDF;

/** @var $container \Illuminate\Container\Container */
/** @var $events \TightenCo\Jigsaw\Events\EventBus */

$events->afterBuild(GeneratePDF::class);