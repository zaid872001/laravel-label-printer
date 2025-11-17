<?php

namespace LabelPrinter;

use Illuminate\Support\ServiceProvider;

class LabelPrinterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('labelprinter', function () {
            return new LabelPrinter();
        });
    }

    public function boot()
    {
            // 'labelprinter' is the view namespace
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'labelprinter');
    }
}
