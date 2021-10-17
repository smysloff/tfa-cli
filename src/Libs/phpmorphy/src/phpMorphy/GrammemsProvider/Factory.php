<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_GrammemsProvider_Factory {
    protected static $included = array();

    static function create(phpMorphy_MorphyInterface $morphy) {
        $locale = $GLOBALS['__phpmorphy_strtolower']($morphy->getLocale());

        if(!isset(self::$included[$locale])) {
            $class = "phpMorphy_GrammemsProvider_$locale";

            if(!class_exists($class)) {
                self::$included[$locale] = call_user_func(array($class, 'instance'), $morphy);
            } else {
                self::$included[$locale] = new phpMorphy_GrammemsProvider_Empty($morphy);
            }
        }


        return self::$included[$locale];
    }
}