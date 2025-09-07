<?php

use Spatie\GoogleTagManager\GoogleTagManager;
use Spatie\GoogleTagManager\GoogleTagManagerFacade;

it('resolves the facade', function () {
    expect(GoogleTagManagerFacade::getFacadeRoot())->toBeInstanceOf(GoogleTagManager::class);
});