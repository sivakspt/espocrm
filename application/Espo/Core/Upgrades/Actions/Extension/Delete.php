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

namespace Espo\Core\Upgrades\Actions\Extension;

use Espo\Core\Exceptions\Error;

class Delete extends \Espo\Core\Upgrades\Actions\Base\Delete
{
    protected $extensionEntity;

    /**
     * Get entity of this extension
     *
     * @return \Espo\Entities\Extension
     */
    protected function getExtensionEntity()
    {
        return $this->extensionEntity;
    }

    /**
     * Set Extension Entity
     *
     * @param \Espo\Entities\Extension $extensionEntity
     */
    protected function setExtensionEntity(\Espo\Entities\Extension $extensionEntity)
    {
        $this->extensionEntity = $extensionEntity;
    }

    protected function beforeRunAction()
    {
        $processId = $this->getProcessId();

        /** get extension entity */
        $extensionEntity = $this->getEntityManager()->getEntity('Extension', $processId);
        if (!isset($extensionEntity)) {
            throw new Error('Extension Entity not found.');
        }
        $this->setExtensionEntity($extensionEntity);
    }

    protected function afterRunAction()
    {
        /** Delete extension entity */
        $extensionEntity = $this->getExtensionEntity();
        $this->getEntityManager()->removeEntity($extensionEntity);
    }
}