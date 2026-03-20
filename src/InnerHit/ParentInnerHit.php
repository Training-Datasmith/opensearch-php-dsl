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
namespace Open_Search_Dsl\Inner_Hit;

/**
 * Represents Elasticsearch top level parent inner hits.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-inner-hits.html
 */
class Parent_Inner_Hit extends Abstract_Inner_Hit
{
    public const TYPE = 'parent';
    public function get_type(): string
    {
        return self::TYPE;
    }
}