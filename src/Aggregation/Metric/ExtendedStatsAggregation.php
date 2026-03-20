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
 * Class representing Extended stats aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-extendedstats-aggregation.html
 */
class Extended_Stats_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    use Script_Aware_Trait;
    /**
     * @param string|array{id: string, params?: array<string, mixed>}|null $script
     */
    public function __construct(string $name, ?string $field = null, ?int $sigma = null, $script = null)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_sigma($sigma);
        $this->set_script($script);
    }
    private ?int $sigma;
    public function get_sigma(): ?int
    {
        return $this->sigma;
    }
    public function set_sigma(?int $sigma): self
    {
        $this->sigma = $sigma;
        return $this;
    }
    public function get_array(): array
    {
        return \array_filter(['field' => $this->get_field(), 'script' => $this->get_script(), 'sigma' => $this->get_sigma()], static fn(string|int|array|null $val): bool => $val || \is_numeric($val));
    }
    public function get_type(): string
    {
        return 'extended_stats';
    }
}