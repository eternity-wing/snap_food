<?php

namespace App\Service\FixtureLoader;

use App\Entity\Food;
use App\Entity\Ingredient;
use App\Service\JsonFileContentReader\JsonFileContentReader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FoodFixture implements FixtureInterface
{
    const FIXTURE_FILE_NAME='foods.json';
    private array $ingredientsMappedByTitle = [];
    public function __construct(private ParameterBagInterface $parameterBag, private JsonFileContentReader $contentReader, private ManagerRegistry $registry)
    {
    }

    public function load()
    {
        $json = $this->contentReader->getContent($this->parameterBag->get('fixtures_directory') ."/" . self::FIXTURE_FILE_NAME);
        $this->loadALlIngredients();
        $this->storeFoods($this->extractFoods($json));
    }

    /**
     * @param Food[] $foods
     */
    public function storeFoods(array $foods){
        $em = $this->registry->getManager();
        foreach ($foods as $food){
            $em->persist($food);
        }
        $em->flush();
    }

    /**
     * @param mixed $json
     * @return Food[]
     */
    public function extractFoods(mixed $json): array
    {
        ['recipes' => $recipes] = $json;
        $foods = [];
        foreach ($recipes as $recipe){
            $foods[] = $this->extractFood($recipe);
        }
        return $foods;
    }


    public function extractFood(mixed $recipe): Food
    {
        $food = new Food();
        $food->setTitle($recipe['title']);
        foreach ($recipe['ingredients'] as $ingredientTitle){
            if(array_key_exists($ingredientTitle, $this->ingredientsMappedByTitle)){
                $food->addIngredient($this->ingredientsMappedByTitle[$ingredientTitle]);
            }

        }
        return $food;
    }

    private function loadALlIngredients(){
        foreach ($this->registry->getRepository(Ingredient::class)->findAll() as $ingredient){
            $this->ingredientsMappedByTitle[$ingredient->getTitle()] = $ingredient;
        }
    }


}