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
namespace Open_Search_Dsl\Aggregation\Bucketing;

use Open_Search_Dsl\Aggregation\Abstract_Aggregation;
use Open_Search_Dsl\Aggregation\Type\Bucketing_Trait;
/**
 * Class representing GlobalAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-global-aggregation.html
 */
class Global_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    public function set_field(?string $field): self
    {
        throw new \LogicException("Global aggregation, doesn't support `field` parameter");
    }
    public function get_array(): \stdClass
    {
        return new \stdClass();
    }
    public function get_type(): string
    {
        return 'global';
    }
}