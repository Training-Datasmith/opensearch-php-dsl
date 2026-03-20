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
namespace Open_Search_Dsl\Search_Endpoint;

use Open_Search_Dsl\Aggregation\Abstract_Aggregation;
/**
 * Search aggregations dsl endpoint.
 */
class Aggregations_Endpoint extends Abstract_Search_Endpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'aggregations';
    public function normalize(): ?array
    {
        $output = [];
        /** @var AbstractAggregation $aggregation */
        foreach ($this->get_all() as $aggregation) {
            $output[$aggregation->get_name()] = $aggregation->to_array();
        }
        return $output;
    }
}