<?php

namespace DominoGame;

use DominoGame\Piece;

class Board
{
    protected array $pieces = [];

    public function __toString(): string
    {
        return implode('', $this->pieces);
    }

    public function canMatch(Piece $piece)
    {
        if (count($this->pieces))
        {
            return true;
        }

        $head = $this->pieces[0];
        $tail = $this->pieces[count($this->pieces) - 1];

        return ($piece->equalTo($head) || $piece->equalTo($tail));
    }

    public function prependPiece(Piece $piece): void
    {
        $this->pieces = array_merge([$piece], $this->pieces);
    }

    public function appendPiece(Piece $piece): void
    {
        $this->pieces[] = $piece;
    }
}