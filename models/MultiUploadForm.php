<?php
/**
 * Created by PhpStorm.
 * User: Viacheslav Matchenko
 * Date: 26.03.2016
 * Time: 16:29
 */

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class MultiUploadForm extends Model
{
    private static $uploadPath = 'uploads/';

    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload(callable $callback = null)
    {
        // Проверяем валидна ли форма
        if ($this->validate()) {
            // Нумерация загружаемых пакетов картинок начинается с 10000 (я так захотел)
            $i = 10000;

            // Перебираем все загруженные картинки
            foreach ($this->imageFiles as $file) {
                // Формируем имя файлу на сервере
                $fileName = sprintf('%s_%s.%s', $i, time(), $file->extension);

                // Сохраняем файл на сервере
                $res = $file->saveAs(self::getImagePath($fileName));

                // Если файл сохранен то добавляем его в таблицу image
                if ($res) {
                    $image = new Image();
                    $image->name = $fileName;

                    // Сохраняем запись, и если сохранена то проверяем, передан ли callback,
                    // если да - то вызываем его передавая в него id только, что сохраненной записи в таблице image
                    if ($image->save() && is_callable($callback)) {
                        $callback($image->id);
                    }
                }

                $i++;
            }

            return true;
        }

        return false;
    }

    /**
     * Возвращает URL адресс картинки (куда она была загружена)
     * @param string $name
     * @return string
     */
    public static function getImageUrl($name)
    {
        return \Yii::$app->urlManager->baseUrl . '/' .self::$uploadPath . $name;
    }

    /**
     * Возвращает путь к картинке (куда она была или должна быть загружена)
     * @param string $name
     * @return string
     */
    public static function getImagePath($name)
    {
        return self::$uploadPath . $name;
    }
}