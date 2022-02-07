<?php

namespace App\Service\FixtureLoader;

use App\Entity\Ingredient;
use App\Factory\BasicIngredientFactory;
use App\Service\JsonFileContentReader\JsonFileContentReader;
use App\Service\Utils\DateUtils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class IngredientFixture implements FixtureInterface
{
    const FIXTURE_FILE_NAME='ingredients.json';
    public function __construct(private ParameterBagInterface $parameterBag, private JsonFileContentReader $contentReader, private ManagerRegistry $registry)
    {
    }

    public function load()
    {
        $json = $this->contentReader->getContent($this->parameterBag->get('fixtures_directory') ."/" . self::FIXTURE_FILE_NAME);
        $this->storeIngredients($this->extractIngredients($json));
    }

    public function storeIngredients(array $ingredients){
        $em = $this->registry->getManager();
        foreach ($ingredients as $ingredient){
            $em->persist($ingredient);
        }
        $em->flush();
    }

    /**
     * @param mixed $json
     * @return Ingredient[]
     */
    public function extractIngredients(mixed $json): array
    {
        ['ingredients' => $jsonIngredients] = $json;
        $ingredients = [];
        foreach ($jsonIngredients as $jsonIngredient){
            $ingredients[] = $this->extractIngredient($jsonIngredient);
        }
        return $ingredients;
    }


    public function extractIngredient(mixed $jsonIngredient): Ingredient
    {
        $expiresAt = DateUtils::strToDate($jsonIngredient['expires-at']);
        $bestBefore = DateUtils::strToDate($jsonIngredient['best-before']);
        return BasicIngredientFactory::create($jsonIngredient['title'], $expiresAt, $bestBefore, $jsonIngredient['stock']);
    }


}