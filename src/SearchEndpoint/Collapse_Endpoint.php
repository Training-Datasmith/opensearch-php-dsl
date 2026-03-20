<?php

declare (strict_types=1);
namespace Open_Search_Dsl\Search_Endpoint;

use Open_Search_Dsl\Builder_Interface;
/**
 * Search collapse dsl endpoint.
 */
class Collapse_Endpoint extends Abstract_Search_Endpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'collapse';
    private ?Builder_Interface $collapse = null;
    public function normalize(): ?array
    {
        if ($this->collapse) {
            return $this->collapse->to_array();
        }
        return null;
    }
    public function add(Builder_Interface $builder, ?string $key = null): string
    {
        if ($this->collapse) {
            throw new \OverflowException('Only one collapse can be set');
        }
        $this->collapse = $builder;
        return '';
    }
    public function get_all(?string $bool_type = null): array
    {
        return ['' => $this->get_collapse()];
    }
    public function get_collapse(): Builder_Interface
    {
        return $this->collapse;
    }
}