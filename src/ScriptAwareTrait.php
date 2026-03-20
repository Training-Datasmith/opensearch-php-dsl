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
namespace Open_Search_Dsl;

/**
 * A trait which handles elasticsearch aggregation script.
 */
trait Script_Aware_Trait
{
    /**
     * @var string|array{id: string, params?: array<string, mixed>}|null
     */
    private $script;
    /**
     * @return array{id: string, params?: array<string, mixed>}|string|null
     */
    public function get_script()
    {
        return $this->script;
    }
    /**
     * @param array{id: string, params?: array<string, mixed>}|string|null $script
     */
    public function set_script($script): self
    {
        $this->script = $script;
        return $this;
    }
}