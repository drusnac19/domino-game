<?php

namespace DominoGame;

use DominoGame\Piece;
use DominoGame\Domino;

class Board extends Domino
{
    protected $pieces = [];

    public function matchLeft(Piece $piece)
    {
        $head = $this->pieces[0];

        if ($piece->getTop() === $head->getTop())
        {
            return $piece->swap();
        }

        if ($piece->getBottom() === $head->getTop())
        {
            return $piece;
        }

        return false;
    }

    public function matchRight(Piece $piece)
    {
        $total = count($this->pieces);

        $tail = $this->pieces[$total - 1];

        if ($piece->getTop() === $tail->getBottom())
        {
            return $piece;
        }

        if ($piece->getBottom() === $tail->getBottom())
        {
            return $piece->swap();
        }

        return false;
    }
}