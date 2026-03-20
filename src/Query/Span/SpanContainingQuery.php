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
 * Elasticsearch span containing query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-containing-query.html
 */
class Span_Containing_Query implements Span_Query_Interface
{
    use Parameters_Trait;
    private Span_Query_Interface $little;
    private Span_Query_Interface $big;
    public function __construct(Span_Query_Interface $little, Span_Query_Interface $big)
    {
        $this->set_little($little);
        $this->set_big($big);
    }
    public function get_little(): Span_Query_Interface
    {
        return $this->little;
    }
    public function set_little(Span_Query_Interface $little): self
    {
        $this->little = $little;
        return $this;
    }
    public function get_big(): Span_Query_Interface
    {
        return $this->big;
    }
    public function set_big(Span_Query_Interface $big): self
    {
        $this->big = $big;
        return $this;
    }
    public function to_array(): array
    {
        $output = ['little' => $this->get_little()->to_array(), 'big' => $this->get_big()->to_array()];
        $output = $this->process_array($output);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'span_containing';
    }
}