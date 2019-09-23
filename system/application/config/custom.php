<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$temp['base_url'] = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '').'://'.$_SERVER['HTTP_HOST'].str_replace('//','/',dirname($_SERVER['SCRIPT_NAME']).'/');
$config['refresh_time']	= "3";

$config['button_save'] = array('name' => 'button[save]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtnsave.png',
                             );
$config['button_save_to_excel'] = array('name' => 'button[savetoexcel]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtnsavetoexcel.png',
                             );
$config['button_change'] = array('name' => 'button[change]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/btnchange.png',
                             );
$config['button_cancel'] = array('name' => 'button[cancel]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtncancel.png',
                             );
$config['button_cancel_admin'] = array('name' => 'button[cancel]',
//                              'value'=> 'Cancel',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtncancel.png',
                             );

$config['button_cancel_perm'] = array('name' => 'cancel',
                              'value'=> 'Cancel',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtncancel.png',
                             );

$config['button_approve'] = array('name' => 'button[approve]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtnapprove.png',
                             );

$config['button_reject'] = array('name' => 'button[reject]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/btnreject.png',
                             );

$config['button_approve_waste'] = array('name' => 'button[approve_waste]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/btnapprovewaste.png',
                             );

$config['button_approve_stockopname'] = array('name' => 'button[approve_stockopname]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtnapprovestockopnwst.png',
                             );

$config['button_delete'] = array('name' => 'button[delete]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jdeleteitem.png',
                             );
$config['button_delete_item'] = array('name' => 'button[delete_item]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jdeleteitem.png',
                             );
$config['button_add_item'] = array('name' => 'button[add]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jadditem.png',
                             );

$config['button_search'] = array('name' => 'submit2',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtnsearch.png',
                             );

$config['button_upload'] = array('name' => 'upload',
                              'type' => 'image',
//                              'Value' => 'Upload',
                              'src' => $temp['base_url'].'images/jbtnupload.png',
                             );
$config['button_browse'] = array('name' => 'userfile',
                              'src' => $temp['base_url'].'images/btnbrowse.png',
                             );
$config['button_back'] = array('name' => 'button[back]',
//                              'type' => 'image',
                              'value'=> 'Back',
                              'src' => $temp['base_url'].'images/jbtnback.png',
                             );

$config['button_submit'] = array('name' => 'button[submit]',
//                              'value'=> 'Save',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtnsubmit.png',
                             );
$config['button_login'] = array('name' => 'submit',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtnlogin.png',
                             );

$config['button_submit_save'] = array('name' => 'submit',
                              'value'=> 'Save',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtnsave.png',
                             );
$config['uom_kg'] = array('G'=>'G',
                          'KG'=>'KG',
                             );
$config['uom_l'] = array('ML'=>'ML',
                         'L'=>'L',
                             );
$config['button_sendmailsx'] = array('name' => 'button[submit]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtnmailsx.png',
                             );							 
$config['button_sendhelpsx'] = array('name' => 'button[submit]',
                              'type' => 'image',
                              'src' => $temp['base_url'].'images/jbtnhelpsx.png',
                             );							 
							 
/* End of file custom.php */
/* Location: ./system/application/config/custom.php */
