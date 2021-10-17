<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_GramTab_ConstStorage_Factory {
    const SPECIALS_LANG = 'specials';

    protected static function getLangMap() {
        if(false === ($map = include(__DIR__ . '/data/lang_map.php'))) {
            throw new Exception("Can`t open langs map file");
        }

        return $map;
    }

    /**
     * @return phpMorphy_Dict_GramTab_ConstStorage_Specials
     */
    static function getSpecials() {
        static $cache;

        if(null === $cache) {
            $cache = self::create(self::SPECIALS_LANG);
        }

        return $cache;
    }

    /**
     * @param string $lang
     * @return phpMorphy_GramTab_Const_Helper
     */
    static function create($lang) {
        $map = self::getLangMap();

        $lang = strtolower($lang);
        $file = isset($map[$lang]) ? $map[$lang] : $map[false];
        $filePath = __DIR__ . '/data/' . $file;
        $loader = new phpMorphy_Dict_GramTab_ConstStorage_Loader($filePath);
        $is_specials = $lang === self::SPECIALS_LANG;
        $clazz = $is_specials ?
                'phpMorphy_Dict_GramTab_ConstStorage_Specials' :
                'phpMorphy_Dict_GramTab_ConstStorage';

        $helper = new $clazz($loader);

        if(!$is_specials) {
            try {
                //throw new Exception("1");
                $helper->merge(self::getSpecials());
            } catch (Exception $e) {
                throw new Exception(
                    "Can`t inject special values to '" .
                        $helper->getLanguage() . "' [" . $lang . "] lang: " . $e->getMessage()
                );
            }
        }

        return $helper;
    }

    static function getAllHelpers() {
        $result = array();
        $lang_map = self::getLangMap();
        $created_files = array();

        foreach($lang_map as $lang => $file) {
            if(!isset($created_files[$file])) {
                $result[] = self::create($lang);
                $created_files[$file] = 1;
            }
        }

        return $result;
    }
}