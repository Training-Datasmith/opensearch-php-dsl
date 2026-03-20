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

use Open_Search_Dsl\Aggregation\Abstract_Aggregation;
use Open_Search_Dsl\Highlight\Highlight;
use Open_Search_Dsl\Inner_Hit\Nested_Inner_Hit;
use Open_Search_Dsl\Query\Compound\Bool_Query;
use Open_Search_Dsl\Search_Endpoint\Abstract_Search_Endpoint;
use Open_Search_Dsl\Search_Endpoint\Aggregations_Endpoint;
use Open_Search_Dsl\Search_Endpoint\Highlight_Endpoint;
use Open_Search_Dsl\Search_Endpoint\Inner_Hits_Endpoint;
use Open_Search_Dsl\Search_Endpoint\Post_Filter_Endpoint;
use Open_Search_Dsl\Search_Endpoint\Query_Endpoint;
use Open_Search_Dsl\Search_Endpoint\Search_Endpoint_Factory;
use Open_Search_Dsl\Search_Endpoint\Sort_Endpoint;
use Open_Search_Dsl\Search_Endpoint\Suggest_Endpoint;
use Open_Search_Dsl\Serializer\Ordered_Serializer;
/**
 * Search object that can be executed by a manager.
 */
class Search
{
    /**
     * If you don’t need to track the total number of hits at all you can improve
     * query times by setting this option to false. Defaults to true.
     *
     * @var bool|int|null
     */
    private $track_total_hits;
    /**
     * To retrieve hits from a certain offset. Defaults to 0.
     */
    private ?int $from = null;
    /**
     * The number of hits to return. Defaults to 10. If you do not care about getting some
     * hits back but only about the number of matches and/or aggregations, setting the value
     * to 0 will help performance.
     */
    private ?int $size = null;
    /**
     * Allows to control how the _source field is returned with every hit. By default
     * operations return the contents of the _source field unless you have used the
     * stored_fields parameter or if the _source field is disabled.
     *
     * @var bool|string|array|null
     */
    private $source;
    /**
     * Allows to selectively load specific stored fields for each document represented by a search hit.
     */
    private ?array $stored_fields = null;
    /**
     * Allows to return a script evaluation (based on different fields) for each hit.
     * Script fields can work on fields that are not stored, and allow to return custom
     * values to be returned (the evaluated value of the script). Script fields can
     * also access the actual _source document indexed and extract specific elements
     * to be returned from it (can be an "object" type).
     */
    private ?array $script_fields = null;
    /**
     * Allows to return the doc value representation of a field for each hit. Doc value
     * fields can work on fields that are not stored. Note that if the fields parameter
     * specifies fields without docvalues it will try to load the value from the fielddata
     * cache causing the terms for that field to be loaded to memory (cached), which will
     * result in more memory consumption.
     */
    private ?array $doc_value_fields = null;
    /**
     * Enables explanation for each hit on how its score was computed.
     */
    private ?bool $explain = null;
    /**
     * Returns a version for each search hit.
     */
    private ?bool $version = null;
    /**
     * Allows to configure different boost level per index when searching across more
     * than one indices. This is very handy when hits coming from one index matter more
     * than hits coming from another index (think social graph where each user has an index).
     */
    private ?array $indices_boost = null;
    /**
     * Exclude documents which have a _score less than the minimum specified in min_score.
     */
    private ?float $min_score = null;
    /**
     * Pagination of results can be done by using the from and size but the cost becomes
     * prohibitive when the deep pagination is reached. The index.max_result_window which
     * defaults to 10,000 is a safeguard, search requests take heap memory and time
     * proportional to from + size. The Scroll api is recommended for efficient deep
     * scrolling but scroll contexts are costly and it is not recommended to use it for
     * real time user requests. The search_after parameter circumvents this problem by
     * providing a live cursor. The idea is to use the results from the previous page to
     * help the retrieval of the next page.
     */
    private ?array $search_after = null;
    /**
     * URI parameters alongside Request body search.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-uri-request.html
     */
    private array $uri_params = [];
    /**
     * While a search request returns a single “page” of results, the scroll API can be used to retrieve
     * large numbers of results (or even all results) from a single search request, in much the same way
     * as you would use a cursor on a traditional database. Scrolling is not intended for real time user
     * requests, but rather for processing large amounts of data, e.g. in order to reindex the contents
     * of one index into a new index with a different configuration.
     */
    private ?string $scroll = null;
    private static ?Ordered_Serializer $serializer = null;
    /**
     * @var AbstractSearchEndpoint[]
     */
    private array $endpoints = [];
    /**
     * Constructor to initialize static properties
     */
    public function __construct()
    {
        $this->initialize_serializer();
    }
    /**
     * Wakeup method to initialize static properties
     */
    public function __wakeup(): void
    {
        $this->initialize_serializer();
    }
    /**
     * Initializes the serializer
     */
    private function initialize_serializer(): void
    {
        if (self::$serializer === null) {
            self::$serializer = new Ordered_Serializer();
        }
    }
    /**
     * Destroys search endpoint.
     */
    public function destroy_endpoint(string $type): void
    {
        unset($this->endpoints[$type]);
    }
    /**
     * Adds query to the search.
     *
     * @param string $key
     *
     * @return $this
     */
    public function add_query(Builder_Interface $query, string $bool_type = Bool_Query::MUST, ?string $key = null): static
    {
        $endpoint = $this->get_endpoint(Query_Endpoint::NAME);
        $endpoint->add_to_bool($query, $bool_type, $key);
        return $this;
    }
    public function get_endpoint(string $type): Abstract_Search_Endpoint
    {
        if (!array_key_exists($type, $this->endpoints)) {
            $this->endpoints[$type] = Search_Endpoint_Factory::get($type);
        }
        return $this->endpoints[$type];
    }
    /**
     * Returns queries inside BoolQuery instance.
     *
     * @return BoolQuery
     */
    public function get_queries()
    {
        $endpoint = $this->get_endpoint(Query_Endpoint::NAME);
        return $endpoint->get_bool();
    }
    /**
     * Adds a post filter to search.
     *
     * @param BuilderInterface $filter filter
     * @param string $boolType example boolType values:
     *                         - must
     *                         - must_not
     *                         - should
     * @param string $key
     *
     * @return $this
     */
    public function add_post_filter(Builder_Interface $filter, ?string $bool_type = Bool_Query::MUST, ?string $key = null): static
    {
        $this->get_endpoint(Post_Filter_Endpoint::NAME)->add_to_bool($filter, $bool_type, $key);
        return $this;
    }
    /**
     * Returns queries inside BoolFilter instance.
     *
     * @return BoolQuery
     */
    public function get_post_filters()
    {
        $endpoint = $this->get_endpoint(Post_Filter_Endpoint::NAME);
        return $endpoint->get_bool();
    }
    /**
     * Adds aggregation into search.
     *
     * @return $this
     */
    public function add_aggregation(Abstract_Aggregation $aggregation, ?string $key = null): static
    {
        $this->get_endpoint(Aggregations_Endpoint::NAME)->add($aggregation, $key ?: $aggregation->get_name());
        return $this;
    }
    /**
     * Returns all aggregations.
     *
     * @return BuilderInterface[]
     */
    public function get_aggregations(): array
    {
        return $this->get_endpoint(Aggregations_Endpoint::NAME)->get_all();
    }
    /**
     * Adds inner hit into search.
     *
     * @return $this
     */
    public function add_inner_hit(Nested_Inner_Hit $inner_hit, ?string $key = null): static
    {
        $this->get_endpoint(Inner_Hits_Endpoint::NAME)->add($inner_hit, $key ?: $inner_hit->get_name());
        return $this;
    }
    /**
     * Returns all inner hits.
     *
     * @return BuilderInterface[]
     */
    public function get_inner_hits(): array
    {
        return $this->get_endpoint(Inner_Hits_Endpoint::NAME)->get_all();
    }
    /**
     * Adds sort to search.
     *
     * @return $this
     */
    public function add_sort(Builder_Interface $sort, ?string $key = null): static
    {
        $this->get_endpoint(Sort_Endpoint::NAME)->add($sort, $key);
        return $this;
    }
    /**
     * Returns all set sorts.
     *
     * @return BuilderInterface[]
     */
    public function get_sorts(): array
    {
        return $this->get_endpoint(Sort_Endpoint::NAME)->get_all();
    }
    /**
     * Allows to highlight search results on one or more fields.
     *
     * @param Highlight $highlight
     *
     * @return $this
     */
    public function add_highlight(\Open_Search_Dsl\Builder_Interface $highlight): static
    {
        $this->get_endpoint(Highlight_Endpoint::NAME)->add($highlight);
        return $this;
    }
    /**
     * Returns highlight builder.
     */
    public function get_highlights(): \Open_Search_Dsl\Builder_Interface
    {
        /** @var HighlightEndpoint $highlightEndpoint */
        $highlight_endpoint = $this->get_endpoint(Highlight_Endpoint::NAME);
        return $highlight_endpoint->get_highlight();
    }
    /**
     * Adds suggest into search.
     *
     * @return $this
     */
    public function add_suggest(Named_Builder_Interface $suggest, ?string $key = null): static
    {
        $this->get_endpoint(Suggest_Endpoint::NAME)->add($suggest, $key ?: $suggest->get_name());
        return $this;
    }
    /**
     * Returns all suggests.
     *
     * @return BuilderInterface[]
     */
    public function get_suggests(): array
    {
        return $this->get_endpoint(Suggest_Endpoint::NAME)->get_all();
    }
    public function get_from(): ?int
    {
        return $this->from;
    }
    /**
     * @return $this
     */
    public function set_from(?int $from): static
    {
        $this->from = $from;
        return $this;
    }
    /**
     * @return bool|int|null
     */
    public function is_track_total_hits()
    {
        return $this->track_total_hits;
    }
    /**
     * @param bool|int|null $trackTotalHits
     *
     * @return $this
     */
    public function set_track_total_hits($track_total_hits): static
    {
        $this->track_total_hits = $track_total_hits;
        return $this;
    }
    public function get_size(): ?int
    {
        return $this->size;
    }
    /**
     * @return $this
     */
    public function set_size(?int $size): static
    {
        $this->size = $size;
        return $this;
    }
    public function is_source(): bool
    {
        return $this->source !== false && $this->source !== '';
    }
    /**
     * @return bool|string|array
     */
    public function get_source()
    {
        return $this->source;
    }
    /**
     * @param bool|string|array $source
     *
     * @return $this
     */
    public function set_source($source): static
    {
        $this->source = $source;
        return $this;
    }
    /**
     * @return array
     */
    public function get_stored_fields(): ?array
    {
        return $this->stored_fields;
    }
    /**
     * @param array $storedFields
     *
     * @return $this
     */
    public function set_stored_fields(?array $stored_fields): static
    {
        $this->stored_fields = $stored_fields;
        return $this;
    }
    /**
     * @return array
     */
    public function get_script_fields(): ?array
    {
        return $this->script_fields;
    }
    /**
     * @param array $scriptFields
     *
     * @return $this
     */
    public function set_script_fields(?array $script_fields): static
    {
        $this->script_fields = $script_fields;
        return $this;
    }
    /**
     * @return array
     */
    public function get_doc_value_fields(): ?array
    {
        return $this->doc_value_fields;
    }
    /**
     * @param array $docValueFields
     *
     * @return $this
     */
    public function set_doc_value_fields(?array $doc_value_fields): static
    {
        $this->doc_value_fields = $doc_value_fields;
        return $this;
    }
    /**
     * @return bool
     */
    public function is_explain(): ?bool
    {
        return $this->explain;
    }
    /**
     * @param bool $explain
     *
     * @return $this
     */
    public function set_explain(?bool $explain): static
    {
        $this->explain = $explain;
        return $this;
    }
    /**
     * @return bool
     */
    public function is_version(): ?bool
    {
        return $this->version;
    }
    /**
     * @param bool $version
     *
     * @return $this
     */
    public function set_version(?bool $version): static
    {
        $this->version = $version;
        return $this;
    }
    /**
     * @return array
     */
    public function get_indices_boost(): ?array
    {
        return $this->indices_boost;
    }
    /**
     * @param array $indicesBoost
     *
     * @return $this
     */
    public function set_indices_boost(?array $indices_boost): static
    {
        $this->indices_boost = $indices_boost;
        return $this;
    }
    /**
     * @return float
     */
    public function get_min_score(): ?float
    {
        return $this->min_score;
    }
    /**
     * @param int|float $minScore
     *
     * @return $this
     */
    public function set_min_score($min_score): static
    {
        $this->min_score = (float) $min_score;
        return $this;
    }
    /**
     * @return array
     */
    public function get_search_after(): ?array
    {
        return $this->search_after;
    }
    /**
     * @param array $searchAfter
     *
     * @return $this
     */
    public function set_search_after(?array $search_after): static
    {
        $this->search_after = $search_after;
        return $this;
    }
    /**
     * @return string
     */
    public function get_scroll(): ?string
    {
        return $this->scroll;
    }
    /**
     * @param string $scroll
     *
     * @return $this
     */
    public function set_scroll(?string $scroll = '5m'): static
    {
        $this->scroll = $scroll;
        $this->add_uri_param('scroll', $this->scroll);
        return $this;
    }
    /**
     * @param string $name
     * @param string|array|bool $value
     *
     * @return $this
     */
    public function add_uri_param($name, string $value): static
    {
        if (in_array($name, ['q', 'df', 'analyzer', 'analyze_wildcard', 'default_operator', 'lenient', 'explain', '_source', '_source_exclude', '_source_include', 'stored_fields', 'sort', 'track_scores', 'timeout', 'terminate_after', 'from', 'size', 'search_type', 'scroll', 'allow_no_indices', 'ignore_unavailable', 'typed_keys', 'pre_filter_shard_size', 'ignore_unavailable'], true)) {
            $this->uri_params[$name] = $value;
        } else {
            throw new \InvalidArgumentException(sprintf('Parameter %s is not supported.', $value));
        }
        return $this;
    }
    /**
     * Returns query url parameters.
     */
    public function get_uri_params(): array
    {
        return $this->uri_params;
    }
    public function to_array()
    {
        $output = self::$serializer->normalize($this->endpoints);
        $params = ['from' => 'from', 'size' => 'size', 'source' => '_source', 'storedFields' => 'stored_fields', 'scriptFields' => 'script_fields', 'docValueFields' => 'docvalue_fields', 'explain' => 'explain', 'version' => 'version', 'indicesBoost' => 'indices_boost', 'minScore' => 'min_score', 'searchAfter' => 'search_after', 'trackTotalHits' => 'track_total_hits'];
        foreach ($params as $field => $param) {
            if ($this->{$field} !== null) {
                $output[$param] = $this->{$field};
            }
        }
        return $output;
    }
}