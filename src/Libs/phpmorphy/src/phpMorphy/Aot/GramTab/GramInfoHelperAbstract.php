<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Aot_GramTab_GramInfoHelperAbstract
    implements phpMorphy_Aot_GramTab_GramInfoHelperInterface
{
    /**
     * @static
     * @throws phpMorphy_Exception
     * @param  $language
     * @return phpMorphy_Aot_GramTab_GramInfoHelperInterface
     */
    static function createByLanguage($language) {
        switch(strtolower($language)) {
            case 'russian':
                return new phpMorphy_Aot_GramTab_GramInfoHelper_Russian();
            case 'english':
                return new phpMorphy_Aot_GramTab_GramInfoHelper_English();
            case 'german':
                return new phpMorphy_Aot_GramTab_GramInfoHelper_German();
            default: throw new phpMorphy_Exception("Unknown '$language' language");
        }
    }
}