<?php

namespace DominoGame;

use DominoGame\Piece;
use DominoGame\Domino;
use DominoGame\Table;
use DominoGame\Board;

class Player extends Domino
{
    protected int $id;

    protected $pieces;

    protected Table $table;

    protected Board $board;

    public function __construct($id, Table $table, Board $board)
    {
        $this->id = $id;
        $this->table = $table;
        $this->board = $board;
    }

    public function __toString(): string
    {
        $name = $this->name();
        $pieces = implode('', $this->pieces);

        return "{$name}: {$pieces}";
    }

    public function getId()
    {
        return $this->id;
    }

    public function name(): string
    {
        return "Player {$this->id}";
    }

    public function movePieceToBoard()
    {
        foreach ($this->pieces as $key => $piece)
        {
            $matchedPiece = $this->board->matchLeft($piece);

            if ($matchedPiece instanceof Piece)
            {
                $this->board->prependPiece($matchedPiece);

                unset($this->pieces[$key]);

                return $matchedPiece;
            }

            $matchedPiece = $this->board->matchRight($piece);

            if ($matchedPiece instanceof Piece)
            {
                $this->board->appendPiece($matchedPiece);

                unset($this->pieces[$key]);

                return $matchedPiece;
            }
        }

        return false;
    }

    public function pickUpFromTable(): Piece
    {
        $piece = $this->table->getRandomPiece();

        $this->appendPiece($piece);

        return $piece;
    }

}