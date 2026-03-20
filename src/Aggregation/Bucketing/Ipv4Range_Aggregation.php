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
 * Class representing ip range aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-iprange-aggregation.html
 */
class Ipv4range_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    private array $ranges = [];
    public function __construct(string $name, string $field, array $ranges = [])
    {
        parent::__construct($name);
        $this->set_field($field);
        foreach ($ranges as $range) {
            if (\is_array($range)) {
                $from = $range['from'] ?? null;
                $to = $range['to'] ?? null;
                $this->add_range($from, $to);
                continue;
            }
            $this->add_mask($range);
        }
    }
    public function add_range(?string $from = null, ?string $to = null): self
    {
        $range = \array_filter(['from' => $from, 'to' => $to], static fn(?string $v): bool => null !== $v);
        $this->ranges[] = $range;
        return $this;
    }
    public function add_mask(string $mask): self
    {
        $this->ranges[] = ['mask' => $mask];
        return $this;
    }
    public function get_array(): array
    {
        if (empty($this->ranges)) {
            throw new \LogicException('Ip range aggregation must have field set and range added.');
        }
        return ['field' => $this->get_field(), 'ranges' => $this->ranges];
    }
    public function get_type(): string
    {
        return 'ip_range';
    }
}