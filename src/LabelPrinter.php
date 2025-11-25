<?php

namespace LabelPrinter;

class LabelPrinter
{
    public static function make(array $labels, string $type = 'meal')
    {
        $view = match ($type) {
            'meal'  => 'labelprinter::print',
            'daily' => 'labelprinter::daily',
            default => 'labelprinter::print',
        };

        return response()->view($view, compact('labels'));
    }

    public static function meal(array $labels)
    {
        return static::make($labels, 'meal');
    }

    public static function daily(array $label)
    {
        return static::make([$label], 'daily');
    }
}
