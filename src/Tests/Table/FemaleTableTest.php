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

class FemaleTableTest extends \PHPUnit_Framework_TestCase
{
    /** @var FemaleTable */
    protected $Table;

    public function setUp()
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
}
