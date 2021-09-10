<?php

namespace app\components\helpers;

use Yii;

class DateHelper {

    public static function localeDateTimeToUTC($localeDateTime) 
    {
        if (!empty($localeDateTime)) {
            $value = new \DateTime($localeDateTime, new \DateTimeZone(Yii::$app->formatter->timeZone));
            $value->setTimezone(new \DateTimeZone('UTC'));

            // format used here must be in-sync with Yii::$app->formatter->datetimeFormat
            return $value->format('Y-m-d H:i:00');
        } else {
            return $localeDateTime;
        }
    }

    public static function utcDateTimeToLocale($utcDateTime)
    {
        if (!empty($utcDateTime)) {
            // convert UTC datetime from DB into locale date time (used for forms)
            $value = new \DateTime($utcDateTime, new \DateTimeZone('UTC'));
            $value->setTimezone(new \DateTimeZone(Yii::$app->formatter->timeZone));
            // format used here must be in-sync with Yii::$app->formatter->datetimeFormat
            return  $value->format('Y-m-d H:i:00'); 
        }
    }    
}