<?php

namespace Navarr\SmartString\Test;

use Navarr\SmartString\SmartString;
use Navarr\SmartString\SmartStringFactory;
use PHPUnit\Framework\TestCase;
use Stringable;

class FindPositionTest extends TestCase
{
    private SmartStringFactory $factory;

    public function setUp(): void
    {
        $this->factory = new SmartStringFactory();
        parent::setUp();
    }

    private function getDataCaseSensitive(): array
    {
        return [
            ['abcABCdefDEF', 'c', 2],
            ['abcabcdefdef', 'c', 5, 3],
        ];
    }

    private function getDataCaseInsensitive(): array
    {
        return [
            ['abcABCdefDEF', 'C', 2],
            ['ABCabcABCabc', 'C', 5, 3]
        ];
    }

    /**
     * @dataProvider getDataCaseSensitive
     */
    public function testFindPositionCaseSensitive(
        Stringable|string $initial,
        Stringable|string $needle,
        int|bool $expected,
        int $offset = 0
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->findPosition($needle, $offset);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getDataCaseInsensitive
     */
    public function testFindPositionCaseInsensitive(
        Stringable|string $initial,
        Stringable|string $needle,
        int|bool $expected,
        int $offset = 0
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->findPosition($needle, $offset, SmartString::CASE_INSENSITIVE);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getDataCaseInsensitive
     */
    public function testStripos(
        Stringable|string $initial,
        Stringable|string $needle,
        int|bool $expected,
        int $offset = 0
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->stripos($needle, $offset);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getDataCaseSensitive
     */
    public function testStrpos(
        Stringable|string $initial,
        Stringable|string $needle,
        int|bool $expected,
        int $offset = 0
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->strpos($needle, $offset);
        $this->assertEquals($expected, $result);
    }
}
