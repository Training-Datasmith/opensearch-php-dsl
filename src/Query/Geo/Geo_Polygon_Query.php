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
namespace Open_Search_Dsl\Query\Geo;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * Represents Elasticsearch "geo_polygon" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-polygon-query.html
 */
class Geo_Polygon_Query implements Builder_Interface
{
    use Parameters_Trait;
    public function __construct(private string $field, private array $points = [], array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function get_type(): string
    {
        return 'geo_polygon';
    }
    public function to_array(): array
    {
        $query = [$this->field => ['points' => $this->points]];
        $output = $this->process_array($query);
        return [$this->get_type() => $output];
    }
}