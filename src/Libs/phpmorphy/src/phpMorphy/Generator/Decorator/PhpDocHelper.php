<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_Decorator_PhpDocHelper {
    /**
     * @static
     * @param string $decorateeClass
     * @param string $decoratorClass
     * @param bool $isAutoRegenerate
     * @return string
     */
    static function generateHeaderPhpDoc(
        $decorateeClass,
        $decoratorClass,
        $isAutoRegenerate = true
    ) {
        $isAutoRegenerate = $isAutoRegenerate ? 'TRUE' : 'FALSE';

        $text = '/**' . PHP_EOL .
                ' * @decorator-auto-regenerate ' . $isAutoRegenerate . PHP_EOL .
                ' * @decorator-generated-at ' . date('r') . PHP_EOL .
                ' * @decorator-decoratee-class ' . $decorateeClass . PHP_EOL .
                ' * @decorator-decorator-class ' . $decoratorClass . PHP_EOL .
                ' */';

        return $text;
    }

    /**
     * @static
     * @param string $phpCodeString
     * @return phpMorphy_Generator_Decorator_PhpDocHelperHeader
     */
    static function parseHeaderPhpDoc($phpCodeString) {
        $phpCodeString = ltrim($phpCodeString);
        if(!preg_match('/^<\?php/', $phpCodeString)) {
            $phpCodeString = '<' . '?php' . PHP_EOL . $phpCodeString;
        }

        $tokens = token_get_all($phpCodeString);
        $first_doc_comment = false;

        foreach($tokens as $token) {
            if(is_array($token) && T_DOC_COMMENT == $token[0]) {
                $first_doc_comment = (string)$token[1];
                break;
            }
        }

        return
            phpMorphy_Generator_Decorator_PhpDocHelperHeader::constructFromString(
                $first_doc_comment
            );
    }
}