<?php

namespace Navarr\SmartString\Test;

use Navarr\SmartString\SmartString;
use Navarr\SmartString\SmartStringFactory;
use PHPUnit\Framework\TestCase;
use Stringable;

class SubstringFromNeedleTest extends TestCase
{
    private SmartStringFactory $factory;

    public function setUp(): void
    {
        $this->factory = new SmartStringFactory();
        parent::setUp();
    }

    private function getDataCaseInsensitive(): array
    {
        return [
            ['abcdefg', 'c', 'cdefg'],
            ['abcdefg', SmartString::build('c'), 'cdefg'],
            ['abcABCdefDEF', 'C', 'cABCdefDEF'],
            ['abcABCdefDEF', SmartString::build('C'), 'cABCdefDEF'],
            ['abcdefg', 'h', false],
            ['abcdefg', SmartString::build('h'), false],
            ['abcdefg', '🏴', false],
            ['abcdefg', SmartString::build('🏴'), false],
            ['ab🏴defg', '🏴', '🏴defg'],
            ['ab🏴defg', SmartString::build('🏴'), '🏴defg'],
        ];
    }

    private function getDataCaseSensitive(): array
    {
        return [
            ['abcABCdefDEF', 'C', 'CdefDEF'],
            ['abcABCdefDEF', SmartString::build('C'), 'CdefDEF'],
            ['abcABCdefDEF', 'c', 'cABCdefDEF'],
            ['abcABCdefDEF', SmartString::build('c'), 'cABCdefDEF'],
            ['abcABCdefDEF', 'h', false],
            ['abcABCdefDEF', SmartString::build('h'), false],
            ['abcABCdefDEF', 'H', false],
            ['abcABCdefDEF', SmartString::build('H'), false],
            ['abcABCdefDEF', '🏴', false],
            ['abcABCdefDEF', SmartString::build('🏴'), false],
            ['abcABC🏴defDEF', '🏴', '🏴defDEF'],
            ['abcABC🏴defDEF', SmartString::build('🏴'), '🏴defDEF'],
        ];
    }

    /**
     * @dataProvider getDataCaseSensitive
     */
    public function testSubstringFromNeedleCaseSensitive(
        Stringable|string $initial,
        Stringable|string $substring,
        string|false $expected
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->substringFromNeedle($substring);

        if (is_string($expected)) {
            $this->assertInstanceOf(SmartString::class, $result);
            $result = (string)$result;
        }
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getDataCaseSensitive
     */
    public function testStrstrWithBeforeNeedleFalse(
        Stringable|string $initial,
        Stringable|string $substring,
        string|false $expected
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->strstr($substring);

        if (is_string($expected)) {
            $this->assertInstanceOf(SmartString::class, $result);
            $result = (string)$result;
        }
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getDataCaseInsensitive
     */
    public function testSubstringFromNeedleCaseInsensitive(
        Stringable|string $initial,
        Stringable|string $substring,
        string|false $expected
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->substringFromNeedle($substring, SmartString::CASE_INSENSITIVE);

        if (is_string($expected)) {
            $this->assertInstanceOf(SmartString::class, $result);
            $result = (string)$result;
        }
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getDataCaseInsensitive
     */
    public function testStristrWithBeforeNeedleFalse(
        Stringable|string $initial,
        Stringable|string $substring,
        string|false $expected
    ): void {
        $object = $this->factory->create($initial);
        $result = $object->stristr($substring);

        if (is_string($expected)) {
            $this->assertInstanceOf(SmartString::class, $result);
            $result = (string)$result;
        }
        $this->assertEquals($expected, $result);
    }
}
