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
/**
 * Class representing ChildrenAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-children-aggregation.html
 */
class Children_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    private string $children;
    public function __construct(string $name, string $children)
    {
        parent::__construct($name);
        $this->set_children($children);
    }
    public function get_children(): string
    {
        return $this->children;
    }
    public function set_children(string $children): self
    {
        $this->children = $children;
        return $this;
    }
    public function get_array(): array
    {
        if (count($this->get_aggregations()) === 0) {
            throw new \LogicException("Children aggregation `{$this->get_name()}` has no aggregations added");
        }
        return ['type' => $this->get_children()];
    }
    public function get_type(): string
    {
        return 'children';
    }
}