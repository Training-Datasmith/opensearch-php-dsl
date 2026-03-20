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
 * Class representing geohash grid aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-geohashgrid-aggregation.html
 */
class Geo_Hash_Grid_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    private ?int $precision;
    private ?int $size;
    private ?int $shard_size;
    public function __construct(string $name, string $field, ?int $precision = null, ?int $size = null, ?int $shard_size = null)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_precision($precision);
        $this->set_size($size);
        $this->set_shard_size($shard_size);
    }
    public function get_precision(): ?int
    {
        return $this->precision;
    }
    public function set_precision(?int $precision): self
    {
        $this->precision = $precision;
        return $this;
    }
    public function get_size(): ?int
    {
        return $this->size;
    }
    public function set_size(?int $size): self
    {
        $this->size = $size;
        return $this;
    }
    public function get_shard_size(): ?int
    {
        return $this->shard_size;
    }
    public function set_shard_size(?int $shard_size): self
    {
        $this->shard_size = $shard_size;
        return $this;
    }
    public function get_array(): array
    {
        $data = ['field' => $this->get_field()];
        if ($this->get_precision()) {
            $data['precision'] = $this->get_precision();
        }
        if ($this->get_size()) {
            $data['size'] = $this->get_size();
        }
        if ($this->get_shard_size()) {
            $data['shard_size'] = $this->get_shard_size();
        }
        return $data;
    }
    public function get_type(): string
    {
        return 'geohash_grid';
    }
}