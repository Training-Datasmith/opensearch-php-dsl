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
namespace Open_Search_Dsl\Suggest;

use Open_Search_Dsl\Name_Aware_Trait;
use Open_Search_Dsl\Named_Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
class Suggest implements Named_Builder_Interface
{
    use Name_Aware_Trait;
    use Parameters_Trait;
    private string $type;
    private string $text;
    private string $field;
    public function __construct(string $name, string $type, string $text, string $field, array $parameters = [])
    {
        $this->set_name($name);
        $this->set_type($type);
        $this->set_text($text);
        $this->set_field($field);
        $this->set_parameters($parameters);
    }
    public function get_type(): string
    {
        return $this->type;
    }
    public function set_type(string $type): self
    {
        $this->type = $type;
        return $this;
    }
    public function get_text(): string
    {
        return $this->text;
    }
    public function set_text(string $text): self
    {
        $this->text = $text;
        return $this;
    }
    public function get_field(): string
    {
        return $this->field;
    }
    public function set_field(string $field): self
    {
        $this->field = $field;
        return $this;
    }
    public function to_array(): array
    {
        return [$this->get_name() => ['text' => $this->get_text(), $this->get_type() => $this->process_array(['field' => $this->get_field()])]];
    }
}