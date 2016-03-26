<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_stock".
 *
 * @property integer $product_id
 * @property integer $stock_id
 * @property integer $count
 *
 * @property Stock $stock
 * @property Product $product
 */
class ProductStock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_stock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'stock_id'], 'required'],
            [['product_id', 'stock_id', 'count'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'stock_id' => 'Stock ID',
            'count' => 'Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['id' => 'stock_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public static function addProductToStock($productId, $stockId, $count)
    {
        $model = new self();

        $model->attributes = [
            'product_id' => $productId,
            'stock_id' => $stockId,
            'count' => $count,
        ];

        if ($model->validate()) {
            return $model->save();
        }

        return false;
    }
}
