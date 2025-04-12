<?php

namespace FizzBuzz\Formatter;

class FormatterFactory
{
    /**
     * Create a formatter based on the format type
     *
     * @param string $format The format type (json, csv, text)
     * @return FormatterInterface
     * @throws \InvalidArgumentException If format is not supported
     */
    public function create(string $format): FormatterInterface
    {
        return match ($format) {
            'json' => new JsonFormatter(),
            'csv' => new CsvFormatter(),
            'text' => new TextFormatter(),
            default => throw new \InvalidArgumentException("Unsupported format: $format"),
        };
    }
}
