<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_Generator_Decorator_HandlerInterface {
    /**
     * @abstract
     * @param string $decorateeClass
     * @param string $decoratorClass
     * @return string
     */
    function generateHeaderDocComment($decorateeClass, $decoratorClass);

    /**
     * @abstract
     * @param string $decoratorClass
     * @param string $decorateeClass
     * @return string
     */
    function generateCommonMethods($decoratorClass, $decorateeClass);

    /**
     * @abstract
     * @param string $docComment
     * @param string $modifiers
     * @param bool $isReturnRef
     * @param string $name
     * @param string $args
     * @param string $passArgs
     * @return string
     */
    function generateMethod($docComment, $modifiers, $isReturnRef, $name, $args, $passArgs);

    /**
     * @abstract
     * @param string $docComment
     * @param string $class
     * @param string[]|null $extends
     * @param string[]|null $implements
     * @return string
     */
    function generateClassDeclaration($docComment, $class, $extends, $implements);
}