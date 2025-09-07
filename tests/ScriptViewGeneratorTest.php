<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\View\ViewException;
use Spatie\GoogleTagManager\Exceptions\ApiKeyNotSetException;

beforeEach(function () {
    $this->app->make('config')->set('googletagmanager.id', 'GTM-XXXX');
    $this->app->make('config')->set('googletagmanager.domain', 'example.com');
});

it('adds data to head', function () {
    $this->app->make('googletagmanager')->set('key', 'value');

    $view = Blade::render('@include("googletagmanager::head")');

    expect($view)
        ->toContain('window.dataLayer.push({"key":"value"});')
        ->toContain('https://example.com/gtm.js')
        ->toContain('GTM-XXXX');
});

it('adds data to body', function () {
    $this->app->make('googletagmanager')->push('key', 'value');

    $view = Blade::render('@include("googletagmanager::body")');

    expect($view)
        ->toContain('window.dataLayer.push({"key":"value"});')
        ->toContain('https://example.com/ns.html?id=GTM-XXXX');
});

it('throws exception if no key is set', function () {
    $this->app->make('config')->set('googletagmanager.id', '');

    $this->expectException(ViewException::class);
    Blade::render('@include("googletagmanager::body")');
});
