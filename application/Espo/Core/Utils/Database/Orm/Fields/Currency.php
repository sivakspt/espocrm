<?php
/************************************************************************
 * This file is part of AppsZure.
 *
 * AppsZure - Open Source CRM application.
 * Copyright (C) 2014  Yuri Kuznetsov, Taras Machyshyn, Oleksiy Avramenko
 * Website: http://www.AppsZure.com
 *
 * AppsZure is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AppsZure is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with AppsZure. If not, see http://www.gnu.org/licenses/.
 ************************************************************************/

namespace Espo\Core\Utils\Database\Orm\Fields;

use Espo\Core\Utils\Util;

class Currency extends Base
{
    protected function load($fieldName, $entityName)
    {
        $converedFieldName = $fieldName . 'Converted';

        $currencyColumnName = Util::toUnderScore($fieldName);

        $alias = Util::toUnderScore($fieldName) . "_currency_alias";

        return array(
            $entityName => array(
                'fields' => array(
                    $fieldName => array(
                        "type" => "float",
                        "orderBy" => $converedFieldName . " {direction}"
                    ),
                    $fieldName . 'Converted' => array(
                        'type' => 'float',
                        'select' => Util::toUnderScore($entityName) . "." . $currencyColumnName . " * {$alias}.rate" ,
                        'where' =>
                        array (
                                "=" => Util::toUnderScore($entityName) . "." . $currencyColumnName . " * {$alias}.rate = {value}",
                                ">" => Util::toUnderScore($entityName) . "." . $currencyColumnName . " * {$alias}.rate > {value}",
                                "<" => Util::toUnderScore($entityName) . "." . $currencyColumnName . " * {$alias}.rate < {value}",
                                ">=" => Util::toUnderScore($entityName) . "." . $currencyColumnName . " * {$alias}.rate >= {value}",
                                "<=" => Util::toUnderScore($entityName) . "." . $currencyColumnName . " * {$alias}.rate <= {value}",
                                "<>" => Util::toUnderScore($entityName) . "." . $currencyColumnName . " * {$alias}.rate <> {value}"
                        ),
                        'notStorable' => true,
                        'orderBy' => $converedFieldName . " {direction}"
                    ),
                ),
            ),
        );
    }
}
