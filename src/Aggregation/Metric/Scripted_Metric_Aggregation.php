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
namespace Open_Search_Dsl\Aggregation\Metric;

use Open_Search_Dsl\Aggregation\Abstract_Aggregation;
use Open_Search_Dsl\Aggregation\Type\Metric_Trait;
/**
 * Class representing ScriptedMetricAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-scripted-metric-aggregation.html
 */
class Scripted_Metric_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    private ?string $init_script;
    private ?string $map_script;
    private ?string $combine_script;
    private ?string $reduce_script;
    public function __construct(string $name, ?string $init_script = null, ?string $map_script = null, ?string $combine_script = null, ?string $reduce_script = null)
    {
        parent::__construct($name);
        $this->set_init_script($init_script);
        $this->set_map_script($map_script);
        $this->set_combine_script($combine_script);
        $this->set_reduce_script($reduce_script);
    }
    public function get_init_script(): ?string
    {
        return $this->init_script;
    }
    public function set_init_script(?string $init_script): self
    {
        $this->init_script = $init_script;
        return $this;
    }
    public function get_map_script(): ?string
    {
        return $this->map_script;
    }
    public function set_map_script(?string $map_script): self
    {
        $this->map_script = $map_script;
        return $this;
    }
    public function get_combine_script(): ?string
    {
        return $this->combine_script;
    }
    public function set_combine_script(?string $combine_script): self
    {
        $this->combine_script = $combine_script;
        return $this;
    }
    public function get_reduce_script(): ?string
    {
        return $this->reduce_script;
    }
    public function set_reduce_script(?string $reduce_script): self
    {
        $this->reduce_script = $reduce_script;
        return $this;
    }
    public function get_array(): array
    {
        return array_filter(['init_script' => $this->get_init_script(), 'map_script' => $this->get_map_script(), 'combine_script' => $this->get_combine_script(), 'reduce_script' => $this->get_reduce_script()]);
    }
    public function get_type(): string
    {
        return 'scripted_metric';
    }
}