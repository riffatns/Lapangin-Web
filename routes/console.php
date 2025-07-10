<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('db:monitor', function () {
    try {
        DB::connection()->getPdo();
        $this->info('Database connection successful');
        return 0;
    } catch (Exception $e) {
        $this->error('Database connection failed: ' . $e->getMessage());
        return 1;
    }
})->purpose('Monitor database connection');
