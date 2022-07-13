<?php

require_once './vendor/autoload.php';

use DominoGame\Log;
use DominoGame\Gameplay;
use DominoGame\Renderer;

// The game requires CLI to run
(php_sapi_name() == 'cli') || die('The game requires CLI to run'); //#work#

try
{
    echo Log::info('Welcome (ɔ◔‿◔)ɔ ') . PHP_EOL;

    $render = new Renderer();
    $game = new Gameplay($render);

    $totalPlayers = readline("Enter total players: ");
    $totalPlayers = intval($totalPlayers);
    $totalPlayers = $totalPlayers ? $totalPlayers : 2;
    $game->initPlayers($totalPlayers);

    $game->start();

    while ($game->isProgress())
    {
        $game->update();
        $game->render();
    }

    $game->end();

} catch (Error $e)
{
    $message = "An error has occurred: " . $e->getMessage();

    echo Log::danger($message);
}
