<?php

declare(strict_types=1);

namespace Thingston\Tools\Coverage\Clover;

use SimpleXMLElement;
use Thingston\Tools\Coverage\Exception\InvalidArgumentException;

class ProjectReport
{
    public static function fromPath(string $path): self
    {
        if (false === is_readable($path) || false === $xml = file_get_contents($path)) {
            throw InvalidArgumentException::forFileNotFound($path);
        }

        return self::fromString($xml);
    }

    public static function fromString(string $data): self
    {
        return self::fromXml(new SimpleXMLElement($data));
    }

    public static function fromXml(SimpleXMLElement $xml): self
    {
        $xpath = '//project/metrics';
        $element = $xml->xpath($xpath);

        if (false === isset($element[0])) {
            throw InvalidArgumentException::forInvalidXml($xpath);
        }

        $metrics = [];
        $attributes = $element[0]->attributes() ?? [];

        foreach ($attributes as $name => $value) {
            $metrics[$name] = (int) $value;
        }

        return new self($metrics);
    }

    /**
     * @var array<string, int>
     */
    private array $metrics = [
        'files' => 0,
        'loc' => 0,
        'ncloc' => 0,
        'classes' => 0,
        'methods' => 0,
        'coveredmethods' => 0,
        'conditionals' => 0,
        'coveredconditionals' => 0,
        'statements' => 0,
        'coveredstatements' => 0,
        'elements' => 0,
        'coveredelements' => 0,
    ];

    /**
     * @param array<string, int> $metrics
     */
    public function __construct(array $metrics)
    {
        foreach (array_keys($this->metrics) as $name) {
            if (false === isset($metrics[$name]) || false === is_int($metrics[$name])) {
                throw InvalidArgumentException::forInvalidMetric($name);
            }
        }

        $this->metrics = $metrics;
    }

    /**
     * TPC = (coveredconditionals + coveredstatements + coveredmethods) / (conditionals + statements + methods)
     */
    public function getTotalProjectCoverage(int $precision = 2): float
    {
        $divisor = $this->metrics['coveredconditionals']
            + $this->metrics['coveredstatements']
            + $this->metrics['coveredmethods'];

        $dividend = $this->metrics['conditionals']
            + $this->metrics['statements']
            + $this->metrics['methods'];

        return 0 < $dividend ? round(($divisor / $dividend) * 100, $precision) : 100;
    }
}
