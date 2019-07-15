<?php


namespace CLI;


class Colors
{
    private $foreground_colors = array();
    private $background_colors = array();

    public function __construct()
    {
        $this->foreground_colors['black'] = '0;30';
        $this->foreground_colors['dark_gray'] = '1;30';
        $this->foreground_colors['blue'] = '0;34';
        $this->foreground_colors['light_blue'] = '1;34';
        $this->foreground_colors['green'] = '0;32';
        $this->foreground_colors['light_green'] = '1;32';
        $this->foreground_colors['cyan'] = '0;36';
        $this->foreground_colors['light_cyan'] = '1;36';
        $this->foreground_colors['red'] = '0;31';
        $this->foreground_colors['light_red'] = '1;31';
        $this->foreground_colors['purple'] = '0;35';
        $this->foreground_colors['light_purple'] = '1;35';
        $this->foreground_colors['brown'] = '0;33';
        $this->foreground_colors['yellow'] = '1;33';
        $this->foreground_colors['light_gray'] = '0;37';
        $this->foreground_colors['white'] = '1;37';
        $this->background_colors['black'] = '40';
        $this->background_colors['red'] = '41';
        $this->background_colors['green'] = '42';
        $this->background_colors['yellow'] = '43';
        $this->background_colors['blue'] = '44';
        $this->background_colors['magenta'] = '45';
        $this->background_colors['cyan'] = '46';
        $this->background_colors['light_gray'] = '47';
    }

    public function getColoredString($string, $colors_str = 'black;white')
    {
        $colored_string = "";
        $colors = explode(';', $colors_str);
        if (count($colors) >= 1 && isset($this->foreground_colors[$colors[0]])) {
            $colored_string .= "\033[" . $this->foreground_colors[$colors[0]] . "m";
        }
        if (count($colors) >= 2 && isset($this->background_colors[$colors[1]])) {
            $colored_string .= "\033[" . $this->background_colors[$colors[1]] . "m";
        }
        $colored_string .= $string . "\033[0m";

        return $colored_string;
    }

}