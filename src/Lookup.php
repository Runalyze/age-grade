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

use Runalyze\AgeGrade\Table\TableInterface;

class Lookup
{
    /** @var TableInterface */
    protected $Table;

    /** @var int [years] */
    protected $Age;

    /**
     * @param TableInterface $table
     * @param int            $age   [years]
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(TableInterface $table, $age)
    {
        if (!is_numeric($age) || $age <= 0) {
            throw new \InvalidArgumentException('Provided age must be numerical and positive.');
        }

        $this->Table = $table;
        $this->Age = (int) $age;
    }

    /**
     * @param  float $distance      [km]
     * @param  int   $timeInSeconds [s]
     * @return float
     */
    public function getAgePerformance($distance, $timeInSeconds)
    {
        return $this->Table->getAgePerformance($this->Age, $distance, $timeInSeconds);
    }

    /**
     * @param  float    $distance      [km]
     * @param  int      $timeInSeconds [s]
     * @return AgeGrade
     */
    public function getAgeGrade($distance, $timeInSeconds)
    {
        return $this->Table->getAgeGrade($this->Age, $distance, $timeInSeconds);
    }
}
