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
namespace Open_Search_Dsl\Aggregation\Pipeline;

use Open_Search_Dsl\Script_Aware_Trait;
/**
 * Class representing Bucket Script Pipeline Aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-bucket-script-aggregation.html
 */
class Bucket_Script_Aggregation extends Abstract_Pipeline_Aggregation
{
    use Script_Aware_Trait;
    /**
     * @param string|array{id: string, params?: array<string, mixed>}|null $script
     */
    public function __construct(string $name, array $buckets_path, $script = null)
    {
        parent::__construct($name, $buckets_path);
        $this->set_script($script);
    }
    public function get_array(): array
    {
        if (!$this->get_script()) {
            throw new \LogicException(sprintf('`%s` aggregation must have script set.', $this->get_name()));
        }
        return ['buckets_path' => $this->get_buckets_path(), 'script' => $this->get_script()];
    }
    public function get_type(): string
    {
        return 'bucket_script';
    }
}