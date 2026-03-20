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
 * Represents Elasticsearch "geo_bounding_box" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-bounding-box-query.html
 */
class Geo_Bounding_Box_Query implements Builder_Interface
{
    use Parameters_Trait;
    public function __construct(private string $field, private array $values, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function to_array(): array
    {
        return [$this->get_type() => $this->process_array([$this->field => $this->points()])];
    }
    public function get_type(): string
    {
        return 'geo_bounding_box';
    }
    private function points(): array
    {
        if (count($this->values) === 2) {
            return ['top_left' => $this->values['top_left'], 'bottom_right' => $this->values['bottom_right']];
        }
        if (count($this->values) === 4) {
            return ['top' => $this->values['top'], 'left' => $this->values['left'], 'bottom' => $this->values['bottom'], 'right' => $this->values['right']];
        }
        throw new \LogicException('Geo Bounding Box filter must have 2 or 4 geo points set.');
    }
}