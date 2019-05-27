<?php

namespace app\modules\shop\models;

use app\models\Language;
use app\modules\shop\domains\category\Category;
use app\modules\shop\domains\product\Product;
use app\modules\shop\services\category\CreateCategoryService;
use app\modules\shop\services\category\CreateOrUpdateCategoryDataService;
use app\modules\shop\services\category\forms\CreateCategoryForm;
use app\modules\shop\services\category\forms\UpdateCategoryDataForm;
use app\modules\shop\services\product\CreateOrUpdateProductDataService;
use app\modules\shop\services\product\CreateProductService;
use app\modules\shop\services\product\forms\CreateProductForm;
use app\modules\shop\services\product\forms\UpdateProductDataForm;
use Faker\Factory;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\Json;

class Seeder extends Component
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function init()
    {
        parent::init();
        $this->faker = Factory::create();
    }

    public static function run()
    {
        $model = new static();
        $model->seed();
    }

    /**
     * @throws Exception
     */
    private function seed()
    {
        $this->generateCategories(10);
    }

    private function generateCategories(int $max)
    {
        for ($i = 1; $i <= $max; $i++) {
            $form = new CreateCategoryForm([
                'name' => $this->faker->country,
            ]);

            $service = new CreateCategoryService($form);
            if ($categoryId = $service->execute()) {
                $this->updateCategoryDescriptions($categoryId);
                $this->generateProducts($categoryId, 15);
            }
        }
    }

    private function generateProducts(int $categoryId, int $max)
    {
        for ($i = 1; $i <= $this->faker->numberBetween(2, $max); $i++) {
            $form = new CreateProductForm([
                'category_id' => $categoryId,
                'name' => $this->faker->city,
                'price' => $this->faker->numberBetween(1000, 200000),
            ]);

            $service = new CreateProductService($form);
            $productId = $service->execute();

            $this->updateProductDescriptions($productId);
        }
    }

    private function updateProductDescriptions(int $productId)
    {
        $product = Product::findOne($productId);

        foreach (Language::allowed() as $languageCode => $languageName) {
            $data = $product->data($languageCode);

            $form = new UpdateProductDataForm($data, $languageCode);
            $form->description = $this->faker->paragraphs($this->faker->numberBetween(1, 5), true);
            if ($form->validate()) {
                $service = new CreateOrUpdateProductDataService($form, $data);
                $service->execute();
            }
        }
    }

    private function updateCategoryDescriptions(int $categoryId)
    {
        $category = Category::findOne($categoryId);

        foreach (Language::allowed() as $languageCode => $languageName) {
            $data = $category->data($languageCode);

            $form = new UpdateCategoryDataForm($data, $languageCode);
            $form->description = $this->faker->paragraphs($this->faker->numberBetween(1, 5), true);
            if ($form->validate()) {
                $service = new CreateOrUpdateCategoryDataService($form, $data);
                $service->execute();
            }

        }
    }
}
