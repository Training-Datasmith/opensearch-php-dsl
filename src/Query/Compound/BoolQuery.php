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
namespace Open_Search_Dsl\Query\Compound;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * Represents Elasticsearch "bool" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html
 */
class Bool_Query implements Builder_Interface
{
    use Parameters_Trait;
    public const MUST = 'must';
    public const MUST_NOT = 'must_not';
    public const SHOULD = 'should';
    public const FILTER = 'filter';
    private const LENGTH = 30;
    private array $container = [];
    public function __construct(array $container = [])
    {
        foreach ($container as $type => $queries) {
            $queries = is_array($queries) ? $queries : [$queries];
            array_walk($queries, function (\Open_Search_Dsl\Builder_Interface $query) use ($type): void {
                $this->add($query, $type);
            });
        }
    }
    public function get_queries(?string $bool_type = null): array
    {
        if ($bool_type === null) {
            $queries = [];
            foreach ($this->container as $item) {
                $queries = array_merge($queries, $item);
            }
            return $queries;
        }
        return $this->container[$bool_type] ?? [];
    }
    public function add(Builder_Interface $query, string $type = self::MUST, ?string $key = null): string
    {
        if (!in_array($type, [self::MUST, self::MUST_NOT, self::SHOULD, self::FILTER], true)) {
            throw new \UnexpectedValueException(sprintf('The bool operator %s is not supported', $type));
        }
        if (!$key) {
            $key = bin2hex(random_bytes(self::LENGTH));
        }
        $this->container[$type][$key] = $query;
        return $key;
    }
    public function to_array(): array
    {
        if (count($this->container) === 1 && isset($this->container[self::MUST]) && (is_countable($this->container[self::MUST]) ? count($this->container[self::MUST]) : 0) === 1) {
            $query = reset($this->container[self::MUST]);
            return $query->to_array();
        }
        $output = [];
        foreach ($this->container as $bool_type => $builders) {
            /** @var BuilderInterface $builder */
            foreach ($builders as $builder) {
                $output[$bool_type][] = $builder->to_array();
            }
        }
        $output = $this->process_array($output);
        if (empty($output)) {
            $output = new \stdClass();
        }
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'bool';
    }
}