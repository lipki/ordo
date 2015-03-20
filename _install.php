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

if (!defined('DC_CONTEXT_ADMIN')){return;}

$version = $core->plugins->moduleInfo('ordo','version');
if (version_compare($core->getVersion('ordo'),$version,'>='))
	return;

$core->setVersion('ordo',$version);
return true;