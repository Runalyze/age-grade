<?php

/*
 * This file is part of the Runalyze Age Grade.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\AgeGrade\Tests;

use Runalyze\AgeGrade\AgeGrade;
use Runalyze\AgeGrade\Level;

class AgeGradeTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidPerformance()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        new AgeGrade('foo');
    }

    public function testPerformanceOnly()
    {
        $ageGrade = new AgeGrade(0.42);

        $this->assertEquals(0.42, $ageGrade->getPerformance());
        $this->assertEquals('0.4200', $ageGrade->__toString());

        $this->assertNull($ageGrade->getOriginalDistance());
        $this->assertNull($ageGrade->getOriginalTimeInSeconds());
        $this->assertNull($ageGrade->getAgeStandard());
        $this->assertNull($ageGrade->getOpenStandard());
        $this->assertNull($ageGrade->getAgeFactor());

        $this->assertInstanceOf(Level::class, $ageGrade->getLevel());
        $this->assertEquals(Level::UNCLASSIFIED, $ageGrade->getLevel()->getClass());
    }

    public function testOriginalRaceData()
    {
        $ageGrade = new AgeGrade(0.765);
        $ageGrade->setOriginalResult(10.0, 39 * 60 + 12);

        $this->assertEquals(10.0, $ageGrade->getOriginalDistance());
        $this->assertEquals(39 * 60 + 12, $ageGrade->getOriginalTimeInSeconds());
    }

    public function testTableData()
    {
        $ageGrade = new AgeGrade(0.8);
        $ageGrade->setTableData(1000, 0.9);

        $this->assertEquals(1000, $ageGrade->getAgeStandard());
        $this->assertEquals(900, $ageGrade->getOpenStandard());
        $this->assertEquals(0.9, $ageGrade->getAgeFactor());
    }
}
