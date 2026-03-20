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
namespace Open_Search_Dsl\Query\Span;

use Open_Search_Dsl\Query\Term_Level\Term_Query;
/**
 * Elasticsearch span_term query class.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-term-query.html
 */
class Span_Term_Query extends Term_Query implements Span_Query_Interface
{
    public function get_type(): string
    {
        return 'span_term';
    }
}