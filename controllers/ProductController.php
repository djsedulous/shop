<?php
/**
 * Created by PhpStorm.
 * User: Viacheslav Matchenko
 * Date: 27.03.2016
 * Time: 0:11
 */

namespace app\controllers;

use app\models\Product;
use app\models\ProductForm;
use yii\web\Controller;
use yii\web\UploadedFile;
use \Yii;

class ProductController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdd()
    {
        // Создаем объект формы для создания/редактирования товара
        // с сценарием создания. Так как это новый продукт и нам нужно, чтоб валидатор формы
        // пропускал нас если пустое поле id
        $model = new ProductForm(['scenario' => ProductForm::SCENARIO_CREATE]);

        // Если HTML-форма была отправлен на сервер
        if (Yii::$app->request->isPost) {
            // Загружаем в объект класса ProductForm данные из post запроса
            $model->load(Yii::$app->request->post());

            // Получаем для поля imageFiles массив объектов класса UploadedFile.
            // Массив может быть пустым, если картинки не загружались
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');

            // Сохраняем данные. В качестве параметра передаем новый объект класса Product (для создания записи)
            if ($model->save(new Product())) {
                // Если сохранение завершилось успехом, то заполняем в сессии flashes,
                // чтоб показать уведомление на странице редактирования
                Yii::$app->session->setFlash('success', 'Product successfully added');

                // Переадресовываем на страницу редактирования
                $this->redirect(['edit', 'id' => $model->id]);

                // Завершаем выполнение программы
                Yii::$app->end();
            }

            // Если дошли до этого места значит возникли проблемы при соранении, оповещаем об этом
            Yii::$app->session->setFlash('danger', 'Error added product');
        }

        // Отрисовываем форму
        return $this->render('product', ['model' => $model]);
    }

    public function actionEdit($id)
    {
        // Создаем объект класса ProductForm со сценарием редактирования (поле id будет проходит валидацию)
        $model = new ProductForm(['scenario' => ProductForm::SCENARIO_EDIT]);

        // Получаем из таблицы запись с переданным id (будет объект класса Product)
        $product = Product::findOne(['id' => $id]);

        // Если передана HTML-форма
        if (Yii::$app->request->isPost) {
            // Загружаем данные из пост в объект класса ProductForm
            $model->load(Yii::$app->request->post());

            // Формируем массив загруженных файлов
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');

            // Сохраняем данные
            // В качестве параметра передаем полученный объект из записи в таблице
            if ($model->save($product)) {
                // Если сохранение удачно, то оповещаем об этом
                Yii::$app->session->setFlash('success', 'Product successfully save');
                $this->redirect(['edit', 'id' => $model->id]);
                Yii::$app->end();
            }

            // Если дошли до этого места значит возникли проблемы при соранении, оповещаем об этом
            Yii::$app->session->setFlash('danger', 'Error save product');
        }

        // Заполняем поля объекта класса ProductForm получеными данными из таблицы
        // Происходит только, в случае, когда небыло отправки HTML-формы (загрузка страницы)
        $model->attributes = $product->attributes;

        // Отрисовываем форму
        // Передаем дополнительно объект класса Product
        return $this->render('product', ['model' => $model, 'product' => $product]);
    }
}