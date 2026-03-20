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
 * Class representing geo diversified sampler aggregation.
 *
 * @see https://goo.gl/yzXvqD
 */
class Diversified_Sampler_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    private ?int $shard_size;
    public function __construct(string $name, string $field, ?int $shard_size = null)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_shard_size($shard_size);
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
    protected function get_array(): array
    {
        return \array_filter(['field' => $this->get_field(), 'shard_size' => $this->get_shard_size()]);
    }
    public function get_type(): string
    {
        return 'diversified_sampler';
    }
}