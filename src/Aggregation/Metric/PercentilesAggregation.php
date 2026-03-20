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
 * Class representing PercentilesAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-percentile-aggregation.html
 */
class Percentiles_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    use Script_Aware_Trait;
    private ?array $percents;
    /**
     * @param string|array{id: string, params?: array<string, mixed>}|null $script
     */
    public function __construct(string $name, ?string $field = null, ?array $percents = null, $script = null)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_percents($percents);
        $this->set_script($script);
    }
    public function get_percents(): ?array
    {
        return $this->percents;
    }
    public function set_percents(?array $percents): self
    {
        $this->percents = $percents;
        return $this;
    }
    public function get_array(): array
    {
        $out = \array_filter(['percents' => $this->get_percents(), 'field' => $this->get_field(), 'script' => $this->get_script()], fn(string|array|null $val): bool => $val || \is_numeric($val));
        $this->is_required_parameters_set($out);
        return $out;
    }
    public function get_type(): string
    {
        return 'percentiles';
    }
    private function is_required_parameters_set(array $out): void
    {
        if (\array_key_exists('field', $out) || \array_key_exists('script', $out)) {
            return;
        }
        throw new \LogicException('Percentiles aggregation must have field or script set.');
    }
}