@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <search-bar></search-bar>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <search-aggregations></search-aggregations>
        </div>
        <div class="col-md-8">
            <search-results></search-results>
        </div>
    </div>
</div>
@endsection
