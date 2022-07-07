<?php

namespace DominoGame;

use DominoGame\Piece;
use DominoGame\Player;
use DominoGame\Table;
use DominoGame\Board;

class Gameplay
{
    const MIN_PLAYERS = 2;
    const MAX_PLAYERS = 4;
    const MAX_PIECES_PLAYER = 7;

    // stores the pocket pieces
    public Table $table;
    // stores the pocket pieces
    public Board $board;

    public $players = [];

    public function __construct()
    {
        $this->table = new Table();
        $this->board = new Board();
    }

    public function __toString(): string
    {
        $separator = '<br>';
        $players = implode($separator, $this->players);
        $table = 'Table: ' . $this->table;
        $board = 'Board: ' . $this->board;

        return $players . $separator . $table . $separator . $board . $separator;
    }

    public function initPlayers(int $totalPlayers): void
    {
        if ($totalPlayers < self::MIN_PLAYERS || $totalPlayers > self::MAX_PLAYERS)
        {
            throw new \Error("The game requires {self::MIN_PLAYERS} - {self::MAX_PLAYERS} players");
        }

        // create the players
        for ($i = 1; $i <= $totalPlayers; $i++)
        {
            $player = new Player($i);

            // assign the default pieces to each player
            for ($j = 0; $j < self::MAX_PIECES_PLAYER; $j++)
            {
                // get a random piece from the table
                $piece = $this->table->getRandomPiece();

                $player->addPiece($piece);
            }

            $this->players[$player->getId()] = $player;
        }
    }

    public function getFirstPlayer(): Player
    {
        $maxDouble = 0;
        $newPlayer = null;

        foreach ($this->players as $player)
        {
            $double = $player->getMaxDoublePiece();

            if ($double > $maxDouble)
            {
                $maxDouble = $double;
                $newPlayer = $player;
            }
        }

        return $newPlayer;
    }

    public function matchPlayerPieceInBoard($player): bool
    {
        foreach ($player->getPieces() as $piece)
        {
            if ($this->board->matchPiece($piece))
            {
                return true;
            }

            
        }

        return false;
    }

    public function putPlayerPieceInBoard($piece): void
    {
        $this->board->prependPiece($piece);
//        $this->board->appendPiece($piece);
    }

    public function pickupPlayerPieceFromTable(Player $player): void
    {
        $piece = $this->table->getRandomPiece();

        $player->addPiece($piece);
    }
}
