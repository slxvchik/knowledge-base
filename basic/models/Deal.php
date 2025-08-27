<?php

namespace app\models;

use app\interfaces\DisplayableThemeInterface;
use yii\base\InvalidConfigException;
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
 * @property Contact[] $contact_ids
 */
class Deal extends ActiveRecord implements DisplayableThemeInterface
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
            'contact_ids' => 'Контакты'
        ];
    }

    /**
     * Gets query for [[ContactDeals]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getContacts(): ActiveQuery
    {
        return $this->hasMany(Contact::class, ['id' => 'contact_id'])
            ->viaTable('contact_deal', ['deal_id' => 'id']);
    }

    function getId()
    {
        return $this->id;
    }

    function getLabel(): string
    {
        return $this->name;
    }

    function getType(): string
    {
        return 'deal';
    }
}
