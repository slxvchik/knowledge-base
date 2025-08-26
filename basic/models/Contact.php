<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $second_name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
// * @property ContactDeal[] $contactDeals
 */
class Contact extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['second_name'], 'default', 'value' => null],
            [['first_name'], 'required'],
            [['first_name', 'second_name'], 'string', 'max' => 100],
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
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

//    /**
//     * Gets query for [[ContactDeals]].
//     *
//     * @return ActiveQuery
//     */
//    public function getContactDeals()
//    {
//        return $this->hasMany(ContactDeal::class, ['contact_id' => 'id']);
//    }

}
