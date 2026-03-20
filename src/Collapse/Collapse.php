<?php

declare (strict_types=1);
namespace Open_Search_Dsl\Collapse;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * Data holder for collapse api.
 */
class Collapse implements Builder_Interface
{
    use Parameters_Trait;
    public function __construct(private string $field)
    {
    }
    public function get_type(): string
    {
        return 'collapse';
    }
    public function to_array(): array
    {
        $output = $this->process_array();
        $output['field'] = $this->field;
        return $output;
    }
}