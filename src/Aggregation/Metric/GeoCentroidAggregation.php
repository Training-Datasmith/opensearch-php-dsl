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
 * Class representing geo centroid aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-geocentroid-aggregation.html
 */
class Geo_Centroid_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    public function __construct(string $name, string $field)
    {
        parent::__construct($name);
        $this->set_field($field);
    }
    public function get_array(): array
    {
        return ['field' => $this->get_field()];
    }
    public function get_type(): string
    {
        return 'geo_centroid';
    }
}