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
 * Represents Elasticsearch "function_score" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-function-score-query.html
 */
class Function_Score_Query implements Builder_Interface
{
    use Parameters_Trait;
    private array $functions = [];
    public function __construct(private Builder_Interface $query, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function get_query(): Builder_Interface
    {
        return $this->query;
    }
    /**
     * @param mixed|null $missing
     */
    public function add_field_value_factor_function(string $field, float $factor, string $modifier = 'none', ?Builder_Interface $query = null, $missing = null, ?string $name = ''): self
    {
        $function = ['field_value_factor' => array_filter(['field' => $field, 'factor' => $factor, 'modifier' => $modifier, 'missing' => $missing])];
        if (!empty($name)) {
            $function['_name'] = $name;
        }
        if ($query) {
            $function['filter'] = $query->to_array();
        }
        $this->functions[] = $function;
        return $this;
    }
    public function add_decay_function(string $type, string $field, array $function, array $options = [], ?Builder_Interface $query = null, ?int $weight = null, ?string $name = ''): static
    {
        $function = array_filter([$type => array_merge([$field => $function], $options), 'weight' => $weight]);
        if (!empty($name)) {
            $function['_name'] = $name;
        }
        if ($query) {
            $function['filter'] = $query->to_array();
        }
        $this->functions[] = $function;
        return $this;
    }
    public function add_weight_function(float $weight, ?Builder_Interface $query = null, ?string $name = ''): self
    {
        $function = ['weight' => $weight];
        if (!empty($name)) {
            $function['_name'] = $name;
        }
        if ($query) {
            $function['filter'] = $query->to_array();
        }
        $this->functions[] = $function;
        return $this;
    }
    public function add_random_function($seed = null, ?Builder_Interface $query = null, ?string $name = ''): self
    {
        $function = ['random_score' => $seed ? ['seed' => $seed] : new \stdClass()];
        if (!empty($name)) {
            $function['_name'] = $name;
        }
        if ($query) {
            $function['filter'] = $query->to_array();
        }
        $this->functions[] = $function;
        return $this;
    }
    public function add_script_score_function(string $source, array $params = [], array $options = [], ?Builder_Interface $query = null, ?string $name = ''): self
    {
        $function = ['script_score' => ['script' => array_merge(['lang' => 'painless', 'source' => $source, 'params' => $params], $options)]];
        if (!empty($name)) {
            $function['_name'] = $name;
        }
        if ($query) {
            $function['filter'] = $query->to_array();
        }
        $this->functions[] = $function;
        return $this;
    }
    public function add_simple_function(array $function): self
    {
        $this->functions[] = $function;
        return $this;
    }
    public function to_array(): array
    {
        $query = ['query' => $this->get_query()->to_array(), 'functions' => $this->functions];
        $output = $this->process_array($query);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'function_score';
    }
}