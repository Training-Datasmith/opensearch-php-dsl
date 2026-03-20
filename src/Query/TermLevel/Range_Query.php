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
namespace Open_Search_Dsl\Query\Term_Level;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * Represents Elasticsearch "range" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-range-query.html
 */
class Range_Query implements Builder_Interface
{
    use Parameters_Trait;
    /**
     * Range control names.
     */
    public const LT = 'lt';
    public const GT = 'gt';
    public const LTE = 'lte';
    public const GTE = 'gte';
    public function __construct(private string $field, array $parameters = [])
    {
        $this->set_parameters($parameters);
        if ($this->has_parameter(self::GTE) && $this->has_parameter(self::GT)) {
            throw new \LogicException('Range query cannot have "gte" and "gt" parameters');
        }
        if ($this->has_parameter(self::LTE) && $this->has_parameter(self::LT)) {
            throw new \LogicException('Range query cannot have "lte" and "lt" parameters');
        }
    }
    public function to_array(): array
    {
        $output = [$this->field => $this->get_parameters()];
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'range';
    }
}