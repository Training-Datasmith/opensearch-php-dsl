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
 * Class representing Histogram aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-histogram-aggregation.html
 */
class Histogram_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    public const DIRECTION_ASC = 'asc';
    public const DIRECTION_DESC = 'desc';
    protected int $interval;
    protected ?int $min_doc_count;
    protected ?array $extended_bounds;
    protected ?string $order_mode;
    protected ?string $order_direction;
    protected ?bool $keyed;
    public function __construct(string $name, string $field, ?int $interval = null, ?int $min_doc_count = null, ?string $order_mode = null, ?string $order_direction = self::DIRECTION_ASC, ?int $extended_bounds_min = null, ?int $extended_bounds_max = null, ?bool $keyed = null)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_interval($interval);
        $this->set_min_doc_count($min_doc_count);
        $this->set_order($order_mode, $order_direction);
        $this->set_extended_bounds($extended_bounds_min, $extended_bounds_max);
        $this->set_keyed($keyed);
    }
    public function is_keyed(): ?bool
    {
        return $this->keyed;
    }
    public function set_keyed(?bool $keyed): self
    {
        $this->keyed = $keyed;
        return $this;
    }
    public function set_order(?string $mode, ?string $direction = self::DIRECTION_ASC): self
    {
        $this->order_mode = $mode;
        $this->order_direction = $direction;
        return $this;
    }
    public function get_order(): ?array
    {
        if ($this->order_mode && $this->order_direction) {
            return [$this->order_mode => $this->order_direction];
        }
        return null;
    }
    public function get_interval(): int
    {
        return $this->interval;
    }
    public function set_interval(int $interval): self
    {
        $this->interval = $interval;
        return $this;
    }
    public function get_min_doc_count(): ?int
    {
        return $this->min_doc_count;
    }
    public function set_min_doc_count(?int $min_doc_count): self
    {
        $this->min_doc_count = $min_doc_count;
        return $this;
    }
    public function get_extended_bounds(): array
    {
        return $this->extended_bounds;
    }
    public function set_extended_bounds(?int $min = null, ?int $max = null): self
    {
        $bounds = \array_filter(['min' => $min, 'max' => $max]);
        $this->extended_bounds = $bounds;
        return $this;
    }
    public function get_array(): array
    {
        return \array_filter(['field' => $this->get_field(), 'interval' => $this->get_interval(), 'min_doc_count' => $this->get_min_doc_count(), 'extended_bounds' => $this->get_extended_bounds(), 'keyed' => $this->is_keyed(), 'order' => $this->get_order()], static fn(string|int|bool|array|null $val): bool => $val || \is_numeric($val));
    }
    public function get_type(): string
    {
        return 'histogram';
    }
}