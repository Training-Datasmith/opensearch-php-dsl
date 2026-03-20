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

/**
 * Search post filter dsl endpoint.
 */
class Post_Filter_Endpoint extends Query_Endpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'post_filter';
    private const DEFAULT_ORDER = 1;
    public function normalize(): ?array
    {
        if (!$this->get_bool()) {
            return null;
        }
        return $this->get_bool()->to_array();
    }
    public function get_order(): int
    {
        return self::DEFAULT_ORDER;
    }
}