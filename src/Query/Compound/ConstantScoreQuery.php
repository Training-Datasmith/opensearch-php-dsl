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
 * Represents Elasticsearch "constant_score" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-constant-score-query.html
 */
class Constant_Score_Query implements Builder_Interface
{
    use Parameters_Trait;
    public function __construct(private Builder_Interface $query, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function to_array(): array
    {
        $query = ['filter' => $this->query->to_array()];
        $output = $this->process_array($query);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'constant_score';
    }
}