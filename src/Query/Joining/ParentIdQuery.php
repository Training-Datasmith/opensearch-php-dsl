<?php

declare (strict_types=1);
namespace Open_Search_Dsl\Query\Joining;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-parent-id-query.html
 */
class Parent_Id_Query implements Builder_Interface
{
    use Parameters_Trait;
    public function __construct(private string $parent_id, private string $child_type, array $parameters = [])
    {
        $this->set_parameters($parameters);
    }
    public function to_array(): array
    {
        $query = ['id' => $this->parent_id, 'type' => $this->child_type];
        $output = $this->process_array($query);
        return [$this->get_type() => $output];
    }
    public function get_type(): string
    {
        return 'parent_id';
    }
}