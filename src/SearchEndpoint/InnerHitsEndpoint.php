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

use Open_Search_Dsl\Inner_Hit\Nested_Inner_Hit;
/**
 * Search inner hits dsl endpoint.
 */
class Inner_Hits_Endpoint extends Abstract_Search_Endpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'inner_hits';
    public function normalize(): ?array
    {
        $output = [];
        /** @var NestedInnerHit $innerHit */
        foreach ($this->get_all() as $inner_hit) {
            $output[$inner_hit->get_name()] = $inner_hit->to_array();
        }
        return $output;
    }
}