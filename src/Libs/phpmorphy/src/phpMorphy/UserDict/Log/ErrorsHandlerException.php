<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */



class phpMorphy_UserDict_Log_ErrorsHandlerException
    implements phpMorphy_UserDict_Log_ErrorsHandlerInterface {

    function handle($message) {
        throw new phpMorphy_UserDict_Exception($message);
    }
}