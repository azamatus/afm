<?php
namespace Nurix\DBAL;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EnumStatusType extends Type
{
    const ENUM_STATUS = 'enumstatus';

    public static function toArray()
    {
        return array('В обработке','Заказ подтвержден','На складе','Отправлено','Доставлено','Заказ отменен','Задержка товара');
    }

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "ENUM('В обработке','Заказ подтвержден','На складе','Отправлено','Доставлено','Заказ отменен','Задержка товара') COMMENT '(DC2Type:enumstatus)'";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value,array('В обработке','Заказ подтвержден','На складе','Отправлено','Доставлено','Заказ отменен','Задержка товара') )) {
            throw new \InvalidArgumentException("Invalid status");
        }
        return $value;
    }

    public function getName()
    {
        return self::ENUM_STATUS;
    }
}