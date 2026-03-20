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
use Open_Search_Dsl\Script_Aware_Trait;
/**
 * Class representing StatsAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-stats-aggregation.html
 */
class Stats_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    use Script_Aware_Trait;
    /**
     * @param string|array{id: string, params?: array<string, mixed>}|null $script
     */
    public function __construct(string $name, ?string $field = null, $script = null)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_script($script);
    }
    public function get_array(): array
    {
        $out = [];
        if ($this->get_field()) {
            $out['field'] = $this->get_field();
        }
        if ($this->get_script()) {
            $out['script'] = $this->get_script();
        }
        return $out;
    }
    public function get_type(): string
    {
        return 'stats';
    }
}