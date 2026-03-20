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
namespace Open_Search_Dsl\Aggregation\Bucketing;

use Open_Search_Dsl\Aggregation\Abstract_Aggregation;
use Open_Search_Dsl\Aggregation\Type\Bucketing_Trait;
use Open_Search_Dsl\Builder_Interface;
/**
 * Class representing adjacency matrix aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-adjacency-matrix-aggregation.html
 */
class Adjacency_Matrix_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    public const FILTERS = 'filters';
    private array $filters = [self::FILTERS => []];
    public function __construct(string $name, array $filters = [])
    {
        parent::__construct($name);
        foreach ($filters as $filter_name => $filter) {
            $this->add_filter($filter_name, $filter);
        }
    }
    public function add_filter(string $name, Builder_Interface $filter): self
    {
        $this->filters[self::FILTERS][$name] = $filter->to_array();
        return $this;
    }
    public function get_array(): array
    {
        return $this->filters;
    }
    public function get_type(): string
    {
        return 'adjacency_matrix';
    }
}