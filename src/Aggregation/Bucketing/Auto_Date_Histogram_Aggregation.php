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
 * Class representing AutoDateHistogramAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-autodatehistogram-aggregation.html
 */
class Auto_Date_Histogram_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    public function __construct(string $name, string $field, ?int $buckets = null, ?string $format = null)
    {
        parent::__construct($name);
        $this->set_field($field);
        if ($buckets) {
            $this->add_parameter('buckets', $buckets);
        }
        if ($format) {
            $this->add_parameter('format', $format);
        }
    }
    public function get_array(): array
    {
        return array_filter(['field' => $this->get_field()]);
    }
    public function get_type(): string
    {
        return 'auto_date_histogram';
    }
}