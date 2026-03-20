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
namespace Open_Search_Dsl\Query\Span;

use Open_Search_Dsl\Parameters_Trait;
/**
 * Elasticsearch span first query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-first-query.html
 */
class Span_First_Query implements Span_Query_Interface
{
    use Parameters_Trait;
    public function __construct(private Span_Query_Interface $query, private int $end, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function to_array(): array
    {
        $query = [];
        $query['match'] = $this->query->to_array();
        $query['end'] = $this->end;
        $output = $this->process_array($query);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'span_first';
    }
}