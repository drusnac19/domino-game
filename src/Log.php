<?php

namespace DominoGame;

/**
 * Comand line print theme
 * @link https://stackoverflow.com/questions/34034730/how-to-enable-color-for-php-cli#answer-69580828
 */

class Log
{
    static function theme(array $format = [], string $text = '')
    {
        $codes = [
            'bold'    => 1, 'italic' => 3, 'underline' => 4, 'strikethrough' => 9,
            'black'   => 30, 'red' => 31, 'green' => 32, 'yellow' => 33, 'blue' => 34, 'magenta' => 35, 'cyan' => 36, 'white' => 37,
            'blackbg' => 40, 'redbg' => 41, 'greenbg' => 42, 'yellowbg' => 44, 'bluebg' => 44, 'magentabg' => 45, 'cyanbg' => 46, 'lightgreybg' => 47
        ];

        $formatMap = array_map(function ($v) use ($codes)
        {
            return $codes[$v];
        }, $format);

        return "\e[" . implode(';', $formatMap) . 'm' . $text . "\e[0m";
    }

    static function dark(string $text)
    {
        return self::theme(['blue'], $text);
    }

    static function info(string $text)
    {
        return self::theme(['blue'], $text);
    }

    static function success(string $text)
    {
        return self::theme(['green'], $text);
    }

    static function warning(string $text)
    {
        return self::theme(['yellow'], $text);
    }

    static function danger(string $text)
    {
        return self::theme(['red'], $text);
    }
}