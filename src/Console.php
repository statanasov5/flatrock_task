<?php

namespace Frt;

class Console
{
    public static $foregroundColors = [
        'bold'         => '1',
        'dim'          => '2',
        'black'        => '0;30',
        'dark_gray'    => '1;30',
        'blue'         => '0;34',
        'light_blue'   => '1;34',
        'green'        => '0;32',
        'light_green'  => '1;32',
        'cyan'         => '0;36',
        'light_cyan'   => '1;36',
        'red'          => '0;31',
        'light_red'    => '1;31',
        'purple'       => '0;35',
        'light_purple' => '1;35',
        'brown'        => '0;33',
        'yellow'       => '1;33',
        'light_gray'   => '0;37',
        'white'        => '1;37',
        'normal'       => '0;39',
    ];

    public static $backgroundColors = [
        'black'        => '40',
        'red'          => '41',
        'green'        => '42',
        'yellow'       => '43',
        'blue'         => '44',
        'magenta'      => '45',
        'cyan'         => '46',
        'light_gray'   => '47',
    ];

    public static $EOF = "\n";

    public static $BOF = "> ";

    /**
     * Logs text
     *
     * @param string $string
     * @param boolean $newLineBefore
     * @param boolean $newLineAfter
     * @param integer $timeout
     */
    public static function log(string $string, bool $newLineBefore = false, bool $newLineAfter = false, int $timeout = 20000)
    { 
		if ($newLineBefore) {
			echo self::$EOF . self::$BOF;
		}

		foreach (str_split($string) as $char) {
			echo $char;
			usleep($timeout);
		}

		if ($newLineAfter) {
			echo self::$EOF;
		}
    }
    
    /**
     * Logs colored text
     *
     * @param string $string
     * @param boolean $newLineBefore
     * @param boolean $newLineAfter
     * @param string $fgColor
     * @param string $bgColor
     * @param integer $timeout
     */
    public static function logColored(
        string $string,
        bool $newLineBefore = false,
        bool $newLineAfter = false,
        string $fgColor = null,
        string $bgColor = null,
        int $timeout = 20000
    ) {
        $coloredString = "";

        if (isset(self::$foregroundColors[$fgColor])) {
            $coloredString .= "\033[" . self::$foregroundColors[$fgColor] . "m";
        }

        if (isset(self::$backgroundColors[$bgColor])) {
            $coloredString .= "\033[" . self::$backgroundColors[$bgColor] . "m";
        }

        $coloredString .= $string . "\033[0m";

        self::log($coloredString, $newLineBefore, $newLineAfter, $timeout);
    }
}