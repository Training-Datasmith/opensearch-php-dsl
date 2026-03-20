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
 * Elasticsearch span within query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-field-masking-query.html
 */
class Field_Masking_Span_Query implements Span_Query_Interface
{
    use Parameters_Trait;
    private Span_Query_Interface $query;
    private string $field;
    public function __construct(string $field, Span_Query_Interface $query)
    {
        $this->set_query($query);
        $this->set_field($field);
    }
    public function get_query(): Span_Query_Interface
    {
        return $this->query;
    }
    public function set_query(Span_Query_Interface $query): self
    {
        $this->query = $query;
        return $this;
    }
    public function get_field(): string
    {
        return $this->field;
    }
    public function set_field(string $field): self
    {
        $this->field = $field;
        return $this;
    }
    public function to_array(): array
    {
        $output = ['query' => $this->get_query()->to_array(), 'field' => $this->get_field()];
        $output = $this->process_array($output);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'field_masking_span';
    }
}