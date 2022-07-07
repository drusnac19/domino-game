<?php

namespace DominoGame;

use DominoGame\Piece;

class Table
{
    const MAX_PIECES = 28;

    protected array $pieces = [];

    public function __construct()
    {
        $this->pieces = $this->generatePieces();
    }

    public function __toString(): string
    {
        return implode('', $this->pieces);
    }

    public function generatePieces(): array
    {
        return array_map(function ()
        {
            return new Piece(rand(0, 6), rand(0, 6));

        }, range(0, self::MAX_PIECES));
    }

    public function getRandomPiece(): Piece
    {
        $randomKey = array_rand($this->pieces);

        $piece = $this->pieces[$randomKey];

        unset($this->pieces[$randomKey]);

        return $piece;
    }
}