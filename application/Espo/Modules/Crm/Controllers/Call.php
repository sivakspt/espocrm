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

namespace Espo\Modules\Crm\Controllers;

use \Espo\Core\Exceptions\Forbidden;
use \Espo\Core\Exceptions\BadRequest;
use \Espo\Core\Exceptions\NotFound;

class Call extends \Espo\Core\Controllers\Record
{

    public function actionSendInvitations($params, $data)
    {        
        if (empty($data['id'])) {
            throw new BadRequest();
        }
        
        $entity = $this->getRecordService()->getEntity($data['id']);
        
        if (!$entity) {
            throw new NotFound();
        }    
        
        if (!$this->getAcl()->check($entity, 'edit')) {
            throw new Forbidden();
        }
        
        return $this->getRecordService()->sendInvitations($entity);
    }

}
