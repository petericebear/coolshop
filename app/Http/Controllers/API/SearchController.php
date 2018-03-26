<?php

namespace App\Http\Controllers\Api;

use App\Core\ElasticSearch\Transformers\ResultTransformer;
use Elasticsearch\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    protected $client;
    protected $search_fields = [];
    protected $aggregations_fields = [
        'typeRouter',
        'brand',
        'coolbluesChoice',
        'administratorOptions',
    ];

    protected $aggregations_filters = [];
    protected $sort;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(Request $request)
    {
        $size = $request->json('size', 10);
        $from = $request->json('from', 0);

        $this->buildAggregationFilters($request);

        $params = [
            'index' => 'coolshop',
            'type' => 'doc',
            'body' => [
                'size' => $size,
                'from' => $from,
                'query' => [
                    'bool' => [
                        'must' => $this->getFilters(),
                        'filter' => [],
                    ],
                ],
                'aggregations' => [
                    'all_facets' => [
                        'global' => (object)[],
                        'aggregations' => $this->getAggregations(),
                    ],
                ],
            ],
        ];

        $result = $this->client->search($params);

        return response()->json(ResultTransformer::create($result)->transform());
    }

    private function buildAggregationFilters($request)
    {
        collect(array_merge($this->aggregations_fields, $this->search_fields))->each(function ($field) use ($request) {
            $value = $request->get($field);
            if ($value) {
                if (!is_array($value)) {
                    $value = [$value];
                }

                $this->aggregations_filters[$field] = [
                    'terms' => [$field => $value],
                ];
            }
        });

        if ($request->json('search_text')) {
            $this->aggregations_filters['search_text'] = [
                'multi_match' => [
                    'query' => $request->json('search_text'),
                    'fields' => ['title^10', 'productOptions^3', 'administratorOptions'],
                    'operator' => 'and',
                    'fuzziness' => 'auto',
                ]
            ];
        }
    }

    private function getFilters()
    {
        return collect($this->aggregations_filters)->values()->all();
    }

    private function getAggregations()
    {
        $aggs = [];
        collect($this->aggregations_fields)->each(function ($field) use (&$aggs) {
            $aggs[$field] =
                [
                    'filter' => [
                        'bool' => [
                            'must' =>
                                collect($this->aggregations_filters)->reject(function ($i, $index) use ($field) {
                                    return $field == $index;
                                })->values()->all(),
                        ],
                    ],
                    'aggregations' => [
                        'filtered_'.$field => [
                            'terms' => [
                                'field' => $field,
                                'order' => ['_term' => 'asc'],
                                'min_doc_count' => 0,
                                'size' => 350,
                            ],
                        ],
                    ],
                ];
        });

        return $aggs;
    }
}
