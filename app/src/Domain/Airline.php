<?php

namespace App\Domain;

class Airline
{
    public const AIRLINE_NAME = 'ch-aviation';
    
    public function __construct(private readonly string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}