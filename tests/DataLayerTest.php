<?php

use Spatie\GoogleTagManager\DataLayer;
use Spatie\GoogleTagManager\GoogleTagManager;

covers(DataLayer::class);

beforeEach(function () {
    $this->tagManager = new GoogleTagManager('', '');
});

it('sets from key and value', function () {
    $dataLayer = new DataLayer;
    $dataLayer->set('key', 'value');
    expect($dataLayer->toArray())->toBe(['key' => 'value']);
});

it('sets from an array', function () {
    $dataLayer = new DataLayer;
    $dataLayer->set(['key' => 'value']);
    expect($dataLayer->toArray())->toBe(['key' => 'value']);
});

it('clears', function () {
    $dataLayer = new DataLayer(['key' => 'value']);
    $dataLayer->clear();
    expect($dataLayer->toArray())->toBe([]);
});

it('encodes data to json', function () {
    $dataLayer = new DataLayer(['key' => 'value']);
    $json = $dataLayer->toJson();
    expect($json)->toBe('{"key":"value"}');
});
