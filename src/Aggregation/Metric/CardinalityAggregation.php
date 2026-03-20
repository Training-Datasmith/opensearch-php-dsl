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
 * Difference values counter.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-cardinality-aggregation.html
 */
class Cardinality_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    use Script_Aware_Trait;
    private ?int $precision_threshold = null;
    private ?bool $rehash = null;
    public function get_array(): array
    {
        return \array_filter(['field' => $this->get_field(), 'script' => $this->get_script(), 'precision_threshold' => $this->get_precision_threshold(), 'rehash' => $this->is_rehash()], static fn(string|int|bool|array|null $val): bool => $val || \is_bool($val));
    }
    public function get_precision_threshold(): ?int
    {
        return $this->precision_threshold;
    }
    public function set_precision_threshold(?int $precision): self
    {
        $this->precision_threshold = $precision;
        return $this;
    }
    public function is_rehash(): ?bool
    {
        return $this->rehash;
    }
    public function set_rehash(?bool $rehash): self
    {
        $this->rehash = $rehash;
        return $this;
    }
    public function get_type(): string
    {
        return 'cardinality';
    }
}