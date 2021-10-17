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
 * @decorator-generated-at Thu, 23 Jun 2011 05:32:06 +0400
 * @decorator-decoratee-class phpMorphy_Dict_Writer_WriterAbstract
 * @decorator-decorator-class phpMorphy_Dict_Writer_Decorator
 */

abstract class phpMorphy_Dict_Writer_Decorator extends phpMorphy_Dict_Writer_WriterAbstract implements phpMorphy_DecoratorInterface {
    /** @var phpMorphy_Dict_Writer_WriterAbstract */
    private $object;
    /** @var Closure|null */
    private $on_instantiate;
    
    /**
     * @param $object phpMorphy_Dict_Writer_WriterAbstract
     */
    function __construct(phpMorphy_Dict_Writer_WriterAbstract $object) {
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
     * @param $object phpMorphy_Dict_Writer_WriterAbstract
     * @return phpMorphy_Dict_Writer_Decorator
     */
    protected function setDecorateeObject(phpMorphy_Dict_Writer_WriterAbstract $object) {
        $this->object = $object;
        return $this;
    }
    
    /**
     * @return phpMorphy_Dict_Writer_WriterAbstract
     */
    public function getDecorateeObject() {
        return $this->object;
    }
    
    /**
     * @param string $class
     * @param array $ctorArgs
     * @return phpMorphy_Dict_Writer_WriterAbstract
     */
    static protected function instantiateClass($class, $ctorArgs) {
        $ref = new ReflectionClass($class);
        return $ref->newInstanceArgs($ctorArgs);
    }
    
    /**
     * @param string $propName
     * @return phpMorphy_Dict_Writer_WriterAbstract
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
     * Must return instance of 'phpMorphy_Dict_Writer_WriterAbstract'
     * @abstract
     * @return object
     */
    protected function proxyInstantiate() {
        if(!isset($this->on_instantiate)) {
            throw new phpMorphy_Exception('You must implement phpMorphy_Dict_Writer_Decorator::proxyInstantiate or pass \$onInstantiate to actAsProxy() method');
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

    public function setObserver(phpMorphy_Dict_Writer_Observer_ObserverInterface $observer) {
        $result = $this->object->setObserver($observer);
        return $result === $this->object ? $this : $result;
    }

    public function hasObserver() {
        $result = $this->object->hasObserver();
        return $result === $this->object ? $this : $result;
    }

    public function getObserver() {
        $result = $this->object->getObserver();
        return $result === $this->object ? $this : $result;
    }

    public function write(phpMorphy_Dict_Source_SourceInterface $source) {
        $result = $this->object->write($source);
        return $result === $this->object ? $this : $result;
    }

}
