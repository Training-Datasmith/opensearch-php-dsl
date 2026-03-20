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
/**
 * Class representing geo bounds aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-geobounds-aggregation.html
 */
class Geo_Bounds_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    private bool $wrap_longitude = true;
    public function __construct(string $name, string $field, bool $wrap_longitude = true)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_wrap_longitude($wrap_longitude);
    }
    public function is_wrap_longitude(): bool
    {
        return $this->wrap_longitude;
    }
    public function set_wrap_longitude(bool $wrap_longitude): self
    {
        $this->wrap_longitude = $wrap_longitude;
        return $this;
    }
    public function get_array(): array
    {
        $data = [];
        $data['field'] = $this->get_field();
        $data['wrap_longitude'] = $this->is_wrap_longitude();
        return $data;
    }
    public function get_type(): string
    {
        return 'geo_bounds';
    }
}