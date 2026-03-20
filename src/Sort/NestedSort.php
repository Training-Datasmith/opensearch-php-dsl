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
 * Represents Elasticsearch "nested" sort filter.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/filter-dsl-nested-filter.html
 */
class Nested_Sort implements Builder_Interface
{
    use Parameters_Trait;
    public function __construct(private string $path, private ?Builder_Interface $filter = null, private ?Builder_Interface $nested_filter = null, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function get_path(): string
    {
        return $this->path;
    }
    public function get_filter(): ?Builder_Interface
    {
        return $this->filter;
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
        $output = ['path' => $this->path];
        if ($this->filter) {
            $output['filter'] = $this->filter->to_array();
        }
        if ($this->nested_filter) {
            $output[$this->get_type()] = $this->nested_filter->to_array();
        }
        return $this->process_array($output);
    }
    public function get_type(): string
    {
        return 'nested';
    }
}