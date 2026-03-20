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
 * Class representing ReverseNestedAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-reverse-nested-aggregation.html
 */
class Reverse_Nested_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    private ?string $path;
    public function __construct(string $name, ?string $path = null)
    {
        parent::__construct($name);
        $this->set_path($path);
    }
    public function get_path(): ?string
    {
        return $this->path;
    }
    public function set_path(?string $path): self
    {
        $this->path = $path;
        return $this;
    }
    public function get_array(): \stdClass|array
    {
        if ($this->get_path()) {
            return ['path' => $this->get_path()];
        }
        return new \stdClass();
    }
    public function get_type(): string
    {
        return 'reverse_nested';
    }
}