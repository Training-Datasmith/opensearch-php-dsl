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
 * Class representing geo distance aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-geodistance-aggregation.html
 */
class Geo_Distance_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    private string $origin;
    private ?string $distance_type;
    private ?string $unit;
    private array $ranges = [];
    public function __construct(string $name, string $field, string $origin, array $ranges = [], ?string $unit = null, ?string $distance_type = null)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_origin($origin);
        foreach ($ranges as $range) {
            $from = $range['from'] ?? null;
            $to = $range['to'] ?? null;
            $this->add_range($from, $to);
        }
        $this->set_unit($unit);
        $this->set_distance_type($distance_type);
    }
    public function get_origin(): string
    {
        return $this->origin;
    }
    public function set_origin(string $origin): self
    {
        $this->origin = $origin;
        return $this;
    }
    public function get_distance_type(): ?string
    {
        return $this->distance_type;
    }
    public function set_distance_type(?string $distance_type): self
    {
        $this->distance_type = $distance_type;
        return $this;
    }
    public function get_unit(): ?string
    {
        return $this->unit;
    }
    public function set_unit(?string $unit): self
    {
        $this->unit = $unit;
        return $this;
    }
    public function add_range(?float $from = null, ?float $to = null): self
    {
        $range = array_filter(['from' => $from, 'to' => $to], static fn(?float $v): bool => null !== $v);
        if (empty($range)) {
            throw new \LogicException('Either from or to must be set. Both cannot be null.');
        }
        $this->ranges[] = $range;
        return $this;
    }
    public function get_array(): array
    {
        $data = ['field' => $this->get_field(), 'origin' => $this->get_origin()];
        if ($this->get_unit()) {
            $data['unit'] = $this->get_unit();
        }
        if ($this->get_distance_type()) {
            $data['distance_type'] = $this->get_distance_type();
        }
        $data['ranges'] = $this->ranges;
        return $data;
    }
    public function get_type(): string
    {
        return 'geo_distance';
    }
}