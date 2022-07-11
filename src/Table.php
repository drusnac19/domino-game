<?php

namespace DominoGame;

use DominoGame\Piece;
use DominoGame\Domino;

class Table extends Domino
{
    protected $pieces = [];

    public function __construct()
    {
        $this->pieces = $this->generate();
    }

    /**
     * 28 domino pieces are laid upside down randomly.
     * Each piece is divided in half and has two sets of dots in each half.
     * Each set can have 0 to 6 dots.
     * @return array
     */
    public function generate(): array
    {
        $pieces = [];

        for ($i = 0; $i <= 6; $i++)
        {
            for ($j = $i; $j <= 6; $j++)
            {
                $pieces[] = new Piece($i, $j);
            }
        }

        shuffle($pieces);

        return $pieces;
    }
}