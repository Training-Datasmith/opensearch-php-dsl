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
 * Class representing composite aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-composite-aggregation.html
 */
class Composite_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    private array $sources = [];
    private ?int $size = null;
    private array $after = [];
    /**
     * @param AbstractAggregation[] $sources
     */
    public function __construct(string $name, array $sources = [])
    {
        parent::__construct($name);
        foreach ($sources as $agg) {
            $this->add_source($agg);
        }
    }
    public function add_source(Abstract_Aggregation $agg): self
    {
        $array = $agg->process_array($agg->get_array());
        $this->sources[] = [$agg->get_name() => [$agg->get_type() => $array]];
        return $this;
    }
    public function get_sources(): array
    {
        return $this->sources;
    }
    public function set_sources(array $sources): self
    {
        $this->sources = $sources;
        return $this;
    }
    public function set_size(?int $size): self
    {
        $this->size = $size;
        return $this;
    }
    public function get_size(): ?int
    {
        return $this->size;
    }
    public function set_after(array $after): self
    {
        $this->after = $after;
        return $this;
    }
    public function get_after(): array
    {
        return $this->after;
    }
    public function get_array(): array
    {
        $array = ['sources' => $this->sources];
        if ($this->size !== null) {
            $array['size'] = $this->size;
        }
        if (!empty($this->after)) {
            $array['after'] = $this->after;
        }
        return $array;
    }
    public function get_type(): string
    {
        return 'composite';
    }
}