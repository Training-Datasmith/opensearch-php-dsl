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
namespace Open_Search_Dsl\Aggregation\Metric;

use Open_Search_Dsl\Aggregation\Abstract_Aggregation;
use Open_Search_Dsl\Aggregation\Type\Metric_Trait;
use Open_Search_Dsl\Builder_Interface;
/**
 * Top hits aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-top-hits-aggregation.html
 */
class Top_Hits_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    private ?int $size;
    private ?int $from;
    private array $sorts = [];
    public function __construct(string $name, ?int $size = null, ?int $from = null, ?Builder_Interface $sort = null)
    {
        parent::__construct($name);
        $this->set_from($from);
        $this->set_size($size);
        if ($sort) {
            $this->add_sort($sort);
        }
    }
    public function get_from(): ?int
    {
        return $this->from;
    }
    public function set_from(?int $from): self
    {
        $this->from = $from;
        return $this;
    }
    /**
     * @return BuilderInterface[]
     */
    public function get_sorts(): array
    {
        return $this->sorts;
    }
    /**
     * @param BuilderInterface[] $sorts
     */
    public function set_sorts(array $sorts): self
    {
        $this->sorts = $sorts;
        return $this;
    }
    public function add_sort(Builder_Interface $sort): void
    {
        $this->sorts[] = $sort;
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
    public function get_array(): array
    {
        $sorts_output = null;
        $added_sorts = $this->get_sorts();
        if ($added_sorts) {
            $sorts_output = [];
            foreach ($added_sorts as $sort) {
                $sorts_output[] = $sort->to_array();
            }
        }
        return \array_filter(['sort' => $sorts_output, 'size' => $this->get_size(), 'from' => $this->get_from()], static fn($val): bool => \is_array($val) || ($val || \is_numeric($val)));
    }
    public function get_type(): string
    {
        return 'top_hits';
    }
}