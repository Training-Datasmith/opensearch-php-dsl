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
 * Class representing date range aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-daterange-aggregation.html
 */
class Date_Range_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    private ?string $format;
    private array $ranges = [];
    private bool $keyed = false;
    public function __construct(string $name, string $field, ?string $format = null, array $ranges = [], bool $keyed = false)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_format($format);
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
    public function get_format(): ?string
    {
        return $this->format;
    }
    public function set_format(?string $format): self
    {
        $this->format = $format;
        return $this;
    }
    public function add_range(?string $from = null, ?string $to = null, ?string $key = null): self
    {
        $range = array_filter(['from' => $from, 'to' => $to, 'key' => $key], static fn(?string $v): bool => null !== $v);
        if (empty($range)) {
            throw new \LogicException('Either from or to must be set. Both cannot be null.');
        }
        $this->ranges[] = $range;
        return $this;
    }
    public function get_array(): array
    {
        if (empty($this->ranges)) {
            throw new \LogicException('Date range aggregation must have field and range added.');
        }
        $data = ['field' => $this->get_field(), 'ranges' => $this->ranges, 'keyed' => $this->keyed];
        if ($this->get_format()) {
            $data['format'] = $this->get_format();
        }
        return $data;
    }
    public function get_type(): string
    {
        return 'date_range';
    }
}