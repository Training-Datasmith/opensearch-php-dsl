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
namespace Open_Search_Dsl\Aggregation\Matrix;

use Open_Search_Dsl\Aggregation\Abstract_Aggregation;
use Open_Search_Dsl\Aggregation\Type\Metric_Trait;
/**
 * Class representing Max Aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-max-aggregation.html
 */
class Max_Aggregation extends Abstract_Aggregation
{
    use Metric_Trait;
    private array $fields;
    private ?string $mode = null;
    private ?array $missing = null;
    /**
     * @param array|string $field
     */
    public function __construct(string $name, $field, ?array $missing = null, ?string $mode = null)
    {
        parent::__construct($name);
        $this->set_fields(is_string($field) ? [$field] : $field);
        $this->set_mode($mode);
        $this->set_missing($missing);
    }
    public function get_fields(): array
    {
        return $this->fields;
    }
    public function set_fields(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }
    public function get_mode(): ?string
    {
        return $this->mode;
    }
    public function set_mode(string $mode): self
    {
        $this->mode = $mode;
        return $this;
    }
    public function get_missing(): ?array
    {
        return $this->missing;
    }
    public function set_missing(?array $missing): self
    {
        $this->missing = $missing;
        return $this;
    }
    protected function get_array(): array
    {
        $out = ['fields' => $this->get_field()];
        if ($this->get_mode()) {
            $out['mode'] = $this->get_mode();
        }
        if ($this->get_missing()) {
            $out['missing'] = $this->get_missing();
        }
        return $out;
    }
    public function get_type(): string
    {
        return 'matrix_stats';
    }
}