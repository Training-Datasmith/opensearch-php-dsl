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
namespace Open_Search_Dsl\Query\Term_Level;

use Open_Search_Dsl\Builder_Interface;
use Open_Search_Dsl\Parameters_Trait;
/**
 * Represents Elasticsearch "terms_set" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-set-query.html
 */
class Terms_Set_Query implements Builder_Interface
{
    use Parameters_Trait;
    public const MINIMUM_SHOULD_MATCH_TYPE_FIELD = 'minimum_should_match_field';
    public const MINIMUM_SHOULD_MATCH_TYPE_SCRIPT = 'minimum_should_match_script';
    public function __construct(private string $field, private array $terms, array $parameters)
    {
        $this->validate_parameters($parameters);
        $this->set_parameters($parameters);
    }
    public function to_array(): array
    {
        $query = ['terms' => $this->terms];
        return [$this->get_type() => [$this->field => $this->process_array($query)]];
    }
    public function get_type(): string
    {
        return 'terms_set';
    }
    private function validate_parameters(array $parameters): void
    {
        if (!isset($parameters[self::MINIMUM_SHOULD_MATCH_TYPE_FIELD]) && !isset($parameters[self::MINIMUM_SHOULD_MATCH_TYPE_SCRIPT])) {
            $message = 'Either minimum_should_match_field or minimum_should_match_script must be set.';
            throw new \InvalidArgumentException($message);
        }
    }
}