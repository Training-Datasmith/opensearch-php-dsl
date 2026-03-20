<?php

declare (strict_types=1);
namespace Open_Search_Dsl\Type;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-query.html
 */
class Location implements Type_Interface
{
    public function __construct(private float $lat, private float $lon)
    {
    }
    public function get_lat(): float
    {
        return $this->lat;
    }
    public function set_lat(float $lat): self
    {
        $this->lat = $lat;
        return $this;
    }
    public function get_lon(): float
    {
        return $this->lon;
    }
    public function set_lon(float $lon): self
    {
        $this->lon = $lon;
        return $this;
    }
    public function to_array(): array
    {
        return ['lat' => $this->get_lat(), 'lon' => $this->get_lon()];
    }
}