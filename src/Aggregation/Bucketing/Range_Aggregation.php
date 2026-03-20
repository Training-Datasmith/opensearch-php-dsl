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
 * Class representing RangeAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-range-aggregation.html
 */
class Range_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    private array $ranges = [];
    private bool $keyed = false;
    public function __construct(string $name, ?string $field = null, array $ranges = [], bool $keyed = false)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_keyed($keyed);
        foreach ($ranges as $range) {
            $from = $range['from'] ?? null;
            $to = $range['to'] ?? null;
            $key = $range['key'] ?? null;
            $this->add_range($from, $to, $key);
        }
    }
    public function set_keyed(bool $keyed): self
    {
        $this->keyed = $keyed;
        return $this;
    }
    public function add_range(?float $from = null, ?float $to = null, ?string $key = ''): self
    {
        $range = array_filter(['from' => $from, 'to' => $to], static fn(?float $v): bool => null !== $v);
        if ($key) {
            $range['key'] = $key;
        }
        $this->ranges[] = $range;
        return $this;
    }
    public function remove_range(?float $from, ?float $to): bool
    {
        foreach ($this->ranges as $key => $range) {
            if (\array_diff_assoc(\array_filter(['from' => $from, 'to' => $to]), $range) === []) {
                unset($this->ranges[$key]);
                return true;
            }
        }
        return false;
    }
    public function remove_range_by_key(string $key): bool
    {
        if ($this->keyed) {
            foreach ($this->ranges as $range_key => $range) {
                if (\array_key_exists('key', $range) && $range['key'] === $key) {
                    unset($this->ranges[$range_key]);
                    return true;
                }
            }
        }
        return false;
    }
    public function get_array(): array
    {
        $data = ['keyed' => $this->keyed, 'ranges' => \array_values($this->ranges)];
        if ($this->get_field()) {
            $data['field'] = $this->get_field();
        }
        return $data;
    }
    public function get_type(): string
    {
        return 'range';
    }
}