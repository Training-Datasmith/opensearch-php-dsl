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

use Open_Search_Dsl\Suggest\Suggest;
/**
 * Search suggest dsl endpoint.
 */
class Suggest_Endpoint extends Abstract_Search_Endpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'suggest';
    public function normalize(): ?array
    {
        $output = [];
        /** @var Suggest $suggest */
        foreach ($this->get_all() as $suggest) {
            $output = array_merge($output, $suggest->to_array());
        }
        return $output;
    }
}