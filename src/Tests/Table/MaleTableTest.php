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

use Runalyze\AgeGrade\Table\MaleTable;

class MaleTableTest extends \PHPUnit_Framework_TestCase
{
    /** @var MaleTable */
    protected $Table;

    public function setUp()
    {
        $this->Table = new MaleTable();
    }

    public function testSomeValues()
    {
        $this->assertEquals(0.8312, round($this->Table->getAgePerformance(15, 5.0, 16 * 60 + 10), 4));
        $this->assertEquals(0.7633, round($this->Table->getAgePerformance(27, 10.0, 35 * 60 + 0), 4));
        $this->assertEquals(0.8555, round($this->Table->getAgePerformance(42, 42.2, 2 * 60 * 60 + 29 * 60 + 59), 4));
        $this->assertEquals(0.7329, round($this->Table->getAgePerformance(54, 10.0, 42 * 60 + 25), 4));
    }

    public function testSomeOpenStandardValues()
    {
        $this->assertEquals(6.39, $this->Table->getAgeStandard(25, 0.06));
        $this->assertEquals(440.67, $this->Table->getAgeStandard(25, 3.0));
        $this->assertEquals(7377.0, $this->Table->getAgeStandard(25, 42.195));
        $this->assertEquals(52800.0, $this->Table->getAgeStandard(25, 200.0));
    }

    public function testConsistency()
    {
        $this->assertEquals(
            count($this->Table->getOpenStandard()),
            count($this->Table->getAvailableDistances())
        );
    }
}
