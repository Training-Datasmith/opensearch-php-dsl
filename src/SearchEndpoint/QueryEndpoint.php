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
namespace Open_Search_Dsl\Search_Endpoint;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Query\Compound\Bool_Query;
/**
 * Search query dsl endpoint.
 */
class Query_Endpoint extends Abstract_Search_Endpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'query';
    private const DEFAULT_ORDER = 2;
    private ?Bool_Query $bool = null;
    private bool $filters_set = false;
    public function normalize(): ?array
    {
        if (!$this->filters_set && $this->has_reference('filter_query')) {
            /** @var BuilderInterface $filter */
            $filter = $this->get_reference('filter_query');
            $this->add_to_bool($filter, Bool_Query::FILTER);
            $this->filters_set = true;
        }
        if (!$this->bool) {
            return null;
        }
        return $this->bool->to_array();
    }
    public function add(Builder_Interface $builder, ?string $key = null): string
    {
        return $this->add_to_bool($builder, Bool_Query::MUST, $key);
    }
    public function add_to_bool(Builder_Interface $builder, ?string $bool_type = null, $key = null): string
    {
        if (!$this->bool) {
            $this->bool = new Bool_Query();
        }
        return $this->bool->add($builder, $bool_type, $key);
    }
    public function get_order(): int
    {
        return self::DEFAULT_ORDER;
    }
    public function get_bool(): ?\Open_Search_Dsl\Query\Compound\Bool_Query
    {
        return $this->bool;
    }
    public function get_all(?string $bool_type = null): array
    {
        return $this->bool->get_queries($bool_type);
    }
}