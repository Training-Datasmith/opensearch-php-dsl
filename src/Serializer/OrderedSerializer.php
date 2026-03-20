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
namespace Open_Search_Dsl\Serializer;

use Open_Search_Dsl\Search_Endpoint\Abstract_Search_Endpoint;
class Ordered_Serializer
{
    public function normalize($data)
    {
        $data = is_array($data) ? $this->order($data) : $data;
        if (is_iterable($data)) {
            foreach ($data as $key => $value) {
                if ($value instanceof Abstract_Search_Endpoint) {
                    $normalize = $value->normalize();
                    if ($normalize === null || count($normalize) === 0) {
                        unset($data[$key]);
                        continue;
                    }
                    $data[$key] = $normalize;
                }
            }
        }
        return $data;
    }
    private function order(array $data): array
    {
        $filtered_data = array_filter($data, static fn($value): bool => $value instanceof Abstract_Search_Endpoint);
        uasort($filtered_data, static fn(Abstract_Search_Endpoint $a, Abstract_Search_Endpoint $b): int => $a->get_order() <=> $b->get_order());
        return array_merge($filtered_data, array_diff_key($data, $filtered_data));
    }
}