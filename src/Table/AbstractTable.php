<?php

/*
 * This file is part of the Runalyze Age Grade.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\AgeGrade\Table;

use Runalyze\AgeGrade\AgeGrade;

/**
 * Classes extending AbstractTable must provide correctly sized $OpenStandard and $AgeFactors.
 */
abstract class AbstractTable implements TableInterface
{
    /** @var int */
    protected $NumDistances;

    /** @var int */
    protected $NumAges;

    /** @var float[] available distances [km] */
    protected $Distances = [];

    /** @var int[] available ages [from, to] in [years] */
    protected $AgeRange = [5, 100];

    /** @var float[] open standard times for all available distances in [s] */
    protected $OpenStandard = [];

    /** @var float[] for each age an array with factors for all available distances in [0.0 .. 1.0] */
    protected $AgeFactors = [];

    public function __construct()
    {
        $this->NumDistances = count($this->Distances);
        $this->NumAges = 1 + $this->AgeRange[1] - $this->AgeRange[0];
    }

    /**
     * @return array distances with exact age standards [km]
     */
    public function getAvailableDistances()
    {
        return $this->Distances;
    }

    /**
     * @return float[] open standard times for all available distances in [s]
     */
    public function getOpenStandard()
    {
        return $this->OpenStandard;
    }

    /**
     * @return array [from, to] in [years]
     */
    public function getAvailableAgeRange()
    {
        return $this->AgeRange;
    }

    /**
     * @return float [km]
     */
    public function getMinimalDistance()
    {
        return $this->Distances[0];
    }

    /**
     * @param  int       $age           [years]
     * @param  float     $distance      [km]
     * @param  int|float $timeInSeconds [s]
     * @return float     age grade in [0.0 .. 1.0]
     */
    public function getAgePerformance($age, $distance, $timeInSeconds)
    {
        return $this->getAgeStandard($age, $distance) / $timeInSeconds;
    }

    /**
     * @param  int       $age           [years]
     * @param  float     $distance      [km]
     * @param  int|float $timeInSeconds [s]
     * @return AgeGrade
     */
    public function getAgeGrade($age, $distance, $timeInSeconds)
    {
        $ageStandard = $this->getAgeStandard($age, $distance);
        $ageFactor = $this->getAgeFactor($age, $distance);

        $ageGrade = new AgeGrade($ageStandard / $timeInSeconds);
        $ageGrade->setOriginalResult($distance, $timeInSeconds);
        $ageGrade->setTableData($ageStandard, $ageFactor);

        return $ageGrade;
    }

    /**
     * @param  int       $age      [years]
     * @param  float     $distance [km]
     * @return int|float age standard by WMA [s]
     */
    public function getAgeStandard($age, $distance)
    {
        list($distanceIndex, $fraction) = $this->getDistanceIndexWithFraction($distance);
        $ageFactor = $this->getAgeFactor($age, $distance);

        if (1.0 === $fraction) {
            return $this->OpenStandard[$distanceIndex] / $ageFactor;
        }

        return ((1 - $fraction) * $this->OpenStandard[$distanceIndex - 1] + $fraction * $this->OpenStandard[$distanceIndex]) / $ageFactor;
    }

    /**
     * @param  int   $age      [years]
     * @param  float $distance [km]
     * @return float age grade factor in [0.0 .. 1.0]
     */
    protected function getAgeFactor($age, $distance)
    {
        $ageIndex = $this->getAgeIndex($age);
        list($distanceIndex, $fraction) = $this->getDistanceIndexWithFraction($distance);

        if ($distance <= $this->Distances[0] || $distance >= $this->Distances[$this->NumDistances - 1]) {
            return $this->AgeFactors[$ageIndex][$distanceIndex];
        }

        return (1 - $fraction) * $this->AgeFactors[$ageIndex][$distanceIndex - 1] + $fraction * $this->AgeFactors[$ageIndex][$distanceIndex];
    }

    /**
     * @param  int $age [years]
     * @return int age index for internal table
     */
    protected function getAgeIndex($age)
    {
        list($min, $max) = $this->AgeRange;

        if ($age < $min) {
            $age = $min;
        } elseif ($age > $max) {
            $age = $max;
        }

        return (int) $age - $min;
    }

    /**
     * @param  float $distance [km]
     * @return array [index, fraction] distance index for internal table
     *                        fraction belongs to the returned index, (1 - fraction) to (index - 1)
     */
    protected function getDistanceIndexWithFraction($distance)
    {
        if ($distance <= $this->Distances[0]) {
            return [0, 1.0];
        }

        if ($distance >= $this->Distances[$this->NumDistances - 1]) {
            return [$this->NumDistances - 1, 1.0];
        }

        for ($i = 0; $i < $this->NumDistances; ++$i) {
            if ($this->Distances[$i] >= $distance) {
                break;
            }
        }

        $i = min($i, $this->NumDistances - 1);
        $fraction = ($distance - $this->Distances[$i - 1]) / ($this->Distances[$i] - $this->Distances[$i - 1]);

        return [$i, $fraction];
    }
}
