<?php
namespace Nurix\CatalogBundle\DBAL;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Strokit\CoreBundle\DBAL\EnumType;

class EnumStatusType extends EnumType
{
    const ENUM_STATUS = 'enumstatus';

    protected $name = 'enumstatus';
    protected $values = array('new','confirmed','in_storage','sended','delivered','canceled','delay');
    public static function getArray()
    {
        return array('new'=>'В обработке','confirmed'=>'Подтвержден','in_storage' => 'На складе','sended'=>'Отправлено','delivered'=>'Доставлено','canceled'=>'Отменен','delay'=>'Задержка');
    }
}