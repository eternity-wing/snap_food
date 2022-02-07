<?php

namespace App\Service\JsonFileContentReader;

class JsonFileContentReader implements JsonFileContentReaderInterface
{

    /**
     * @throws \Exception
     */
    public function getContent(string $address): mixed
    {
        if(!file_exists($address)){
            throw new \Exception('File does not exist');
        }
        $json = file_get_contents($address);

        return json_decode($json,true);
    }
}