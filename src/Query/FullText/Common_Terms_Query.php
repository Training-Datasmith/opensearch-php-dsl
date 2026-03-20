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
 * Represents Elasticsearch "common" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-common-terms-query.html
 */
class Common_Terms_Query implements Builder_Interface
{
    use Parameters_Trait;
    public function __construct(private string $field, private string $query, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function to_array(): array
    {
        $query = ['query' => $this->query];
        $output = [$this->field => $this->process_array($query)];
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'common';
    }
}