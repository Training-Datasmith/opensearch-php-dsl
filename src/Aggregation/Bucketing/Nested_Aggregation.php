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
 * Class representing NestedAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-nested-aggregation.html
 */
class Nested_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    private string $path;
    public function __construct(string $name, string $path)
    {
        parent::__construct($name);
        $this->set_path($path);
    }
    public function get_path(): string
    {
        return $this->path;
    }
    public function set_path(string $path): self
    {
        $this->path = $path;
        return $this;
    }
    public function get_array(): array
    {
        return ['path' => $this->get_path()];
    }
    public function get_type(): string
    {
        return 'nested';
    }
}