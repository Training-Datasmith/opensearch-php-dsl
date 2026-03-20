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
 * Class representing Percentile Ranks Aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-percentile-rank-aggregation.html
 */
class Percentile_Ranks_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    use Script_Aware_Trait;
    private array $values;
    /**
     * @param string|array{id: string, params?: array<string, mixed>}|null $script
     */
    public function __construct(string $name, ?string $field, array $values = [], $script = null)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_values($values);
        $this->set_script($script);
    }
    public function get_values(): array
    {
        return $this->values;
    }
    public function set_values(array $values): self
    {
        $this->values = $values;
        return $this;
    }
    public function get_array(): array
    {
        $out = \array_filter(['field' => $this->get_field(), 'script' => $this->get_script(), 'values' => $this->get_values()], static fn(string|array|null $val): bool => $val || \is_numeric($val));
        $this->is_required_parameters_set($out);
        return $out;
    }
    public function get_type(): string
    {
        return 'percentile_ranks';
    }
    private function is_required_parameters_set(array $out): void
    {
        if (\array_key_exists('values', $out)) {
            if (\array_key_exists('field', $out)) {
                return;
            }
            if (\array_key_exists('script', $out)) {
                return;
            }
        }
        throw new \LogicException('Percentile ranks aggregation must have field and values or script and values set.');
    }
}