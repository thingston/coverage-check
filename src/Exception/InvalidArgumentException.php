<?php

namespace Thingston\Tools\Coverage\Exception;

class InvalidArgumentException extends \InvalidArgumentException implements CoverageCheckExceptionInterface
{
    public static function forFileNotFound(string $path): self
    {
        return new self(sprintf('File "%s" not found or it isn\'t readable.', $path));
    }

    public static function forInvalidMetric(string $name): self
    {
        return new self(sprintf('Missing or invalid metrics attributes "%s".', $name));
    }

    public static function forInvalidXml(string $xpath): self
    {
        return new self(sprintf('Missing or invalid XPath "%s".', $xpath));
    }
}
