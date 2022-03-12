<?php

namespace Navarr\SmartString\Test;

use Navarr\SmartString\SmartString;
use Navarr\SmartString\SmartStringFactory;
use PHPUnit\Framework\TestCase;
use Stringable;

class SubstringUntilNeedleTest extends TestCase
{
    private SmartStringFactory $factory;

    private function getDataCaseInsensitive(): array
    {
        return [
            ['abcdefg', 'c', 'ab'],
            ['abcdefg', SmartString::build('c'), 'ab'],
            ['abcABCdefDEF', 'C', 'ab'],
            ['abcABCdefDEF', SmartString::build('C'), 'ab'],
            ['abcdefg', 'h', false],
            ['abcdefg', SmartString::build('h'), false],
            ['abcdefg', '🏴', false],
            ['abcdefg', SmartString::build('🏴'), false],
            ['ab🏴defg', '🏴', 'ab'],
            ['ab🏴defg', SmartString::build('🏴'), 'ab'],
        ];
    }

    private function getDataCaseSensitive(): array
    {
        return [
            ['abcABCdefDEF', 'C', 'abcAB'],
            ['abcABCdefDEF', SmartString::build('C'), 'abcAB'],
            ['abcABCdefDEF', 'c', 'ab'],
            ['abcABCdefDEF', SmartString::build('c'), 'ab'],
            ['abcABCdefDEF', 'h', false],
            ['abcABCdefDEF', SmartString::build('h'), false],
            ['abcABCdefDEF', 'H', false],
            ['abcABCdefDEF', SmartString::build('H'), false],
            ['abcABCdefDEF', '🏴', false],
            ['abcABCdefDEF', SmartString::build('🏴'), false],
            ['abcABC🏴defDEF', '🏴', 'abcABC'],
            ['abcABC🏴defDEF', SmartString::build('🏴'), 'abcABC'],
        ];
    }

    public function setUp(): void
    {
        $this->factory = new SmartStringFactory();
    }

    /**
     * @dataProvider getDataCaseInsensitive
     */
    public function testStristrWithBeforeNeedleTrue(
        Stringable|string $initial,
        Stringable|string $substring,
        string|false $expected
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->stristr($substring, true);

        if (is_string($expected)) {
            $this->assertInstanceOf(SmartString::class, $result);
            $result = (string)$result;
        }
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getDataCaseSensitive
     */
    public function testStrstrWithBeforeNeedleTrue(
        Stringable|string $initial,
        Stringable|string $substring,
        string|false $expected
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->strstr($substring, true);

        if (is_string($expected)) {
            $this->assertInstanceOf(SmartString::class, $result);
            $result = (string)$result;
        }
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getDataCaseInsensitive
     */
    public function testSubstringUntilNeedleCaseInsensitive(
        Stringable|string $initial,
        Stringable|string $substring,
        string|false $expected
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->substringUntilNeedle($substring, SmartString::CASE_INSENSITIVE);

        if (is_string($expected)) {
            $this->assertInstanceOf(SmartString::class, $result);
            $result = (string)$result;
        }
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getDataCaseSensitive
     */
    public function testSubstringUntilNeedleCaseSensitive(
        Stringable|string $initial,
        Stringable|string $substring,
        string|false $expected
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->substringUntilNeedle($substring);

        if (is_string($expected)) {
            $this->assertInstanceOf(SmartString::class, $result);
            $result = (string)$result;
        }
        $this->assertEquals($expected, $result);
    }
}
