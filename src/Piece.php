<?php

namespace DominoGame;

class Piece
{
    protected int $top = 0;
    protected int $bottom = 0;

    public function __construct($top, $bottom)
    {
        $this->top = $top;
        $this->bottom = $bottom;
    }

    public function __toString(): string
    {
        return "[{$this->top}:{$this->bottom}]";
    }


    public function getTop(): int
    {
        return $this->top;
    }

    public function getBottom(): int
    {
        return $this->bottom;
    }

    public function getScore(): int
    {
        return $this->top + $this->bottom;
    }

    public function isDouble(): bool
    {
        return $this->top === $this->bottom;
    }

    public function equalTo(Piece $piece): bool
    {
        return $this->getScore() === $piece->getScore();
    }

}