<?php

declare(strict_types=1);

namespace ProxyManagerTest\ProxyGenerator\RemoteObject\MethodGenerator;

use PHPUnit\Framework\TestCase;
use ProxyManager\ProxyGenerator\RemoteObject\MethodGenerator\MagicSet;
use ProxyManagerTestAsset\EmptyClass;
use ReflectionClass;
use Zend\Code\Generator\PropertyGenerator;

/**
 * Tests for {@see \ProxyManager\ProxyGenerator\RemoteObject\MethodGenerator\MagicSet}
 *
 * @group Coverage
 */
class MagicSetTest extends TestCase
{
    /**
     * @covers \ProxyManager\ProxyGenerator\RemoteObject\MethodGenerator\MagicSet::__construct
     */
    public function testBodyStructure() : void
    {
        $reflection = new ReflectionClass(EmptyClass::class);
        /** @var PropertyGenerator|\PHPUnit_Framework_MockObject_MockObject $adapter */
        $adapter = $this->createMock(PropertyGenerator::class);
        $adapter->expects(self::any())->method('getName')->will(self::returnValue('foo'));

        $magicGet = new MagicSet($reflection, $adapter);

        self::assertSame('__set', $magicGet->getName());
        self::assertCount(2, $magicGet->getParameters());
        self::assertStringMatchesFormat(
            '$return = $this->foo->call(\'ProxyManagerTestAsset\\\EmptyClass\', \'__set\', array($name, $value));'
            . "\n\nreturn \$return;",
            $magicGet->getBody()
        );
    }
}
