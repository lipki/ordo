<?php
# -- BEGIN LICENSE BLOCK ---------------------------------------
#
# This file is part of ordo.
#
# Copyright (c) 2015 Lepeltier kévin [lipki]
# Licensed under the GPL version 2.0 license.
# See LICENSE file or
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
#
# -- END LICENSE BLOCK -----------------------------------------
if (!defined('DC_CONTEXT_ADMIN')) { return; }

$_menu['Blog']->addItem(__('ordo'),
	$core->adminurl->get('admin.plugin.ordo'),
	dcPage::getPF('ordo/icon.png'),
	preg_match('/plugin.php(.*)$/',$_SERVER['REQUEST_URI']) && !empty($_REQUEST['p']) && $_REQUEST['p']=='ordo',
	$core->auth->check('contentadmin,publish',$core->blog->id));