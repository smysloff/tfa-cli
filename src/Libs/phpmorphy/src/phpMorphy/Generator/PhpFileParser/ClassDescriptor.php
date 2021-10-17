<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Generator_PhpFileParser_ClassDescriptor {
    const IS_INTERFACE = 'interface';
    const IS_CLASS = 'class';

    public
        /** @var string */
        $namespace,
        /** @var IS_INTERFACE|IS_CLASS */
        $type,
        /** @var string */
        $name,
        /** @var int */
        $startLine,
        /** @var int */
        $endLine,
        /** @var phpMorphy_Generator_PhpFileParser_phpDoc */
        $phpDoc;
}