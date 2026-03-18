<?php

declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Query\Specialized;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "script" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-script-query.html
 */
class ScriptQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(private string $script, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    public function toArray(): array
    {
        $query = ['source' => $this->script];
        $output = $this->processArray($query);

        return [$this->getType() => ['script' => $output]];
    }

    public function getType(): string
    {
        return 'script';
    }
}
