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

$core->tpl->addBlock('Entries',array('ordoTpl','Entries'));

class ordoTpl {
  
	public static function Entries ($attr,$content) {
    global $core;
    
    $res = $core->tpl->Entries($attr,$content);
    
		if( !empty($attr['sortby']) && $attr['sortby'] === 'position' ) {
      
      $order = !empty($attr['order']) ? html::escapeHTML($attr['order']) : 'ASC';
      
      $res = str_replace('$params[\'order\']', '//$params[\'order\']', $res);
      $res = '<?php '."\r".'$params["order"] = "post_position '.$order.'";'."\r".' ?>'."\r".$res;
      
    }
    
		return $res;
    
	}
  
}
