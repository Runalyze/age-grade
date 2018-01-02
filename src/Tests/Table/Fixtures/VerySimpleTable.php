<?php

/*
 * This file is part of the Runalyze Age Grade.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\AgeGrade\Tests\Table\Fixtures;

use Runalyze\AgeGrade\Table\AbstractTable;

class VerySimpleTable extends AbstractTable
{
    /** @var array available distances [km] */
    protected $Distances = [
        5.0, 10.0,
    ];

    /** @var array available ages [from, to] in [years] */
    protected $AgeRange = [30, 32];

    /** @var array open standard times for all available distances in [s] */
    protected $OpenStandard = [
        780.0, 1600.0,
    ];

    /** @var array for each age an array with factors for all available distances in [0.0 .. 1.0] */
    protected $AgeFactors = [
        [0.9, 0.8],
        [1.0, 0.9],
        [0.9, 1.0],
    ];
}
