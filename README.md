# Age Grade

[![Latest Stable Version](https://img.shields.io/packagist/v/runalyze/age-grade.svg)](https://packagist.org/packages/runalyze/age-grade)
[![Build Status](https://travis-ci.org/Runalyze/age-grade.svg?branch=master)](https://travis-ci.org/Runalyze/age-grade)
[![Code Coverage](https://scrutinizer-ci.com/g/Runalyze/age-grade/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Runalyze/age-grade/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Runalyze/age-grade/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Runalyze/age-grade/?branch=master)
[![MIT License](https://img.shields.io/github/license/twbs/bootlint.svg)](https://github.com/Runalyze/age-grade/blob/master/LICENSE)

Library to provide age grading for race results (running) based on tables provided by
[Alan Jones](http://www.runscore.com/Alan/AgeGrade.html) using standards by
WMA ([World Masters Athletics](http://www.world-masters-athletics.org/)) and
USATF ([USA Track and Field](http://www.usatf.org/)).

## Usage

```php
use Runalyze\AgeGrade\Lookup;
use Runalyze\AgeGrade\Table\MaleTable;

$Lookup = new Lookup(new MaleTable(), 54);
echo $Lookup->getAgeGrade(10.0, 42 * 60 + 25); // output: 0.7329
```

Internally, `getAgeGrade()` returns an `AgeGrade` object that will return the rounded age grade value when transformed to a string.
You can fetch more details by respective methods:

```php
$Lookup = new Lookup(new MaleTable(), 54);
$AgeGrade = $Lookup->getAgeGrade(10.0, 42 * 60 + 25);
$AgeGrade->getPerformance(); // returns 0.7329
$AgeGrade->getAgeStandard(); // returns 1865
$AgeGrade->getOpenStandard(); // returns 1603
$AgeGrade->getAgeFactor(); // returns 0.8594
```

## License

 * Code released under [the MIT license](LICENSE).
 * Tables are licensed under [Creative Commons Attribution 4.0 International License](http://creativecommons.org/licenses/by/4.0/).
 * All Masters standards/factors are as approved by the WMA Vice President - Non Stadia, WMA President, and USATF MLDR Committee.
