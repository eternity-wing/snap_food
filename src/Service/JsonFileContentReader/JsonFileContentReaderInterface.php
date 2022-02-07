<?php

namespace App\Service\JsonFileContentReader;

interface JsonFileContentReaderInterface
{
    public function getContent(string $address): mixed;
}