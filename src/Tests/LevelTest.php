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

use Runalyze\AgeGrade\Level;

class LevelTest extends \PHPUnit\Framework\TestCase
{
    public function testEmptyConstructor()
    {
        $level = new Level();

        $this->assertEquals(Level::UNCLASSIFIED, $level->getClass());
    }

    public function testNotEmptyConstructor()
    {
        $level = new Level(0.76);

        $this->assertEquals(Level::REGIONAL_CLASS, $level->getClass());
    }

    public function testAllLevels()
    {
        $level = new Level();

        $this->assertEquals(Level::WORLD_RECORD_CLASS, $level->setFromAgeGrade(1.00));
        $this->assertEquals(Level::WORLD_CLASS, $level->setFromAgeGrade(0.92));
        $this->assertEquals(Level::NATIONAL_CLASS, $level->setFromAgeGrade(0.81));
        $this->assertEquals(Level::REGIONAL_CLASS, $level->setFromAgeGrade(0.70));
        $this->assertEquals(Level::LOCAL_CLASS, $level->setFromAgeGrade(0.69));
        $this->assertEquals(Level::UNCLASSIFIED, $level->setFromAgeGrade(0.54));
    }
}
