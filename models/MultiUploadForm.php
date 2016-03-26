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

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}