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
if (!defined('DC_RC_PATH')) { return; }

$this->registerModule(
	/* Name */		"ordo",
	/* Description*/	"Adding a way to order post.",
	/* Author */		"Lepeltier kévin [lipki]",
	/* Version */		'0.1',
	array(
		'permissions' =>	'contentadmin,publish',
		'priority'    =>	997,
		'type'	      =>	'plugin'
	)
);
