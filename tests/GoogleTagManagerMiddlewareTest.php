<?php

use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Spatie\GoogleTagManager\GoogleTagManager;
use Spatie\GoogleTagManager\GoogleTagManagerMiddleware;

covers(GoogleTagManagerMiddleware::class);

beforeEach(function () {
    $this->session = $this->createMock(Store::class);
    $this->config = $this->createMock(Repository::class);
    $this->config->method('get')->willReturn('key');

    $this->tagManager = new GoogleTagManager('', '');
    $this->tagManagerMiddleware = new GoogleTagManagerMiddleware(
        $this->tagManager,
        $this->session,
        $this->config
    );
});

it('sets flashed data to the data layer', function () {
    $this->session->method('has')->willReturn(true);
    $this->session->method('get')->willReturn(['key' => 'value']);

    $this->tagManagerMiddleware->handle(new Request, function () {});

    expect($this->tagManager->getDataLayer()->toArray())->toBe([
        'key' => 'value',
    ]);
});

it('pushes flashed pushes to the push data layer', function () {
    $this->session->method('has')->willReturnOnConsecutiveCalls(false, true);
    $this->session->method('get')->willReturn([['key' => 'value']]);

    $this->tagManagerMiddleware->handle(new Request, function () {});

    expect($this->tagManager->getPushData())
        ->toHaveCount(1);
    expect($this->tagManager->getPushData()->first()->toArray())
        ->toBe(['key' => 'value']);
});

it('flashes the flash data to the session', function () {
    $this->tagManager->flash('key', 'value');

    $this->session->expects($this->exactly(2))
        ->method('flash')
        ->with(self::callback(static function ($value) {
            static $i = 0;

            return (match (++$i) {
                1 => self::equalTo('key'),
                2 => self::stringEndsWith(':push'),
            })->evaluate($value, returnResult: true);
        }));

    $this->tagManagerMiddleware->handle(new Request, function () {});
});

it('flashes the flash push data to the session', function () {
    $this->tagManager->flashPush('key', 'value');

    $this->session->expects($this->exactly(2))
        ->method('flash')
        ->with(
            self::callback(static function ($value) {
                static $i = 0;

                return (match (++$i) {
                    1 => self::anything(),
                    2 => self::stringEndsWith(':push'),
                })->evaluate($value, returnResult: true);
            }),
            self::callback(static function ($value) {
                static $i = 0;

                return (match (++$i) {
                    1 => self::anything(),
                    2 => self::equalTo([['key' => 'value']]),
                })->evaluate($value, returnResult: true);
            }),
        );

    $this->tagManagerMiddleware->handle(new Request, function () {});
});
