<?php

/*
 * This file is part of the Runalyze Age Grade.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\AgeGrade\Tests\Table;

use Runalyze\AgeGrade\Tests\Table\Fixtures\VerySimpleTable;

class AbstractTableTest extends \PHPUnit_Framework_TestCase
{
    /** @var VerySimpleTable */
    protected $Table;

    public function setUp()
    {
        $this->Table = new VerySimpleTable();
    }

    public function testAvailableDistances()
    {
        $this->assertEquals([5.0, 10.0], $this->Table->getAvailableDistances());
    }

    public function testOpenStandard()
    {
        $this->assertEquals([780.0, 1600.0], $this->Table->getOpenStandard());
    }

    public function testAvailableAgeRange()
    {
        $this->assertEquals([30, 32], $this->Table->getAvailableAgeRange());
    }

    public function testMinimalDistance()
    {
        $this->assertEquals(5.0, $this->Table->getMinimalDistance());
    }

    public function testAgeStandardAsDefined()
    {
        $this->assertEquals(780 / 0.9, $this->Table->getAgeStandard(30, 5.0));
        $this->assertEquals(780 / 1.0, $this->Table->getAgeStandard(31, 5.0));
        $this->assertEquals(780 / 0.9, $this->Table->getAgeStandard(32, 5.0));
        $this->assertEquals(1600 / 0.8, $this->Table->getAgeStandard(30, 10.0));
        $this->assertEquals(1600 / 0.9, $this->Table->getAgeStandard(31, 10.0));
        $this->assertEquals(1600 / 1.0, $this->Table->getAgeStandard(32, 10.0));
    }

    public function testInterpolatedAgeStandard()
    {
        $this->assertEquals((0.8 * 780 + 0.2 * 1600) / 0.88, $this->Table->getAgeStandard(30, 6));
        $this->assertEquals((0.5 * 780 + 0.5 * 1600) / 0.85, $this->Table->getAgeStandard(30, 7.5));
        $this->assertEquals((0.4 * 780 + 0.6 * 1600) / 0.96, $this->Table->getAgeStandard(32, 8));
    }

    public function testAgeStandardOutOfBounds()
    {
        $this->assertEquals(780 / 0.9, $this->Table->getAgeStandard(20, 5.0));
        $this->assertEquals(1600 / 0.8, $this->Table->getAgeStandard(20, 10.0));
        $this->assertEquals(780 / 0.9, $this->Table->getAgeStandard(35, 5.0));
        $this->assertEquals(1600 / 1.0, $this->Table->getAgeStandard(35, 10.0));
    }

    public function testAgePerformance()
    {
        $this->assertEquals(0.625, $this->Table->getAgePerformance(30, 10.0, 3200));
        $this->assertEquals(1.000, $this->Table->getAgePerformance(31, 10.0, 1600 / 0.9));
        $this->assertEquals(0.500, $this->Table->getAgePerformance(32, 10.0, 3200));
    }

    public function testAgeGrade()
    {
        $ageGrade = $this->Table->getAgeGrade(30, 10.0, 4000);

        $this->assertEquals(0.5, $ageGrade->getPerformance());
        $this->assertEquals(10.0, $ageGrade->getOriginalDistance());
        $this->assertEquals(4000, $ageGrade->getOriginalTimeInSeconds());
        $this->assertEquals(1600, $ageGrade->getOpenStandard());
        $this->assertEquals(1600 / 0.8, $ageGrade->getAgeStandard());
        $this->assertEquals(0.8, $ageGrade->getAgeFactor());
    }
}
