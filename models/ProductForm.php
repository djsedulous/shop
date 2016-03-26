<?php
/**
 * Created by PhpStorm.
 * User: Viacheslav Matchenko
 * Date: 26.03.2016
 * Time: 20:51
 */

namespace app\models;


class ProductForm extends MultiUploadForm
{
    // Сценарии работы формы
    const SCENARIO_CREATE = 'create'; // создание записи
    const SCENARIO_EDIT = 'edit'; // редактирование записи

    public $id;
    public $name;
    public $price;
    public $guarantee;

    public function rules()
    {
        // Забираем правила из модели MultiUploadForm
        $rules = parent::rules();

        return array_merge($rules, [
            [['id'], 'required', 'on' => 'edit'], // Для сценария редактирования поле обязательно должно содержать id записи
            [['name'], 'required'],
            [['price'], 'number'],
            [['guarantee'], 'integer'],
        ]);
    }

    /**
     * Список сценариев формы
     * @return array
     */
    public function scenarios()
    {
        // Поля которые валидируются в суенариях (не обязательно уазывать все)
        return [
            self::SCENARIO_CREATE => ['name', 'price', 'guarantee'],
            self::SCENARIO_EDIT => ['id', 'name', 'price', 'guarantee'],
        ];
    }

    /**
     * Метод сохранения продукта в БД
     * Он умеет загружать картинки и связывать их с продуктом
     * @param Product $product
     * @return bool
     */
    public function save(Product $product)
    {
        $isMain = true; // поле для установки главной картинки для подукта (первая картинка - главная)

        // Для сценария редактирования мы должны заполнить id записи
        if ($this->scenario == self::SCENARIO_EDIT) {
            $this->id = $product->id;
            $isMain = false; // при редактировании новые картинки не могут изменить главную картинку
        }

        // Поверяем все ли поля в данном сценарии соответствуют требованиям
        if ($this->validate()) {

            // Заполняем данными $poduct
            $product->attributes = $this->attributes;

            // если $product передан как пустой объект, то создастся новая запись, иначе обновится существующая
            if (!$product->save()) {
                return false;
            }

            // Перезаписываем id записи в нашей форме (актуально для сценария создания)
            $this->id = $product->id;

            // Загружаем картинки при помощи метода класса MultiUploadForm
            // метод upload принимает замыкание для того, чтоб каждая сохраненная картинка на сервере
            // и добавленная в таблицу image была свзяна с продуктом через таблицу product_image
            $this->upload(function ($imageId) use ($product, &$isMain) {
                $model = new ProductImage();
                $model->product_id = $product->id;
                $model->image_id = $imageId;

                // Если главная картинка не установлена то устанавливаем ее, и запрещаем останльным картинкам
                // быть главными
                if ($isMain) {
                    $model->is_main = 1;
                    $isMain = false;
                }

                // Сохраняем новую запись в таблице
                if ($model->save()) {
                    return true;
                }

                return false;
            });

            return true;
        }

        return false;
    }
}