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
namespace Open_Search_Dsl\Highlight;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * Data holder for highlight api.
 */
class Highlight implements Builder_Interface
{
    use Parameters_Trait;
    private array $fields = [];
    private array $tags = [];
    public function add_field(string $name, array $params = []): self
    {
        $this->fields[$name] = $params;
        return $this;
    }
    public function set_tags(array $pre_tags, array $post_tags): self
    {
        $this->tags['pre_tags'] = $pre_tags;
        $this->tags['post_tags'] = $post_tags;
        return $this;
    }
    public function get_type(): string
    {
        return 'highlight';
    }
    public function to_array(): array
    {
        $output = $this->tags;
        $output = $this->process_array($output);
        foreach ($this->fields as $field => $params) {
            $output['fields'][$field] = count($params) ? $params : new \stdClass();
        }
        return $output;
    }
}