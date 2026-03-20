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
namespace Open_Search_Dsl\Query\Compound;

use Open_Search_Dsl\Builder_Interface;
/**
 * Represents Elasticsearch "boosting" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-boosting-query.html
 */
class Boosting_Query implements Builder_Interface
{
    public function __construct(private Builder_Interface $positive, private Builder_Interface $negative, private float $negative_boost)
    {
    }
    public function to_array(): array
    {
        $query = ['positive' => $this->positive->to_array(), 'negative' => $this->negative->to_array(), 'negative_boost' => $this->negative_boost];
        return [$this->get_type() => $query];
    }
    public function get_type(): string
    {
        return 'boosting';
    }
}