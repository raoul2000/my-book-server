<?php

namespace app\controllers\admin\cron;

use Yii;
use yii\filters\AccessControl;
use bs\dbManager\models\Dump;
use bs\dbManager\models\Restore;
use Symfony\Component\Process\Process;
use yii\helpers\VarDumper;
use yii\web\UnauthorizedHttpException;

class DbManagerController extends \yii\web\Controller
{

    public function actionIndex($key)
    {
        if($key !== Yii::$app->params['cron']['dbBackupKey']){
            throw new UnauthorizedHttpException('invalid key');
        }
        Yii::info("DB backup begin", get_called_class());
        $dbManagerModule = Yii::$app->getModule('db-manager'); 

        $model = new Dump($dbManagerModule->dbList, $dbManagerModule->customDumpOptions);

        // name of the component DB to backup
        $model->db = "db";

        $dbInfo = $dbManagerModule->getDbInfo($model->db);
        $dumpOptions = $model->makeDumpOptions();
        $manager = $dbManagerModule->createManager($dbInfo);
        $dumpPath = $manager->makePath($dbManagerModule->path, $dbInfo, $dumpOptions);
        $dumpCommand = $manager->makeDumpCommand($dumpPath, $dbInfo, $dumpOptions);
        
        $this->runProcess($dumpCommand);
        Yii::info("DB backup end", get_called_class());
    }

    protected function runProcess($command, $isRestore = false)
    {
        $dbManagerModule = Yii::$app->getModule('db-manager');

        $process = new Process($command);
        $process->setTimeout($dbManagerModule->timeout);
        $process->run();
        if ($process->isSuccessful()) {
            $msg = (!$isRestore) ? Yii::t('dbManager', 'Dump successfully created.') : Yii::t('dbManager', 'Dump successfully restored.');
        } else {
            $msg = (!$isRestore) ? Yii::t('dbManager', 'Dump failed.') : Yii::t('dbManager', 'Restore failed.');
            Yii::error($msg . PHP_EOL . 'Command - ' . $command . PHP_EOL . $process->getOutput() . PHP_EOL . $process->getErrorOutput());
        }
        return $msg;
    }
}
