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

use Runalyze\AgeGrade\Table\FemaleTable;

class FemaleTableTest extends \PHPUnit\Framework\TestCase
{
    /** @var FemaleTable */
    protected $Table;

    public function setUp(): void
    {
        $this->Table = new FemaleTable();
    }

    public function testSomeValues()
    {
        $this->assertEquals(0.9595, round($this->Table->getAgePerformance(15, 5.0, 16 * 60 + 10), 4));
        $this->assertEquals(0.7745, round($this->Table->getAgePerformance(27, 10.0, 39 * 60 + 10), 4));
        $this->assertEquals(0.8581, round($this->Table->getAgePerformance(42, 42.2, 2 * 60 * 60 + 45 * 60 + 0), 4));
        $this->assertEquals(0.4296, round($this->Table->getAgePerformance(54, 10.0, 1 * 60 * 60 + 23 * 60 + 45), 4));
    }

    public function testSomeOpenStandardValues()
    {
        $this->assertEquals(6.92, $this->Table->getAgeStandard(25, 0.06));
        $this->assertEquals(501.42, $this->Table->getAgeStandard(25, 3.0));
        $this->assertEquals(8125.0, $this->Table->getAgeStandard(25, 42.195));
        $this->assertEquals(57600.0, $this->Table->getAgeStandard(25, 200.0));
    }

    public function testConsistency()
    {
        $this->assertSameSize(
            $this->Table->getOpenStandard(),
            $this->Table->getAvailableDistances()
        );
    }
}
