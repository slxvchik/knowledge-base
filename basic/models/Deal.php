<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "deals".
 *
 * @property int $id
 * @property string $name
 * @property int|null $sum
 * @property string|null $created_at
 * @property string|null $updated_at
 *
// * @property ContactDeal[] $contact
 */
class Deal extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'deals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['sum'], 'default', 'value' => null],
            [['sum'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'sum' => 'Сумма',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * Gets query for [[ContactDeals]].
     *
     * @return ActiveQuery
     */
//    public function getDealContacts(): ActiveQuery
//    {
//        return $this->hasMany(Contact::class, ['deal_id' => 'id']);
//    }

}
