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
class dcOrdoActionsPage extends dcPostsActionsPage {

	public function __construct($core,$uri,$redirect_args=array()) {
		parent::__construct($core,$uri,$redirect_args);
		$this->redirect_fields = array();

	}
  
	public function loadDefaults() {
		$this->actions['reorder']=array('dcOrdoActionsPage','doReorderPages');
	}
  
	public function process() {
		// fake action for pages reordering
		if (!empty($this->from['reorder'])) {
			$this->from['action']='reorder';
		}
		$this->from['post_type']='page';
		return parent::process();
	}

	public static function doReorderPages($core, dcOrdoActionsPage $ap, $post) {
		foreach($post['order'] as $post_id => $value) {
			if (!$core->auth->check('publish,contentadmin',$core->blog->id))
				throw new Exception(__('You are not allowed to change this entry status'));

			$strReq = "WHERE blog_id = '".$core->con->escape($core->blog->id)."' ".
					"AND post_id ".$core->con->in($post_id);

			#If user can only publish, we need to check the post's owner
			if (!$core->auth->check('contentadmin',$core->blog->id))
				$strReq .= "AND user_id = '".$core->con->escape($core->auth->userID())."' ";

			$cur = $core->con->openCursor($core->prefix.'post');

			$cur->post_position = (integer) $value-1;
			$cur->post_upddt = date('Y-m-d H:i:s');

			$cur->update($strReq);
			$core->blog->triggerBlog();

		}

		dcPage::addSuccessNotice(__('Selected post have been successfully reordered.'));
		$ap->redirect(false);
	}
}