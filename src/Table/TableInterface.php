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

interface TableInterface
{
    /**
     * @return array distances with exact age standards [km]
     */
    public function getAvailableDistances();

    /**
     * @return array [from, to] in [years]
     */
    public function getAvailableAgeRange();

    /**
     * @param  int   $age      [years]
     * @param  float $distance [km]
     * @return int   age standard by WMA [s]
     */
    public function getAgeStandard($age, $distance);

    /**
     * @param  int   $age           [years]
     * @param  float $distance      [km]
     * @param  int   $timeInSeconds [s]
     * @return float age grade in [0.0 .. 1.0]
     */
    public function getAgePerformance($age, $distance, $timeInSeconds);

    /**
     * @param  int      $age           [years]
     * @param  float    $distance      [km]
     * @param  int      $timeInSeconds [s]
     * @return AgeGrade
     */
    public function getAgeGrade($age, $distance, $timeInSeconds);
}
