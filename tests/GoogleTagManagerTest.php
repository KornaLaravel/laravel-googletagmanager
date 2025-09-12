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

it('can enable and disable', function () {
    $this->tagManager->disable();

    expect($this->tagManager->isEnabled())->toBeFalse();

    $this->tagManager->enable();

    expect($this->tagManager->isEnabled())->toBeTrue();
});

it('can set id', function () {
    $this->tagManager->setId('GTM-XXXXXX');

    expect($this->tagManager->id())->toBe('GTM-XXXXXX');
});

it('can clear', function () {
    $this->tagManager->set('key', 'value');
    $this->tagManager->flash('key', 'value');
    $this->tagManager->push('key', 'value');
    $this->tagManager->flashPush('key', 'value');

    expect($this->tagManager->getDataLayer()->toArray())->toBe(['key' => 'value']);
    expect($this->tagManager->getFlashData())->toBe(['key' => 'value']);
    expect($this->tagManager->getPushData())->toEqual(collect([new DataLayer(['key' => 'value'])]));
    expect($this->tagManager->getFlashPushData())->toEqual(collect([new DataLayer(['key' => 'value'])]));

    $this->tagManager->clear();

    expect($this->tagManager->getDataLayer()->toArray())->toBe([]);
    expect($this->tagManager->getFlashData())->toBe([]);
    expect($this->tagManager->getPushData())->toEqual(collect([]));
    expect($this->tagManager->getFlashPushData())->toEqual(collect([]));
});

it('can dump', function () {
    $json = $this->tagManager->dump(['key' => 'value']);

    expect($json)->toBe('{"key":"value"}');
});
