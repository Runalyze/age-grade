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

class AgeGrade
{
    /** @var float */
    protected $Performance;

    /** @var null|float [km] */
    protected $OriginalDistance = null;

    /** @var null|int [s] */
    protected $OriginalTimeInSeconds = null;

    /** @var null|int [s] */
    protected $AgeStandard = null;

    /** @var null|int [s] */
    protected $OpenStandard = null;

    /** @var null|float */
    protected $AgeFactor = null;

    /**
     * @param float $performance
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($performance)
    {
        if (!is_numeric($performance)) {
            throw new \InvalidArgumentException('Provided performance must be numerical.');
        }

        $this->Performance = (float) $performance;
    }

    /**
     * @return string age grade performance with 4 decimals precision
     */
    public function __toString()
    {
        return number_format($this->Performance, 4);
    }

    /**
     * @param  float $distance      [km]
     * @param  int   $timeInSeconds [s]
     * @return $this
     */
    public function setOriginalResult($distance, $timeInSeconds)
    {
        $this->OriginalDistance = $distance;
        $this->OriginalTimeInSeconds = $timeInSeconds;

        return $this;
    }

    /**
     * @param  int   $ageStandard [s]
     * @param  float $ageFactor
     * @return $this
     */
    public function setTableData($ageStandard, $ageFactor)
    {
        $this->AgeStandard = (int) round($ageStandard);
        $this->OpenStandard = (int) round($ageStandard * $ageFactor);
        $this->AgeFactor = $ageFactor;

        return $this;
    }

    /**
     * @return float
     */
    public function getPerformance()
    {
        return $this->Performance;
    }

    /**
     * @return float|null [km]
     */
    public function getOriginalDistance()
    {
        return $this->OriginalDistance;
    }

    /**
     * @return int|null [s]
     */
    public function getOriginalTimeInSeconds()
    {
        return $this->OriginalTimeInSeconds;
    }

    /**
     * @return int|null [s]
     */
    public function getAgeStandard()
    {
        return $this->AgeStandard;
    }

    /**
     * @return int|null [s]
     */
    public function getOpenStandard()
    {
        return $this->OpenStandard;
    }

    /**
     * @return float|null
     */
    public function getAgeFactor()
    {
        return $this->AgeFactor;
    }

    /**
     * @return Level
     */
    public function getLevel()
    {
        return new Level($this->Performance);
    }
}
