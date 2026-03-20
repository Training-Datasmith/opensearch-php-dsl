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
 * Elasticsearch span or query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-or-query.html
 */
class Span_Or_Query implements Span_Query_Interface
{
    use Parameters_Trait;
    public function __construct(private array $queries, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function add_query(Span_Query_Interface $query): self
    {
        $this->queries[] = $query;
        return $this;
    }
    /**
     * @return SpanQueryInterface[]
     */
    public function get_queries(): array
    {
        return $this->queries;
    }
    public function to_array(): array
    {
        $query = [];
        foreach ($this->queries as $type) {
            $query['clauses'][] = $type->to_array();
        }
        $output = $this->process_array($query);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'span_or';
    }
}