<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\WithFaker;

uses(LazilyRefreshDatabase::class)->in('Feature');

uses()->afterEach(function () {
    RefreshDatabaseState::$lazilyRefreshed = false;
    RefreshDatabaseState::$migrated = false;
})->in('Feature');

uses(Tests\TestCase::class, WithFaker::class)->in('Unit', 'Feature');
