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

/**
 * Represents Elasticsearch "match_phrase" query.
 *
 * @author Ron Rademaker
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
 */
class Match_Phrase_Query extends Match_Query
{
    public function get_type(): string
    {
        return 'match_phrase';
    }
}