<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_Decorator_PhpDocHelperHeader {
    public
        $auto_regenerate = false,
        $generated_at = false,
        $decoratee_class = false,
        $decorator_class = false;

    protected function __construct() {
    }

    /**
     * @static
     * @param  $string
     * @return void
     */
    static function constructFromString($string) {
        $lines = explode("\n", $string);
        $obj = new phpMorphy_Generator_Decorator_PhpDocHelperHeader;
        $any_found = false;

        array_walk(
            $lines,
            function ($line) use ($obj, $any_found) {
                $line = ltrim(trim($line, " \t*"), '@');
                if(false !== ($pos = strpos($line, ' '))) {
                    $key = strtolower(substr($line, 0, $pos));

                    if(preg_match('/^decorator-/', $key)) {
                        $key = str_replace('-', '_', substr($key, 10));
                        $value = ltrim(substr($line, $pos));

                        $obj->$key = $value;
                        $any_found = true;
                    }
                }
            }
        );

        $obj->auto_regenerate = strtolower($obj->auto_regenerate) === 'true';
        $obj->generated_at = false !== $obj->generated_at ?
            strtotime($obj->generated_at) :
            false;

        return $obj;
    }
}