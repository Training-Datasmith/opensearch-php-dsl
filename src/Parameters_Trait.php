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
namespace Open_Search_Dsl;

/**
 * A trait which handles the behavior of parameters in queries, filters, etc.
 */
trait Parameters_Trait
{
    private array $parameters = [];
    public function has_parameter(string $name): bool
    {
        return isset($this->parameters[$name]);
    }
    /**
     * @return static
     */
    public function remove_parameter(string $name)
    {
        if ($this->has_parameter($name)) {
            unset($this->parameters[$name]);
        }
        return $this;
    }
    /**
     * @return array|string|int|float|bool|\stdClass
     */
    public function get_parameter(string $name)
    {
        return $this->parameters[$name];
    }
    public function get_parameters(): array
    {
        return $this->parameters;
    }
    /**
     * @param array|string|int|float|bool|\stdClass|object $value
     *
     * @return static
     */
    public function add_parameter(string $name, $value)
    {
        $this->parameters[$name] = $value;
        return $this;
    }
    /**
     * @return static
     */
    public function set_parameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }
    protected function process_array(array $array = []): array
    {
        return array_merge($array, $this->parameters);
    }
}