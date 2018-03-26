<?php

namespace App\Core\ElasticSearch\Transformers;

class ResultTransformer
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public static function create($result)
    {
        return new static($result);
    }

    public function transform()
    {
        $hits = collect($this->result['hits']['hits'])->map(function ($item) {
            return $item['_source'];
        });

        $meta = [];
        $meta['took'] = $this->result['took'];
        $meta['total_hits'] = $this->result['hits']['total'];
        $meta['total_all'] = $this->result['aggregations']['all_facets']['doc_count'];

        unset($this->result['aggregations']['all_facets']['doc_count']);

        $aggs = collect($this->result['aggregations']['all_facets'])->map(function ($item, $key) {
            return collect($item['filtered_'.$key]['buckets'])->map(function ($bucket) {
                return [
                    'label' => $bucket['key'],
                    'value' => $bucket['doc_count'],
                ];
            })->all();
        })->all();

        return [
            'data' => $hits,
            'facets' => $aggs,
            'meta' => $meta,
        ];
    }
}
