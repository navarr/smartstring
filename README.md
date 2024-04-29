# Fast, Appropriate String Manipulation

SmartString is a library that automatically determines whether a string of text can use PHP's byte manipulation tools, or if it needs to be upgraded to use Grapheme manipulations - allowing you to process text as quickly and as accurately as possible.

## Installation

    composer require navarr/smartstring

## Usage

```php
use Navarr\SmartString\SmartStringFactory;
use Navarr\SmartString\SmartString;

// Factory Methodology
$factory = new SmartStringFactory();
$example = $factory->create('🏴󠁧󠁢󠁥󠁮󠁧󠁿');
echo $example->strlen(); // 1

// Singleton Methodology
$example = SmartString::build('Test');
echo $example->strlen(); // 4
```
