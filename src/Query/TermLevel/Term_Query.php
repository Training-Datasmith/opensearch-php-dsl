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
 * Represents Elasticsearch "term" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-term-query.html
 */
class Term_Query implements Builder_Interface
{
    use Parameters_Trait;
    /**
     * @param string|int|float|bool $value
     */
    public function __construct(private string $field, private $value, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function to_array(): array
    {
        $query = $this->process_array();
        if (empty($query)) {
            $query = $this->value;
        } else {
            $query['value'] = $this->value;
        }
        $output = [$this->field => $query];
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'term';
    }
}