<?php

declare (strict_types=1);
namespace Open_Search_Dsl\Aggregation\Pipeline;

use Open_Search_Dsl\Aggregation\Abstract_Aggregation;
use Open_Search_Dsl\Aggregation\Type\Metric_Trait;
abstract class Abstract_Pipeline_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    /**
     * @var array|string
     */
    private $buckets_path;
    public function __construct(string $name, $buckets_path)
    {
        parent::__construct($name);
        $this->set_buckets_path($buckets_path);
    }
    /**
     * @return array|string
     */
    public function get_buckets_path()
    {
        return $this->buckets_path;
    }
    /**
     * @param array|string $bucketsPath
     */
    public function set_buckets_path($buckets_path): self
    {
        $this->buckets_path = $buckets_path;
        return $this;
    }
    public function get_array()
    {
        return ['buckets_path' => $this->get_buckets_path()];
    }
}