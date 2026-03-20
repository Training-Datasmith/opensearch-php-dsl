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
namespace Open_Search_Dsl\Query\Compound;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * Represents Elasticsearch "dis_max" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-dis-max-query.html
 */
class Dis_Max_Query implements Builder_Interface
{
    use Parameters_Trait;
    /**
     * @var BuilderInterface[]
     */
    private array $queries = [];
    public function __construct(array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function add_query(Builder_Interface $query): self
    {
        $this->queries[] = $query;
        return $this;
    }
    public function to_array(): array
    {
        $query = [];
        foreach ($this->queries as $type) {
            $query[] = $type->to_array();
        }
        $output = $this->process_array(['queries' => $query]);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'dis_max';
    }
}