<?php

namespace DominoGame;

use DominoGame\Piece;
use DominoGame\Player;
use DominoGame\Table;
use DominoGame\Board;
use DominoGame\Renderer;

class Gameplay
{
    const MIN_PLAYERS = 2;

    const MAX_PLAYERS = 4;

    const MAX_PIECES_PLAYER = 7;

    protected $players = [];

    protected Table $table;

    protected Board $board;

    protected Renderer $renderer;

    protected ?Player $player = null;

    protected ?Player $winner = null;

    protected bool $inProgress = true;

    public function __construct(Renderer $renderer)
    {
        $this->table = new Table();
        $this->board = new Board();

        $this->render = $renderer;
    }

    public function start(): void
    {
        $this->player = $this->getFirstPlayer();

        $piece = $this->player->getRandomPiece();
        $this->board->appendPiece($piece);

        $name = $this->player->name();
        $double = $this->player->getMaxDoublePiece();
        $this->render->printLine("{$name} started with double {$double} and put {$piece}");
        $this->render();
    }

    public function update(): void
    {
        $this->player = $this->nextPlayer($this->player);

        $movedPiece = $this->player->movePieceToBoard();

        if ($movedPiece instanceof \DominoGame\Piece)
        {
            $message = $this->player->name() . ' put ' . $movedPiece;
        } else
        {
            if (!$this->table->hasPieces())
            {
                $this->inProgress = false;

                return;
            }

            $pickedPiece = $this->player->pickUpFromTable();
            $message = $this->player->name() . ' picked ' . $pickedPiece;
        }

        $this->render->printLine($message);

        if (!$this->player->hasPieces())
        {
            $this->winner = $this->player;

            $this->inProgress = false;
        }
    }

    public function end(): void
    {
        if (is_null($this->winner))
        {
            $this->winner = $this->getWinnerWithMinimScore();
            $message = 'The winner is with minim score: ' . $this->winner->name() . ' with score of ' . $this->winner->getTotalScore();
        } else
        {
            $message = 'The winner is: ' . $this->winner->name();
        }

        $this->render->displayWinner($message);
    }

    public function render(): void
    {
        $this->render->displayPlayers($this->players);
        $this->render->printBlankLine();

        $this->render->displayTable($this->table);
        $this->render->printBlankLine();

        $this->render->displayBoard($this->board);
        $this->render->printBlankLine();
    }

    public function isProgress(): bool
    {
        return $this->inProgress && ($this->table->hasPieces() || $this->player->hasPieces());
    }

    /**
     * Return an instance of the table
     * @return \DominoGame\Table
     */
    public function getTable(): Table
    {
        return $this->table;
    }

    /**
     * Return an instance of the board
     * @return \DominoGame\Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * It's played by a minimum of 2 players and a max of 4
     * @param int $totalPlayers
     * @return void
     */
    public function initPlayers(int $totalPlayers): void
    {
        $minPlayers = self::MIN_PLAYERS;
        $maxPlayers = self::MAX_PLAYERS;
        if ($totalPlayers < $minPlayers || $totalPlayers > $maxPlayers)
        {
            throw new \Error("The game requires {$minPlayers} - {$maxPlayers} players");
        }

        // create the players
        for ($i = 1; $i <= $totalPlayers; $i++)
        {
            $player = new Player($i, $this->table, $this->board);

            // 2 players get 7 pieces
            // 3 players get 6 pieces
            // 4 players get 5 pieces
            $totalPieces = self::MAX_PIECES_PLAYER;
            $totalPieces = $totalPlayers == 3 ? 6 : $totalPieces;
            $totalPieces = $totalPlayers == 4 ? 5 : $totalPieces;

            // assign the default pieces to each player
            for ($j = 0; $j < $totalPieces; $j++)
            {
                // get a random piece from the table
                $piece = $this->table->getRandomPiece();

                $player->appendPiece($piece);
            }

            $id = $player->getId();

            $this->players[$id] = $player;
        }
    }

    /**
     * The player with the bigger double starts
     * @return Player
     */
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

        // what if there is no double? let the player with the greatest score to start
        if (is_null($newPlayer))
        {
            $maxScore = 0;

            foreach ($this->players as $player)
            {
                $score = $player->getMaxScorePiece();

                if ($score > $maxScore)
                {
                    $maxScore = $score;
                    $newPlayer = $player;
                }
            }
        }

        return $newPlayer;
    }

    /**
     * This function will return the next player
     * @param \DominoGame\Player $player
     * @return \DominoGame\Player
     */
    public function nextPlayer(Player $player): Player
    {
        $totalKeys = count($this->players);
        $keys = array_keys($this->players);
        $nextId = $player->getId();

        foreach ($keys as $key => $id)
        {
            if ($player->getId() == $id)
            {
                $nextId = $keys[($key + 1) % $totalKeys];
            }
        }

        return $this->players[$nextId];
    }

    /**
     * If both players still have pieces in the end, the winner is the one with the least total dots.
     * These are calculated by adding the dots from all the pieces in the player's hand.
     * @return \DominoGame\Player
     */
    public function getWinnerWithMinimScore(): Player
    {
        $players = $this->players;
        $minimPlayer = array_shift($players);
        $minimScore = $minimPlayer->getTotalScore();

        foreach ($players as $player)
        {
            $score = $player->getTotalScore();
            if ($score < $minimScore)
            {
                $minimScore = $score;
                $minimPlayer = $player;
            }
        }

        return $minimPlayer;
    }

}
