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
namespace Open_Search_Dsl\Aggregation\Pipeline;

/**
 * Class representing Percentiles Bucket Pipeline Aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-percentiles-bucket-aggregation.html
 */
class Percentiles_Bucket_Aggregation extends Abstract_Pipeline_Aggregation
{
    private array $percents = [];
    public function get_percents(): array
    {
        return $this->percents;
    }
    public function set_percents(array $percents): self
    {
        $this->percents = $percents;
        return $this;
    }
    public function get_array(): array
    {
        $data = ['buckets_path' => $this->get_buckets_path()];
        if ($this->get_percents()) {
            $data['percents'] = $this->get_percents();
        }
        return $data;
    }
    public function get_type(): string
    {
        return 'percentiles_bucket';
    }
}