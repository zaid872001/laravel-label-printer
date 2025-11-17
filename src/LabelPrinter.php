<?php

namespace LabelPrinter;

class LabelPrinter
{
    public function print(array $labels)
    {
        return view('labelprinter::print', compact('labels'));
    }

    public static function make(array $labels)
    {
        return (new static())->print($labels);
    }
}
