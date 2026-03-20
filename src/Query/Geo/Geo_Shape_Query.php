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
 * Represents Elasticsearch "geo_shape" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-shape-query.html
 */
class Geo_Shape_Query implements Builder_Interface
{
    use Parameters_Trait;
    public const INTERSECTS = 'intersects';
    public const DISJOINT = 'disjoint';
    public const WITHIN = 'within';
    public const CONTAINS = 'contains';
    /*
     * Available shape types for addShape() $type param.
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/geo-shape.html#input-structure
     */
    public const SHAPE_TYPE_POINT = 'point';
    public const SHAPE_TYPE_LINESTRING = 'linestring';
    public const SHAPE_TYPE_POLYGON = 'polygon';
    public const SHAPE_TYPE_MULTIPOINT = 'multipoint';
    public const SHAPE_TYPE_MULTILINESTRING = 'multilinestring';
    public const SHAPE_TYPE_MULTIPOLYGON = 'multipolygon';
    public const SHAPE_TYPE_GEOMETRYCOLLECTION = 'geometrycollection';
    public const SHAPE_TYPE_ENVELOPE = 'envelope';
    public const SHAPE_TYPE_CIRCLE = 'circle';
    private array $fields = [];
    public function __construct(array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    /**
     * Add geo-shape provided filter.
     *
     * @param string $field field name
     * @param string $type shape type
     * @param array $coordinates shape coordinates
     * @param string $relation spatial relation
     * @param array $parameters additional parameters
     */
    public function add_shape(string $field, string $type, array $coordinates, string $relation = self::INTERSECTS, array $parameters = []): void
    {
        $filter = array_merge($parameters, ['type' => $type, 'coordinates' => $coordinates]);
        $this->fields[$field] = ['shape' => $filter, 'relation' => $relation];
    }
    public function add_pre_indexed_shape(string $field, string $id, string $type, string $index, string $path, string $relation = self::INTERSECTS, array $parameters = []): void
    {
        $filter = array_merge($parameters, ['id' => $id, 'type' => $type, 'index' => $index, 'path' => $path]);
        $this->fields[$field] = ['indexed_shape' => $filter, 'relation' => $relation];
    }
    public function to_array(): array
    {
        $output = $this->process_array($this->fields);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'geo_shape';
    }
}