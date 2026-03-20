<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use OpenSearchDSL\Search;
use OpenSearchDSL\Query\Compound\BoolQuery;
use OpenSearchDSL\Query\FullText\MatchQuery;
use OpenSearchDSL\Query\TermLevel\RangeQuery;
use OpenSearchDSL\Query\TermLevel\TermQuery;
use OpenSearchDSL\Sort\FieldSort;
use OpenSearchDSL\Aggregation\Metric\AvgAggregation;
use OpenSearchDSL\Aggregation\Bucketing\TermsAggregation;

// --- Example 1: Simple match query ---
$search = new Search();
$search->addQuery(new MatchQuery('name', 'PHP programming'));
$search->setSize(10);

echo "Simple match:\n";
echo json_encode($search->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// --- Example 2: Bool query (must + filter) ---
$bool_query = new BoolQuery();
$bool_query->add(new MatchQuery('description', 'guide'), BoolQuery::MUST);
$bool_query->add(new TermQuery('category', 'books'), BoolQuery::FILTER);
$bool_query->add(new RangeQuery('price', ['gte' => 10, 'lte' => 100]), BoolQuery::FILTER);

$search2 = new Search();
$search2->addQuery($bool_query);
$search2->addSort(new FieldSort('price', FieldSort::ASC));
$search2->setSize(20);
$search2->setFrom(0);

echo "Bool query with filter and sort:\n";
echo json_encode($search2->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// --- Example 3: Aggregations ---
$search3 = new Search();
$search3->addQuery(new TermQuery('in_stock', true));

// Average price
$avg_price = new AvgAggregation('avg_price', 'price');
$search3->addAggregation($avg_price);

// Terms aggregation: group by category
$by_category = new TermsAggregation('by_category', 'category');
$by_category->addAggregation(new AvgAggregation('avg_price_per_cat', 'price'));
$search3->addAggregation($by_category);

echo "Aggregation query:\n";
echo json_encode($search3->toArray(), JSON_PRETTY_PRINT) . "\n";
