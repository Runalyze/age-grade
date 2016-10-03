<?php

/*
 * This file is part of the Runalyze Age Grade.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\AgeGrade;

class Level
{
    /** @var int */
    const UNCLASSIFIED = 0;

    /** @var int */
    const LOCAL_CLASS = 1;

    /** @var int */
    const REGIONAL_CLASS = 2;

    /** @var int */
    const NATIONAL_CLASS = 3;

    /** @var int */
    const WORLD_CLASS = 4;

    /** @var int */
    const WORLD_RECORD_CLASS = 5;

    /** @var array */
    protected $Limits = [0.0, 0.6, 0.7, 0.8, 0.9, 1.0];

    /** @var int */
    protected $Class = 0;

    /**
     * @param float $ageGrade
     */
    public function __construct($ageGrade = 0.0)
    {
        $this->setFromAgeGrade($ageGrade);
    }

    /**
     * @param  float $ageGrade in [0.0 .. 1.0]
     * @return int
     */
    public function setFromAgeGrade($ageGrade)
    {
        foreach (array_reverse($this->Limits, true) as $class => $lowerLimit) {
            if ($ageGrade >= $lowerLimit) {
                $this->Class = $class;
                break;
            }
        }

        return $this->Class;
    }

    /**
     * @return int
     */
    public function getClass()
    {
        return $this->Class;
    }
}
