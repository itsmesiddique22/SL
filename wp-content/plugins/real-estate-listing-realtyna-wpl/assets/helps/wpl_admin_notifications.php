<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/** Define Tabs **/
$tabs = array();
$tabs['tabs'] = array();

$content = '<h3>'.__('WPL Notifications', 'wpl').'</h3><p>'.__("With this menu, you can manage WPL notifications (i.e. edit notification templates and add custom recipients).", 'wpl').'</p>';
$tabs['tabs'][] = array('id'=>'wpl_contextual_help_tab_int', 'content'=>$content, 'title'=>__('Introduction', 'wpl'));

$articles  = '';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/576/" target="_blank">'.__("How do I use the Notification Manager in WPL?", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/696/" target="_blank">'.__("How do I change the sender email/name in WPL notifications?", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/690/" target="_blank">'.__("How do I disable WPL notifications for a certain user/agent??", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/665/" target="_blank">'.__("I don't receive contact notifications. What should I do?", 'wpl').'</a></li>';

$content = '<h3>'.__('Related KB Articles', 'wpl').'</h3><p>'.__('Here you will find KB articles with information related to this page. You can come back to this section to find an answer to any questions that may come up.', 'wpl').'</p><p><ul>'.$articles.'</ul></p>';
$tabs['tabs'][] = array('id'=>'wpl_contextual_help_tab_kb', 'content'=>$content, 'title'=>__('KB Articles', 'wpl'));

// Hide Tour button
$tabs['sidebar'] = array('content'=>'');

return $tabs;