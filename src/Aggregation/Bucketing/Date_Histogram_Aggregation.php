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
namespace Open_Search_Dsl\Aggregation\Bucketing;

use Open_Search_Dsl\Aggregation\Abstract_Aggregation;
use Open_Search_Dsl\Aggregation\Type\Bucketing_Trait;
/**
 * Class representing Histogram aggregation.
 *
 * @see https://goo.gl/hGCdDd
 */
class Date_Histogram_Aggregation extends Abstract_Aggregation
{
    use Bucketing_Trait;
    protected ?string $calendar_interval = null;
    protected ?string $fixed_interval = null;
    protected ?string $time_zone = null;
    protected ?string $format = null;
    public function __construct(string $name, string $field, ?string $calendar_interval = null, ?string $fixed_interval = null, ?string $format = null, ?string $time_zone = null)
    {
        parent::__construct($name);
        $this->set_field($field);
        $this->set_calendar_interval($calendar_interval);
        $this->set_fixed_interval($fixed_interval);
        $this->set_format($format);
        $this->set_time_zone($time_zone);
    }
    public function get_calendar_interval(): ?string
    {
        return $this->calendar_interval;
    }
    public function set_calendar_interval(?string $calendar_interval): self
    {
        $this->calendar_interval = $calendar_interval;
        return $this;
    }
    public function get_fixed_interval(): ?string
    {
        return $this->fixed_interval;
    }
    public function set_fixed_interval(?string $fixed_interval): self
    {
        $this->fixed_interval = $fixed_interval;
        return $this;
    }
    public function get_time_zone(): ?string
    {
        return $this->time_zone;
    }
    public function set_time_zone(?string $time_zone): self
    {
        $this->time_zone = $time_zone;
        return $this;
    }
    public function get_format(): ?string
    {
        return $this->format;
    }
    public function set_format(?string $format): self
    {
        $this->format = $format;
        return $this;
    }
    public function get_array(): array
    {
        if ($this->get_calendar_interval() === null && $this->get_fixed_interval() === null) {
            throw new \LogicException('Date histogram aggregation must have field and calendar_interval or fixed_interval set.');
        }
        $out = ['field' => $this->get_field()];
        if ($this->get_calendar_interval()) {
            $out['calendar_interval'] = $this->get_calendar_interval();
        }
        if ($this->get_fixed_interval()) {
            $out['fixed_interval'] = $this->get_fixed_interval();
        }
        if ($this->get_time_zone()) {
            $out['time_zone'] = $this->get_time_zone();
        }
        if ($this->get_format()) {
            $out['format'] = $this->get_format();
        }
        return $out;
    }
    public function get_type(): string
    {
        return 'date_histogram';
    }
}