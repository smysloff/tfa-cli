<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_GrammemsProvider_ru_RU extends phpMorphy_GrammemsProvider_ForFactoryAbstract {
    const INTERNAL_ENCODING = 'utf-8';
    static protected $instances = array();

    static protected $grammems_map = array(
        'род' => array('МР', 'ЖР', 'СР'),
        'одушевленность' => array('ОД', 'НО'),
        'число' => array('ЕД', 'МН'),
        'падеж' => array('ИМ', 'РД', 'ДТ', 'ВН', 'ТВ', 'ПР', 'ЗВ', '2'),
        'залог' => array('ДСТ', 'СТР'),
        'время' => array('НСТ', 'ПРШ', 'БУД'),
        'повелительная форма' => array('ПВЛ'),
        'лицо' => array('1Л', '2Л', '3Л'),
        'краткость' => array('КР'),
        'сравнительная форма' => array('СРАВН'),
        'превосходная степень' => array('ПРЕВ'),
        'вид' => array('СВ', 'НС'),
        'переходность' => array('ПЕ', 'НП'),
        'безличный глагол' => array('БЕЗЛ'),
    );

    function getSelfEncoding() {
        return self::INTERNAL_ENCODING;
    }

    function getGrammemsMap() {
        return self::$grammems_map;
    }

    static function instance(phpMorphy_MorphyInterface $morphy) {
        $key = $morphy->getEncoding();

        if(!isset(self::$instances[$key])) {
            $class = __CLASS__;
            self::$instances[$key] = new $class($key);
        }

        return self::$instances[$key];
    }
}