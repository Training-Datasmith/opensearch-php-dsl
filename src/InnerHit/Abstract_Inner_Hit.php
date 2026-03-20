<?php

declare (strict_types=1);
namespace Open_Search_Dsl\Inner_Hit;

use Open_Search_Dsl\Name_Aware_Trait;
use Open_Search_Dsl\Named_Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
use Open_Search_Dsl\Search;
abstract class Abstract_Inner_Hit implements Named_Builder_Interface
{
    use Name_Aware_Trait;
    use Parameters_Trait;
    private string $path;
    private ?Search $search;
    public function __construct(string $name, string $path, ?Search $search = null)
    {
        $this->set_name($name);
        $this->set_path($path);
        $this->set_search($search);
    }
    public function get_path(): string
    {
        return $this->path;
    }
    public function set_path(string $path): self
    {
        $this->path = $path;
        return $this;
    }
    public function get_search(): ?Search
    {
        return $this->search;
    }
    public function set_search(?Search $search): self
    {
        $this->search = $search;
        return $this;
    }
    public function to_array(): array
    {
        $out = $this->get_search() ? $this->get_search()->to_array() : new \stdClass();
        return [$this->get_path_type() => [$this->get_path() => $out]];
    }
    private function get_path_type(): ?string
    {
        $type = null;
        return match ($this->get_type()) {
            Nested_Inner_Hit::TYPE => 'path',
            Parent_Inner_Hit::TYPE => 'type',
            default => $type,
        };
    }
}