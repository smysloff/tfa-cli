<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_PhpFileParser_FileDescriptor {
    public
        /** @var phpMorphy_Generator_PhpFileParser_ClassDescriptor[] */
        $classes = array(),
        /** @var phpMorphy_Generator_PhpFileParser_phpDoc */
        $phpDoc;

    function finalize() {
        if(null !== $this->phpDoc) {
            foreach($this->classes as $class) {
                if(
                    null !== $class->phpDoc &&
                    $class->phpDoc->startLine === $this->phpDoc->startLine &&
                    $class->phpDoc->endLine === $this->phpDoc->endLine
                ) {
                    $this->phpDoc = null;
                }
            }
        }
    }
}