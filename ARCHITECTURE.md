# Architecture: opensearch-php-dsl

## Purpose

A PHP DSL (Domain Specific Language) library for building OpenSearch query DSL programmatically. Lets you construct complex `bool` queries, aggregations, sorting, highlighting, and pagination without writing raw JSON arrays by hand.

## Directory Structure

```
src/
  Search.php                    — Root builder: composes queries, aggregations, sorts, highlights
  Builder_Interface.php         — Common interface: toArray() returns the JSON-serializable structure
  Named_Builder_Interface.php   — Builders that have a name (used in aggregations)
  Builder_Bag.php               — Container for multiple named builders
  Parameters_Trait.php          — Common setParameter/getParameter fluent helpers
  Name_Aware_Trait.php          — getType() / getName() helpers
  Query/
    Compound/
      Bool_Query.php            — must/should/must_not/filter clauses
      Function_Score_Query.php
      Boosting_Query.php, Constant_Score_Query.php, Dis_Max_Query.php
    FullText/
      Match_Query.php, Multi_Match_Query.php, Query_String_Query.php, ...
    TermLevel/
      Term_Query.php, Terms_Query.php, Range_Query.php, Exists_Query.php, ...
    Geo/
      Geo_Bounding_Box_Query.php, Geo_Distance_Query.php, ...
    Joining/
      Nested_Query.php, Has_Child_Query.php, Has_Parent_Query.php
    Span/  — Span queries for positional matching
    Specialized/ — MoreLikeThis, Script
  Aggregation/
    Abstract_Aggregation.php    — Base: name, nested aggs, toArray()
    Bucketing/                  — Terms, Range, DateHistogram, Filters, Nested, ...
    Metric/                     — Avg, Max, Min, Sum, Stats, Cardinality, TopHits, ...
    Pipeline/                   — AvgBucket, Derivative, MovingAverage, BucketSort, ...
  Sort/
    FieldSort.php, NestedSort.php, ScoreSort.php, GeoSort.php
  Highlight/
    Highlight.php               — Field-level highlighting configuration
  Collapse/
    Collapse.php                — Field collapsing
  InnerHit/
    Nested_Inner_Hit.php, Parent_Inner_Hit.php
```

## Key Design Decisions

- **Builder pattern**: Every query and aggregation implements `Builder_Interface::toArray()`, returning the array that maps directly to the OpenSearch JSON DSL
- **Composable queries**: Queries can be nested — e.g., a `Bool_Query` contains `Match_Query` objects in its `must` clause; aggregations can be sub-aggregated
- **`Search` as root**: The `Search` class owns `addQuery()`, `addAggregation()`, `addSort()`, etc. and assembles the final request body via `toArray()`

## Extension Points

- Implement `Builder_Interface` to add a custom query or aggregation type
- Use `Bool_Query` as the root and compose arbitrarily deep nested boolean logic

## Dependency Flow

```
Search::toArray()
  → Query (Builder_Interface::toArray())
  → Aggregations (Abstract_Aggregation::toArray())
  → Sorts (FieldSort::toArray())
  → passed to opensearch-php Client::search(['body' => $search->toArray()])
```
