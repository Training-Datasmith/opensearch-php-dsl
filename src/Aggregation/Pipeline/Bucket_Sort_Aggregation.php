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

use Open_Search_Dsl\Sort\Field_Sort;
/**
 * Class representing Bucket Script Pipeline Aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-bucket-sort-aggregation.html
 */
class Bucket_Sort_Aggregation extends Abstract_Pipeline_Aggregation
{
    private array $sort = [];
    public function __construct(string $name, ?string $buckets_path = null)
    {
        parent::__construct($name, $buckets_path);
    }
    public function get_sort(): array
    {
        return $this->sort;
    }
    public function set_sort(array $sort): self
    {
        $this->sort = $sort;
        return $this;
    }
    public function add_sort(Field_Sort $sort): self
    {
        $this->sort[] = $sort->to_array();
        return $this;
    }
    public function get_array(): array
    {
        return \array_filter(['buckets_path' => $this->get_buckets_path(), 'sort' => $this->get_sort()]);
    }
    public function get_type(): string
    {
        return 'bucket_sort';
    }
}