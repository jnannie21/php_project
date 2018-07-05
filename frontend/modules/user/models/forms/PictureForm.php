<?php

namespace frontend\modules\user\models\forms;

use Yii;
use yii\base\Model;

/**
 * Picture form
 */
class PictureForm extends Model {

    public $picture;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['picture'], 'file',
                'extensions' => ['jpg'],
                'checkExtensionByMimeType' => true,
            ],
        ];
    }
}
