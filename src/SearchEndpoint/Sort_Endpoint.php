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

/**
 * Search sort dsl endpoint.
 */
class Sort_Endpoint extends Abstract_Search_Endpoint
{
    public const NAME = 'sort';
    public function normalize(): ?array
    {
        $output = [];
        foreach ($this->get_all() as $sort) {
            $output[] = $sort->to_array();
        }
        return $output;
    }
}