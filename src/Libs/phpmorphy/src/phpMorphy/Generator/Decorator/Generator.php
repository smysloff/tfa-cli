<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_Decorator_Generator {
    /**
     * @static
     * @param string $decorateeClass
     * @return string
     */
    static function getDecoratorClassName($decorateeClass) {
        $decorateeClass = preg_replace('~([^_]+)_(\1)(Interface|Abstract)?$~', '\1_', $decorateeClass);

        return $decorateeClass . 'Decorator';
    }

    /**
     * @static
     * @throws phpMorphy_Exception
     * @param string $decorateeClass
     * @param string|null $decoratorClass
     * @param null|phpMorphy_Generator_Decorator_HandlerInterface $handler
     * @return string
     */
    static function generate(
        $decorateeClass,
        $decoratorClass = null,
        phpMorphy_Generator_Decorator_HandlerInterface $handler = null
    ) {
        if(!class_exists($decorateeClass) && !interface_exists($decorateeClass)) {
            throw new phpMorphy_Exception("Class '$decorateeClass' not found");
        }

        if(null === $decoratorClass) {
            $decoratorClass = self::getDecoratorClassName($decorateeClass);
        }

        $helper = new phpMorphy_Generator_ReflectionHelper();
        if(null === $handler) {
            $handler = new phpMorphy_Generator_Decorator_HandlerDefault();
        }

        $classref = new ReflectionClass($decorateeClass);

        // generateHeaderPhpDoc header
        $buffer = $handler->generateHeaderDocComment($decorateeClass, $decoratorClass) .
                  PHP_EOL . PHP_EOL;

        $parents = null;
        $interfaces = null;
        if($classref->isInterface()) {
            $interfaces = array($decorateeClass);
        } else {
            $parents = array($decorateeClass);
        }

        // generateHeaderPhpDoc class declaration
        $buffer .= $handler->generateClassDeclaration(
            $classref->getDocComment(),
            $decoratorClass,
            $parents,
            $interfaces
        );

        // generateHeaderPhpDoc common methods
        $buffer .=
            ' {' . PHP_EOL .
            $handler->generateCommonMethods($decoratorClass, $decorateeClass) .
            PHP_EOL . PHP_EOL;

        // generateHeaderPhpDoc wrapped methods
        foreach($helper->getOverridableMethods($classref) as $method) {
            $buffer .= $handler->generateMethod(
                $method->getDocComment(),
                $helper->generateMethodModifiers($method, ReflectionMethod::IS_ABSTRACT),
                $method->returnsReference(),
                $method->getName(),
                $helper->generateMethodArguments($method),
                $helper->generateArgsPass($method)
            ) . PHP_EOL . PHP_EOL;
        }

        $buffer .= '}' . PHP_EOL;

        return $buffer;
    }
}
