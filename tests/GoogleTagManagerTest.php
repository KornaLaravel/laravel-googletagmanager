<?php

use Spatie\GoogleTagManager\DataLayer;
use Spatie\GoogleTagManager\GoogleTagManager;

covers(GoogleTagManager::class);

beforeEach(function () {
    $this->tagManager = new GoogleTagManager('', '');
});

it('sets keys and values to the data layer', function () {
    $this->tagManager->set('key', 'value');

    expect($this->tagManager->getDataLayer()->toArray())
        ->toBe(['key' => 'value']);
});

it('sets arrays to the data layer', function () {
    $this->tagManager->set(['key' => 'value']);

    expect($this->tagManager->getDataLayer()->toArray())
        ->toBe(['key' => 'value']);
});

it('sets keys and values to the flash data layer', function () {
    $this->tagManager->flash('key', 'value');

    expect($this->tagManager->getFlashData())->toBe(['key' => 'value']);
});

it('sets arrays to the flash data layer', function () {
    $this->tagManager->flash(['key' => 'value']);

    expect($this->tagManager->getFlashData())->toBe(['key' => 'value']);
});

it('sets keys and values to the push data layer', function () {
    $this->tagManager->push('key', 'value');

    expect($this->tagManager->getPushData())->toEqual(collect([new DataLayer(['key' => 'value'])]));
});

it('sets arrays to the push data layer', function () {
    $this->tagManager->push(['key' => 'value']);

    expect($this->tagManager->getPushData())->toEqual(collect([new DataLayer(['key' => 'value'])]));
});

it('sets keys and values to the flash push data layer', function () {
    $this->tagManager->flashPush('key', 'value');

    expect($this->tagManager->getFlashPushData())->toEqual(collect([new DataLayer(['key' => 'value'])]));
});

it('sets arrays to the flash push data layer', function () {
    $this->tagManager->flashPush(['key' => 'value']);

    expect($this->tagManager->getFlashPushData())->toEqual(collect([new DataLayer(['key' => 'value'])]));
});
