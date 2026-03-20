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
/**
 * Represents Elasticsearch "exists" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-exists-query.html
 */
class Exists_Query implements Builder_Interface
{
    public function __construct(private string $field)
    {
    }
    public function to_array(): array
    {
        return [$this->get_type() => ['field' => $this->field]];
    }
    public function get_type(): string
    {
        return 'exists';
    }
}