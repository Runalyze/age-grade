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

use Runalyze\AgeGrade\Lookup;
use Runalyze\AgeGrade\Table\FemaleTable;
use Runalyze\AgeGrade\Table\MaleTable;

class LookupTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidAge()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        new Lookup(new MaleTable(), 'foo');
    }

    public function testThatAgeIsRespected()
    {
        $this->assertNotEquals(
            (new Lookup(new MaleTable(), 30))->getAgePerformance(10.0, 40 * 60),
            (new Lookup(new MaleTable(), 60))->getAgePerformance(10.0, 40 * 60)
        );
    }

    public function testWithYearsAgo()
    {
        $this->assertNotEquals(
            (new Lookup(new MaleTable(), 60))->getAgePerformance(10.0, 40 * 60, 30),
            (new Lookup(new MaleTable(), 60))->getAgePerformance(10.0, 40 * 60)
        );
    }

    public function testThatTableIsRespected()
    {
        $this->assertNotEquals(
            (new Lookup(new MaleTable(), 30))->getAgePerformance(10.0, 40 * 60),
            (new Lookup(new FemaleTable(), 30))->getAgePerformance(10.0, 40 * 60)
        );
    }

    public function testThatPerformanceEqualsValueFromAgeGrade()
    {
        $this->assertEquals(
            (new Lookup(new MaleTable(), 30))->getAgePerformance(10.0, 40 * 60),
            (new Lookup(new MaleTable(), 30))->getAgeGrade(10.0, 40 * 60)->getPerformance()
        );
    }
}
