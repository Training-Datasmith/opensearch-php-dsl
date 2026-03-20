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
 * Elasticsearch Span not query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-not-query.html
 */
class Span_Not_Query implements Span_Query_Interface
{
    use Parameters_Trait;
    public function __construct(private Span_Query_Interface $include, private Span_Query_Interface $exclude, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function to_array(): array
    {
        $query = ['include' => $this->include->to_array(), 'exclude' => $this->exclude->to_array()];
        return [$this->get_type() => $this->process_array($query)];
    }
    public function get_type(): string
    {
        return 'span_not';
    }
}