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
namespace Open_Search_Dsl\Query\Full_Text;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * Represents Elasticsearch "multi_match" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-multi-match-query.html
 *
 * Allows `$fields` to be an empty array to represent 'no fields'. From the Elasticsearch documentation:
 *
 * If no fields are provided, the multi_match query defaults to the `index.query.default_field` index settings,
 * which in turn defaults to `*`. `*` extracts all fields in the mapping that are eligible to term queries and filters
 * the metadata fields. All extracted fields are then combined to build a query.
 */
class Multi_Match_Query implements Builder_Interface
{
    use Parameters_Trait;
    /**
     * @param string|int|float $query
     */
    public function __construct(private array $fields, private $query, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function to_array(): array
    {
        $query = ['query' => $this->query];
        if (count($this->fields)) {
            $query['fields'] = $this->fields;
        }
        $output = $this->process_array($query);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'multi_match';
    }
}