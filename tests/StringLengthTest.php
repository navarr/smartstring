<?php

namespace Navarr\SmartString\Test;

use Navarr\SmartString\SmartString;
use Navarr\SmartString\SmartStringFactory;
use PHPUnit\Framework\TestCase;

class StringLengthTest extends TestCase
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
            ['abcdef', 6],
            ['こんにちは', 5],
            ['🏴󠁧󠁢󠁥󠁮󠁧󠁿', 1],
            [SmartString::build('abc'), 3] // Ensure methods properly handle a Stringable
        ];
    }

    /**
     * @dataProvider getData
     */
    public function testLength(string $string, int $expectedLength)
    {
        $testString = $this->factory->create($string);
        $this->assertEquals($expectedLength, $testString->length());
    }

    /**
     * @dataProvider getData
     */
    public function testStrlen(string $string, int $expectedLength)
    {
        $testString = $this->factory->create($string);
        $this->assertEquals($expectedLength, $testString->strlen());
    }
}
