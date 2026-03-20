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
namespace Open_Search_Dsl\Aggregation;

use Open_Search_Dsl\Builder_Bag;
use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Name_Aware_Trait;
use Open_Search_Dsl\Named_Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * AbstractAggregation class.
 */
abstract class Abstract_Aggregation implements Named_Builder_Interface
{
    use Name_Aware_Trait;
    use Parameters_Trait;
    private ?string $field = null;
    private ?Builder_Bag $aggregations = null;
    abstract protected function supports_nesting(): bool;
    /**
     * @return array|\stdClass
     */
    abstract protected function get_array();
    public function __construct(string $name)
    {
        $this->set_name($name);
    }
    public function set_field(?string $field): self
    {
        $this->field = $field;
        return $this;
    }
    public function get_field(): ?string
    {
        return $this->field;
    }
    public function add_aggregation(self $abstract_aggregation): self
    {
        if (!$this->aggregations) {
            $this->aggregations = $this->create_builder_bag();
        }
        $this->aggregations->add($abstract_aggregation);
        return $this;
    }
    /**
     * @return BuilderInterface[]
     */
    public function get_aggregations()
    {
        if ($this->aggregations) {
            return $this->aggregations->all();
        }
        return [];
    }
    public function get_aggregation(string $name): ?Builder_Interface
    {
        if ($this->aggregations && $this->aggregations->has($name)) {
            return $this->aggregations->get($name);
        }
        return null;
    }
    public function to_array(): array
    {
        $array = $this->get_array();
        $result = [$this->get_type() => \is_array($array) ? $this->process_array($array) : $array];
        if ($this->supports_nesting()) {
            $nested_result = $this->collect_nested_aggregations();
            if (!empty($nested_result)) {
                $result['aggregations'] = $nested_result;
            }
        }
        return $result;
    }
    private function collect_nested_aggregations(): array
    {
        $result = [];
        /** @var AbstractAggregation $aggregation */
        foreach ($this->get_aggregations() as $aggregation) {
            $result[$aggregation->get_name()] = $aggregation->to_array();
        }
        return $result;
    }
    private function create_builder_bag(): Builder_Bag
    {
        return new Builder_Bag();
    }
}