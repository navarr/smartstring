<?php

namespace Navarr\SmartString\Test;

use Navarr\SmartString\SmartString;
use Navarr\SmartString\SmartStringFactory;
use PHPUnit\Framework\TestCase;
use Stringable;

class ConcatenateTest extends TestCase
{
    private SmartStringFactory $factory;

    public function setUp(): void
    {
        $this->factory = new SmartStringFactory();
        parent::setUp();
    }

    public function getData(): array
    {
        return [
            ['a', 'b', 'ab'],
            ['a', SmartString::build('b'), 'ab'],
            ['a', '🏴', 'a🏴'],
            ['🏴', 'a', '🏴a'],
        ];
    }

    /**
     * @dataProvider getData
     */
    public function testConcat(string $initial, Stringable|string $additional, string $expectedResult): void
    {
        $object = $this->factory->create($initial);
        $result = $object->concat($additional);
        $this->assertInstanceOf(SmartString::class, $result);
        $this->assertEquals($expectedResult, (string)$result);
    }

    /**
     * @dataProvider getData
     */
    public function testConcatenate(string $initial, Stringable|string $additional, string $expectedResult): void
    {
        $object = $this->factory->create($initial);
        $result = $object->concatenate($additional);
        $this->assertInstanceOf(SmartString::class, $result);
        $this->assertEquals($expectedResult, (string)$result);
    }
}
