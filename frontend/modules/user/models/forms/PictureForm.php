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
            // email and password are both required
            [['picture'], 'file',
                'extensions' => ['jpg'],
                'checkExtensionByMimeType' => true,
            ],
        ];
    }

    public function save() {
        return 1;
    }

}
