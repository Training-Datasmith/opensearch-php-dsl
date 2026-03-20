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

/**
 * Elasticsearch span near query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-near-query.html
 */
class Span_Near_Query extends Span_Or_Query implements Span_Query_Interface
{
    public function __construct(private ?int $slop = null, array $queries = [], array $parameters = [])
    {
        parent::__construct($queries, $parameters);
    }
    public function get_slop(): ?int
    {
        return $this->slop;
    }
    public function set_slop(?int $slop): self
    {
        $this->slop = $slop;
        return $this;
    }
    public function to_array(): array
    {
        $query = [];
        foreach ($this->get_queries() as $type) {
            $query['clauses'][] = $type->to_array();
        }
        if ($this->get_slop()) {
            $query['slop'] = $this->get_slop();
        }
        $output = $this->process_array($query);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'span_near';
    }
}