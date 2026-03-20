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
/**
 * Search highlight dsl endpoint.
 */
class Highlight_Endpoint extends Abstract_Search_Endpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'highlight';
    private ?Builder_Interface $highlight = null;
    public function normalize(): ?array
    {
        if ($this->highlight) {
            return $this->highlight->to_array();
        }
        return null;
    }
    public function add(Builder_Interface $builder, ?string $key = null): string
    {
        if ($this->highlight) {
            throw new \OverflowException('Only one highlight can be set');
        }
        $this->highlight = $builder;
        return '';
    }
    public function get_all(?string $bool_type = null): array
    {
        return ['' => $this->get_highlight()];
    }
    public function get_highlight(): Builder_Interface
    {
        return $this->highlight;
    }
}