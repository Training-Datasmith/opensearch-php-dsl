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
 * Class representing filters aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-filters-aggregation.html
 */
class Filters_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    /**
     * @var BuilderInterface[]
     */
    private array $filters = [];
    private bool $anonymous = false;
    public function __construct(string $name, array $filters = [], bool $anonymous = false)
    {
        parent::__construct($name);
        $this->set_anonymous($anonymous);
        foreach ($filters as $filter_name => $filter) {
            $anonymous ? $this->add_filter($filter) : $this->add_filter($filter, $filter_name);
        }
    }
    public function set_anonymous(bool $anonymous): self
    {
        $this->anonymous = $anonymous;
        return $this;
    }
    public function add_filter(Builder_Interface $filter, string $name = ''): self
    {
        if (!$this->anonymous && !$name) {
            throw new \LogicException('In not anonymous filters, filter name must be set.');
        }
        if (!$this->anonymous && $name) {
            $this->filters['filters'][$name] = $filter->to_array();
        } else {
            $this->filters['filters'][] = $filter->to_array();
        }
        return $this;
    }
    public function get_array(): array
    {
        return $this->filters;
    }
    public function get_type(): string
    {
        return 'filters';
    }
}