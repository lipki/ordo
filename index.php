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
dcPage::check('publish,contentadmin');

/* Get posts
-------------------------------------------------------- */
$user_id = !empty($_GET['user_id']) ?	$_GET['user_id'] : '';
$cat_id = !empty($_GET['cat_id']) ?	$_GET['cat_id'] : '';
$status = isset($_GET['status']) ?	$_GET['status'] : '';
$selected = isset($_GET['selected']) ?	$_GET['selected'] : '';
$attachment = isset($_GET['attachment']) ?	$_GET['attachment'] : '';
$month = !empty($_GET['month']) ?		$_GET['month'] : '';
$lang = !empty($_GET['lang']) ?		$_GET['lang'] : '';
$sortby = !empty($_GET['sortby']) ?	$_GET['sortby'] : 'post_dt';
$order = !empty($_GET['order']) ?		$_GET['order'] : 'desc';

$show_filters = false;

$page = !empty($_GET['page']) ? max(1,(integer) $_GET['page']) : 1;
$nb_per_page =  30;

if (!empty($_GET['nb']) && (integer) $_GET['nb'] > 0) {
	if ($nb_per_page != $_GET['nb']) {
		$show_filters = true;
	}
	$nb_per_page = (integer) $_GET['nb'];
}

$params['limit'] = array((($page-1)*$nb_per_page),$nb_per_page);
$params['no_content'] = true;
$params['order'] = 'post_position ASC, post_title ASC';

# Get posts
try {
	$posts = $core->blog->getPosts($params);
	$counter = $core->blog->getPosts($params,true);
	$post_list = new adminOrdoPostList($core,$posts,$counter->f(0));
} catch (Exception $e) {
	$core->error->add($e->getMessage());
}

# Actions combo box
$pages_actions_page = new dcOrdoActionsPage($core,'plugin.php',array('p'=>'ordo'));

if (!$pages_actions_page->process()) {

  /* DISPLAY
  -------------------------------------------------------- */
  ?>
  <html>
  <head>
    <title><?php echo __('Ordo'); ?></title>
    <?php
      echo
        dcPage::jsLoad('js/jquery/jquery-ui.custom.js').
        dcPage::jsLoad('js/jquery/jquery.ui.touch-punch.js').
        dcPage::jsLoad('js/_posts_list.js').
        dcPage::jsLoad(dcPage::getPF('ordo/list.js'));
    ?>
  </head>

  <body>
  <?php
  echo dcPage::breadcrumb(
    array(
      html::escapeHTML($core->blog->name) => '',
      __('Ordo') => ''
    )).dcPage::notices();

  $starting_script  = dcPage::jsLoad('js/_posts_list.js');

  if (!$core->error->flag())
  {
    # Show posts
    $post_list->display($page,$nb_per_page,
    '<form action="'.$core->adminurl->get('admin.plugin').'" method="post" id="form-entries">'.
    '%s'.
    '<p class="clear form-note hidden-if-js">'.
    __('To rearrange post order, change number at the begining of the line, then click on “Save post order” button.').'</p>'.
    '<p class="clear form-note hidden-if-no-js">'.
    __('To rearrange post order, move items by drag and drop, then click on “Save post order” button.').'</p>'.
    '<p><input type="submit" value="'.__('Save post order').'" name="reorder" class="clear" /></p>'.
    form::hidden(array('post_type'),'post').
    form::hidden(array('p'),'ordo').
    $core->formNonce().
    '</form>'
    );
  }
  
  dcPage::helpBlock('ordo');
  dcPage::close();
  
}
