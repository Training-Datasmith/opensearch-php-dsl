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
 * Factory for search endpoints.
 */
class Search_Endpoint_Factory
{
    /**
     * @var array holds namespaces for endpoints
     */
    private static array $endpoints = ['query' => Query_Endpoint::class, 'post_filter' => Post_Filter_Endpoint::class, 'sort' => Sort_Endpoint::class, 'highlight' => Highlight_Endpoint::class, 'aggregations' => Aggregations_Endpoint::class, 'suggest' => Suggest_Endpoint::class, 'inner_hits' => Inner_Hits_Endpoint::class, 'collapse' => Collapse_Endpoint::class];
    /**
     * Returns a search endpoint instance.
     *
     * @param string $type type of endpoint
     *
     * @return AbstractSearchEndpoint
     *
     * @throws \RuntimeException endpoint does not exist
     */
    public static function get($type)
    {
        if (!array_key_exists($type, self::$endpoints)) {
            throw new \RuntimeException('Endpoint does not exist.');
        }
        return new self::$endpoints[$type]();
    }
}