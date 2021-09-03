<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $administrate = $auth->createPermission('administrate');
        $administrate->description = 'Administrate the system';
        $auth->add($administrate);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $administrate);

        $auth->assign($admin, 1);
    }
}
