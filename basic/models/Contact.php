<?php

namespace app\models;

use app\interfaces\DisplayableThemeInterface;
use Yii;
use yii\base\InvalidConfigException;
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
 * @property Deal[] $deal_ids
 */
class Contact extends ActiveRecord implements DisplayableThemeInterface
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
            'deal_ids' => 'Сделки'
        ];
    }

    /**
     * Gets query for [[ContactDeals]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getDeals(): ActiveQuery
    {
        return $this->hasMany(Deal::class, ['id' => 'deal_id'])
            ->viaTable('contact_deal', ['contact_id' => 'id']);
    }

    function getId()
    {
        return $this->id;
    }

    function getLabel(): string
    {
        return $this->first_name . ' ' . $this->second_name;
    }

    function getType(): string
    {
        return 'contact';
    }
}
