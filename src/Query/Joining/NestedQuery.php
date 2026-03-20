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
namespace Open_Search_Dsl\Query\Joining;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * Represents Elasticsearch "nested" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-nested-query.html
 */
class Nested_Query implements Builder_Interface
{
    use Parameters_Trait;
    public function __construct(private string $path, private Builder_Interface $query, array $parameters = [])
    {
        $this->parameters = $parameters;
    }
    public function get_query(): Builder_Interface
    {
        return $this->query;
    }
    public function get_path(): string
    {
        return $this->path;
    }
    public function to_array(): array
    {
        return [$this->get_type() => $this->process_array(['path' => $this->get_path(), 'query' => $this->get_query()->to_array()])];
    }
    public function get_type(): string
    {
        return 'nested';
    }
}