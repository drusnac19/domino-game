<?php

namespace DominoGame;

class Domino
{
    protected $pieces = [];

    public function __toString(): string
    {
        return implode('', $this->pieces);
    }

    public function getPieces(): array
    {
        return $this->pieces;
    }

    public function getRandomPiece(): ?Piece
    {
        $randomKey = array_rand($this->pieces);

        $piece = $this->pieces[$randomKey];

        unset($this->pieces[$randomKey]);

        return $piece;
    }

    public function getTotalScore(): int
    {
        return array_reduce($this->pieces, function ($acumulator, $piece)
        {
            return $acumulator + $piece->getScore();
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

    public function getTotal(): int
    {
        return count($this->pieces);
    }

    public function prependPiece(Piece $piece): void
    {
        $this->pieces = array_merge([$piece], $this->pieces);
    }

    public function appendPiece(Piece $piece): void
    {
        $this->pieces[] = $piece;
    }

    public function hasPieces(): bool
    {
        return (bool)count($this->pieces);
    }


}