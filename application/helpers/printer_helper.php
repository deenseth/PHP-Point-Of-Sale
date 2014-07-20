<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function init() {
        return "\x1B\x40";
    }
    function reset_styles() {
        return "\x1B\x21\x00";
    }
    function make_style($font, $bold = false, $underline = false, $double_width = false, $double_height = false) {
        $hex = 0;
        if ($font) {
            $hex += $font;
        }
        if ($bold) {
            $hex += 8;
        }
        if ($underline) {
            $hex += 80;
        }
        if ($double_width) {
            $hex += 20;
        }
        if ($double_height) {
            $hex += 10;
        }
        if ($hex < 10) {
            $hex = "0".$hex; 
        }
        return "\x1B\x21\x".$hex;
    }

    function center()
    {
        return "\x1b\x61\x31";
            //\x1b\x61\x01\x1b\x45\x01\x1b\x2d\x02
    }

    function left()
    {
        return "\x1B\x61\x30";
    }

    function right()
    {
        return "\x1B\x61\x32";
    }

    function header_style()
    {
        return "\x1b\x21\x30";
    }

    function total_style()
    {
        return "\x1B\x21\x18";
    }

    function new_line(){
        return "\x0A";
    }

    function open_drawer()
    {
        return "\x1B\x70\x30";
    }
?>