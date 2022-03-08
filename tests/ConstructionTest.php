<?php

namespace Navarr\SmartString\Test;

use Navarr\SmartString\SmartString;
use Navarr\SmartString\SmartStringFactory;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Stringable;

class ConstructionTest extends TestCase
{
    private SmartStringFactory $factory;

    public function setUp(): void
    {
        $this->factory = new SmartStringFactory();
    }

    public function getData(): array
    {
        return [
            ['a', 'a', false],
            [SmartString::build('a'), 'a', false],
            ['🏴', '🏴', true],
            [SmartString::build('🏴'), '🏴', true],
        ];
    }

    /**
     * @dataProvider getData
     * @covers       SmartString::build
     */
    public function testBuild(
        Stringable|string $suppliedValue,
        string $expectedValue,
        bool $expectedUseGraphemeValue
    ): void {
        $object = SmartString::build($suppliedValue);
        $this->testObject($object, $expectedValue, $expectedUseGraphemeValue);
    }

    /**
     * @dataProvider getData
     * @covers       SmartStringFactory::create
     */
    public function testFactory(
        Stringable|string $suppliedValue,
        string $expectedValue,
        bool $expectedUseGraphemeValue
    ): void {
        $object = $this->factory->create($suppliedValue);
        $this->testObject($object, $expectedValue, $expectedUseGraphemeValue);
    }

    private function testObject(SmartString $object, string $expectedValue, bool $expectedUseGraphemeValue)
    {
        $reflectionObject = new ReflectionClass($object);

        $valueProp = $reflectionObject->getProperty('value');
        $shouldUseGraphemeProp = $reflectionObject->getProperty('shouldUseGrapheme');

        $this->assertEquals($expectedValue, $valueProp->getValue($object));
        $this->assertEquals($expectedUseGraphemeValue, $shouldUseGraphemeProp->getValue($object));
    }
}
