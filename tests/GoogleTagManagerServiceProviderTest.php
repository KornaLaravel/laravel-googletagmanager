<?php

it('disables google tag manager', function () {
    $this->app->make('config')->set('googletagmanager.enabled', false);

    expect($this->app->make('googletagmanager')->isEnabled())->toBeFalse();
});
