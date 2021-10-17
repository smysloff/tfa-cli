<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


interface phpMorphy_UserDict_VisitorInterface {
    /**
     * @param string $lexem
     * @param phpMorphy_UserDict_Pattern $pattern
     */
    function addLexem($lexem, phpMorphy_UserDict_Pattern $pattern);

    /**
     * @param phpMorphy_UserDict_Pattern $pattern
     * @param bool $deleteFromInternal
     * @param bool $deleteFromExternal
     */
    function deleteLexem(phpMorphy_UserDict_Pattern $pattern, $deleteFromInternal, $deleteFromExternal);

    /**
     *
     */
    function editLexem(phpMorphy_UserDict_XmlDiff_Command_Edit $command);
}