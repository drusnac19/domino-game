<?php

namespace DominoGame;

use DominoGame\Piece;

class Player
{
    protected int $id;

    protected $pieces;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return "Player {$this->id} " . implode('', $this->pieces);
    }

    public function getId()
    {
        return $this->id;
    }

    public function addPiece($piece): void
    {
        $this->pieces[] = $piece;
    }

    public function getPieces(): array
    {
        return $this->pieces;
    }

    public function getTotalScore(): int
    {
        return array_reduce($this->pieces, function ($piece)
        {
            return $piece->getScore();

        }, 0);
    }

    public function getMaxDoublePiece(): int
    {
        $double = 0;

        foreach ($this->pieces as $piece)
        {
            if ($piece->isDouble() && $piece->getTop() > $double)
            {
                $double = $piece->getTop();
            }
        }

        return $double;
    }

    public function getMaxScorePiece(): int
    {
        $score = 0;

        foreach ($this->pieces as $piece)
        {
            if ($piece->getScore() > $score)
            {
                $score = $piece->getScore();
            }
        }

        return $score;
    }
}