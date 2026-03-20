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
use Open_Search_Dsl\Parameters_Trait;
use Open_Search_Dsl\Serializer\Normalizer\Abstract_Normalizable;
/**
 * Abstract class used to define search endpoint with references.
 */
abstract class Abstract_Search_Endpoint extends Abstract_Normalizable
{
    use Parameters_Trait;
    public const NAME = 'search';
    private const KEY_LENGTH = 30;
    private const DEFAULT_ORDER = 10;
    /**
     * @var BuilderInterface[]
     */
    private array $container = [];
    public function add(Builder_Interface $builder, ?string $key = null): string
    {
        if (array_key_exists($key, $this->container)) {
            throw new \OverflowException(sprintf('Builder with %s name for endpoint has already been added!', $key));
        }
        if (!$key) {
            $key = bin2hex(random_bytes(self::KEY_LENGTH));
        }
        $this->container[$key] = $builder;
        return $key;
    }
    public function add_to_bool(Builder_Interface $builder, ?string $bool_type = null, ?string $key = null): string
    {
        throw new \BadFunctionCallException(sprintf("Endpoint %s doesn't support bool statements", static::NAME));
    }
    public function remove(string $key): self
    {
        if ($this->has($key)) {
            unset($this->container[$key]);
        }
        return $this;
    }
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->container);
    }
    public function get(string $key): ?Builder_Interface
    {
        if ($this->has($key)) {
            return $this->container[$key];
        }
        return null;
    }
    /**
     * @return BuilderInterface[]
     */
    public function get_all(?string $bool_type = null): array
    {
        return $this->container;
    }
    public function get_bool()
    {
        throw new \BadFunctionCallException(sprintf("Endpoint %s doesn't support bool statements", static::NAME));
    }
    abstract public function normalize(): ?array;
    public function get_order(): int
    {
        return self::DEFAULT_ORDER;
    }
}