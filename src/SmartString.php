<?php

declare(strict_types=1);

namespace Navarr\SmartString;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;
use Stringable;

use function grapheme_stripos;
use function grapheme_stristr;
use function grapheme_strlen;
use function grapheme_strpos;
use function grapheme_strripos;
use function grapheme_strrpos;
use function grapheme_strstr;
use function grapheme_substr;
use function stripos;
use function stristr;
use function strlen;
use function strpos;
use function strripos;
use function strrpos;
use function strstr;
use function substr;

#[Immutable]
class SmartString implements Stringable
{
    public const CASE_INSENSITIVE = 1;

    private function __construct(private readonly string $value, private readonly bool $shouldUseGrapheme)
    {
    }

    #[Pure]
    public static function build(Stringable|string $value): SmartString
    {
        $value = (string)$value;
        $multiCharacter = grapheme_strlen($value) !== strlen($value);
        return new SmartString($value, $multiCharacter);
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->value;
    }

    #[Pure]
    public function stripos(Stringable|string $needle, int $offset = 0): int|false
    {
        $needle = (string)$needle;
        return match ($this->shouldUseGrapheme) {
            true => grapheme_stripos($this->value, $needle, $offset),
            false => stripos($this->value, $needle, $offset)
        };
    }

    #[Pure]
    public function stristr(Stringable|string $needle, bool $beforeNeedle = false): SmartString|false
    {
        $needle = (string)$needle;
        $value = match ($this->shouldUseGrapheme) {
            true => grapheme_stristr($this->value, $needle, $beforeNeedle),
            false => stristr($this->value, $needle, $beforeNeedle),
        };
        return is_string($value) ? static::build($value) : false;
    }

    #[Pure]
    public function strripos(Stringable|string $needle, int $offset = 0): int|false
    {
        $needle = (string)$needle;
        return match ($this->shouldUseGrapheme) {
            true => grapheme_strripos($this->value, $needle, $offset),
            false => strripos($this->value, $needle, $offset),
        };
    }

    #[Pure]
    public function strrpos(Stringable|string $needle, int $offset = 0): int|false
    {
        $needle = (string)$needle;
        return match ($this->shouldUseGrapheme) {
            true => grapheme_strrpos($this->value, $needle, $offset),
            false => strrpos($this->value, $needle, $offset),
        };
    }

    #[Pure]
    public function findLastPosition(Stringable|string $needle, int $offset = 0, int $flags = 0): int|false
    {
        if (($flags & self::CASE_INSENSITIVE) == self::CASE_INSENSITIVE) {
            return $this->strripos($needle, $offset);
        }
        return $this->strrpos($needle, $offset);
    }

    #[Pure]
    public function substr(int $offset, ?int $length = null): SmartString|false
    {
        $value = match ($this->shouldUseGrapheme) {
            true => grapheme_substr($this->value, $offset, $length),
            false => substr($this->value, $offset, $length),
        };
        return is_string($value) ? static::build($value) : $value;
    }

    #[Pure]
    public function substring(int $offset, ?int $length = null): SmartString|false
    {
        return $this->substr($offset, $length);
    }

    #[Pure]
    public function strpos(Stringable|string $needle, int $offset = 0): int|false
    {
        $needle = (string)$needle;
        return match ($this->shouldUseGrapheme) {
            true => grapheme_strpos($this->value, $needle, $offset),
            false => strpos($this->value, $needle, $offset),
        };
    }

    #[Pure]
    public function findPosition(Stringable|string $needle, int $offset = 0, int $flags = 0): int|false
    {
        if (($flags & self::CASE_INSENSITIVE) == self::CASE_INSENSITIVE) {
            return $this->stripos($needle, $offset);
        }
        return $this->strpos($needle, $offset);
    }

    #[Pure]
    public function strstr(Stringable|string $needle, bool $beforeNeedle = false): SmartString|false
    {
        $needle = (string)$needle;
        $result = match ($this->shouldUseGrapheme) {
            true => grapheme_strstr($this->value, $needle, $beforeNeedle),
            false => strstr($this->value, $needle, $beforeNeedle),
        };
        return is_string($result) ? static::build($result) : $result;
    }

    #[Pure]
    public function substringFromNeedle(
        Stringable|string $needle,
        int $flags = 0
    ): SmartString|false {
        if (($flags & static::CASE_INSENSITIVE) == static::CASE_INSENSITIVE) {
            return $this->stristr($needle);
        }
        return $this->strstr($needle);
    }

    #[Pure]
    public function substringUntilNeedle(
        Stringable|string $needle,
        int $flags = 0
    ): SmartString|false {
        if (($flags & self::CASE_INSENSITIVE) == self::CASE_INSENSITIVE) {
            return $this->stristr($needle, true);
        }
        return $this->strstr($needle, true);
    }

    #[Pure]
    public function strlen(): int|false|null
    {
        return match ($this->shouldUseGrapheme) {
            true => grapheme_strlen($this->value),
            false => strlen($this->value),
        };
    }

    #[Pure]
    public function length(): int|false|null
    {
        return $this->strlen();
    }

    #[Pure]
    public function concatenate(Stringable|string $additionalValue): SmartString
    {
        return $this->concat($additionalValue);
    }

    #[Pure]
    public function concat(Stringable|string $additionalValue): SmartString
    {
        if ($this->shouldUseGrapheme) {
            // If we're already multibyte characters, then the result of a concatenation will be too
            return new SmartString($this . $additionalValue, $this->shouldUseGrapheme);
        }
        return static::build($this . $additionalValue);
    }
}
