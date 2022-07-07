<?php

require_once './vendor/autoload.php';

use DominoGame\Log;
use DominoGame\Gameplay;

// The game requires CLI to run
//(php_sapi_name() == 'cli') || die('The game requires CLI to run'); //#work#

try
{
//    echo Log::info('Welcome (ɔ◔‿◔)ɔ ') . PHP_EOL;

    $game = new Gameplay();

    $totalPlayers = readline("Enter total players: ");
    $game->initPlayers(2);


//    $firstPlayer = $game->getFirstPlayer();
    $player = $game->players[2];

    echo $game . '<br>';

    foreach (range(1, 10) as $i)
    {
        $game->pickupPlayerPieceFromTable($player);
        echo $game . '<br>';
    }

} catch (Error $e)
{
    $message = "An error has occurred: " . $e->getMessage();

    echo Log::danger($message);
}

//debug
//echo '<pre>', print_r($game), '</pre>';
