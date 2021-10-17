<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

/**
 * @decorator-auto-regenerate TRUE
 * @decorator-generated-at Thu, 23 Jun 2011 05:28:55 +0400
 * @decorator-decoratee-class phpMorphy_GrammemsProvider_GrammemsProviderInterface
 * @decorator-decorator-class phpMorphy_GrammemsProvider_Decorator
 */

abstract class phpMorphy_GrammemsProvider_Decorator implements phpMorphy_GrammemsProvider_GrammemsProviderInterface, phpMorphy_DecoratorInterface {
    /** @var phpMorphy_GrammemsProvider_GrammemsProviderInterface */
    private $object;
    /** @var Closure|null */
    private $on_instantiate;
    
    /**
     * @param $object phpMorphy_GrammemsProvider_GrammemsProviderInterface
     */
    function __construct(phpMorphy_GrammemsProvider_GrammemsProviderInterface $object) {
        $this->setDecorateeObject($object);
    }
    
    /**
     * Set current decorator behaviour to proxy model
     * @param Closure|null $onInstantiate
     */
    protected function actAsProxy(/*TODO: uncomment for php >= 5.3 Closure */$onInstantiate = null) {
        unset($this->object);
        $this->on_instantiate = $onInstantiate;
    }
    
    /**
     * @param $object phpMorphy_GrammemsProvider_GrammemsProviderInterface
     * @return phpMorphy_GrammemsProvider_Decorator
     */
    protected function setDecorateeObject(phpMorphy_GrammemsProvider_GrammemsProviderInterface $object) {
        $this->object = $object;
        return $this;
    }
    
    /**
     * @return phpMorphy_GrammemsProvider_GrammemsProviderInterface
     */
    public function getDecorateeObject() {
        return $this->object;
    }
    
    /**
     * @param string $class
     * @param array $ctorArgs
     * @return phpMorphy_GrammemsProvider_GrammemsProviderInterface
     */
    static protected function instantiateClass($class, $ctorArgs) {
        $ref = new ReflectionClass($class);
        return $ref->newInstanceArgs($ctorArgs);
    }
    
    /**
     * @param string $propName
     * @return phpMorphy_GrammemsProvider_GrammemsProviderInterface
     */
    public function __get($propName) {
        if('object' === $propName) {
            $obj = $this->proxyInstantiate();
            $this->setDecorateeObject($obj);
            return $obj;
        }
    
        throw new phpMorphy_Exception("Unknown property '$propName'");
    }
    
    /**
     * This method invoked by __get() at first time access to proxy object
     * Must return instance of 'phpMorphy_GrammemsProvider_GrammemsProviderInterface'
     * @abstract
     * @return object
     */
    protected function proxyInstantiate() {
        if(!isset($this->on_instantiate)) {
            throw new phpMorphy_Exception('You must implement phpMorphy_GrammemsProvider_Decorator::proxyInstantiate or pass \$onInstantiate to actAsProxy() method');
        }
    
        $fn = $this->on_instantiate;
        unset($this->on_instantiate);
    
        return $fn();
    }
    
    /**
     * Implement deep copy paradigm
     */
    function __clone() {
        if(isset($this->object)) {
            $this->object = clone $this->object;
        }
    }

    /**
    * @abstract
    * @param string $partOfSpeech
    * @return array
    */
    public function getGrammems($partOfSpeech) {
        $result = $this->object->getGrammems($partOfSpeech);
        return $result === $this->object ? $this : $result;
    }

}
