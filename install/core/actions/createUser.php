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

ob_start();
$result = array('success' => false, 'errorMsg' => '');

// create user
if (!empty($_SESSION['install']['user-name']) && !empty($_SESSION['install']['user-pass'])) {
	$userId = $installer->createUser($_SESSION['install']['user-name'], $_SESSION['install']['user-pass']);
	if (!empty($userId)) {
		$result['success'] = true;
	}
	else {
		$result['success'] = false;
		$result['errorMsg'] = 'Cannot create user';
	}
}
else {
	$result['success'] = false;
	$result['errorMsg'] = 'Cannot create user';
}

ob_clean();
echo json_encode($result);