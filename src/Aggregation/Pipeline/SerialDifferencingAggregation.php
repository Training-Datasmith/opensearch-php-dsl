<?php

declare (strict_types=1);
/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Open_Search_Dsl\Aggregation\Pipeline;

/**
 * Class representing Serial Differencing Pipeline Aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-serialdiff-aggregation.html
 */
class Serial_Differencing_Aggregation extends Abstract_Pipeline_Aggregation
{
    public function get_type(): string
    {
        return 'serial_diff';
    }
}