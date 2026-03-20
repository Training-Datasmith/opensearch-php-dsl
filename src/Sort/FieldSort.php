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
namespace Open_Search_Dsl\Sort;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * Holds all the values required for basic sorting.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/sort-search-results.html
 */
class Field_Sort implements Builder_Interface
{
    use Parameters_Trait;
    public const ASC = 'asc';
    public const DESC = 'desc';
    public function __construct(private string $field, private ?string $order = null, private ?Builder_Interface $nested_filter = null, array $parameters = [])
    {
        $this->set_parameters($parameters);
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
    public function get_order(): ?string
    {
        return $this->order;
    }
    public function set_order(?string $order): self
    {
        $this->order = $order;
        return $this;
    }
    public function get_nested_filter(): ?Builder_Interface
    {
        return $this->nested_filter;
    }
    public function set_nested_filter(?Builder_Interface $nested_filter): self
    {
        $this->nested_filter = $nested_filter;
        return $this;
    }
    public function to_array(): array
    {
        if ($this->order) {
            $this->add_parameter('order', $this->order);
        }
        if ($this->nested_filter) {
            $this->add_parameter('nested', $this->nested_filter->to_array());
        }
        return [$this->field => $this->get_parameters()];
    }
    public function get_type(): string
    {
        return 'sort';
    }
}