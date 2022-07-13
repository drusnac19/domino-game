<?php

namespace DominoGame;

use DominoGame\Table;
use DominoGame\Board;
use DominoGame\Player;
use DominoGame\Log;

class Renderer
{
    public function displayPlayers(array $players): void
    {
        echo Log::theme(['magenta'], implode(PHP_EOL, $players));
    }

    public function displayBoard(Board $board): void
    {
        echo Log::dark("Board: {$board}");
    }

    public function displayTable(Table $table): void
    {
        echo Log::warning("Table: {$table}");
    }

    public function displayWinner(string $message): void
    {
        echo Log::success($message);
    }

    public function printLine(?string $title = ''): void
    {
        $message = str_pad(" {$title} ", 30, "-", STR_PAD_BOTH) . PHP_EOL;

        echo Log::theme(['italic'], $message);
    }

    public function printBlankLine(?string $title = ''): void
    {
        echo PHP_EOL;
    }
}