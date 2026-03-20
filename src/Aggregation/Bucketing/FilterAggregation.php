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
 * Class representing FilterAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-filter-aggregation.html
 */
class Filter_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    protected Builder_Interface $filter;
    public function __construct(string $name, Builder_Interface $filter)
    {
        parent::__construct($name);
        $this->set_filter($filter);
    }
    public function set_filter(Builder_Interface $filter): self
    {
        $this->filter = $filter;
        return $this;
    }
    public function get_filter(): Builder_Interface
    {
        return $this->filter;
    }
    public function set_field(?string $field): self
    {
        throw new \LogicException("Filter aggregation, doesn't support `field` parameter");
    }
    public function get_array(): array
    {
        return $this->get_filter()->to_array();
    }
    public function get_type(): string
    {
        return 'filter';
    }
}