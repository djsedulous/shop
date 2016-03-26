<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property integer $guarantee
 * @property integer $available
 *
 * @property CategoryProduct[] $categoryProducts
 * @property Category[] $categories
 * @property OrderList[] $orderLists
 * @property Order[] $orders
 * @property ProductStock[] $productStocks
 * @property Stock[] $stocks
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'guarantee'], 'required'],
            [['price'], 'number'],
            [['guarantee', 'available'], 'integer'],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'guarantee' => 'Guarantee',
            'available' => 'Available',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryProducts()
    {
        return $this->hasMany(CategoryProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('category_product', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderLists()
    {
        return $this->hasMany(OrderList::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id' => 'order_id'])->viaTable('order_list', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductStocks()
    {
        return $this->hasMany(ProductStock::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['id' => 'stock_id'])->viaTable('product_stock', ['product_id' => 'id']);
    }

    public function addToStock($stockId, $count = 0)
    {
        return ProductStock::addProductToStock($this->id, $stockId, $count);
    }

    public static function addProduct($data)
    {
        $model = new self();

        $model->attributes = $data;

        if ($model->validate()) {
            return $model->save();
        }

        return false;
    }
}
