<?php

declare(strict_types=1);

namespace ProxyManager\ProxyGenerator\LazyLoadingGhost\MethodGenerator;

use ProxyManager\Generator\MethodGenerator;
use Zend\Code\Generator\Exception\InvalidArgumentException;
use Zend\Code\Generator\MethodGenerator as ZendMethodGenerator;
use Zend\Code\Generator\PropertyGenerator;

/**
 * Implementation for {@see \ProxyManager\Proxy\LazyLoadingInterface::initializeProxy}
 * for lazy loading ghost objects
 *
 */
class InitializeProxy extends MethodGenerator
{
    /**
     * Constructor
     *
     *
     * @throws InvalidArgumentException
     */
    public function __construct(PropertyGenerator $initializerProperty, ZendMethodGenerator $callInitializer)
    {
        parent::__construct('initializeProxy');
        $this->setReturnType('bool');

        $this->setBody(
            'return $this->' . $initializerProperty->getName() . ' && $this->' . $callInitializer->getName()
            . '(\'initializeProxy\', []);'
        );
    }
}
