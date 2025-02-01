<?php
 $errors = array();

 /*--------------------------------------------------------------*/
 /* Function for Remove escapes special
 /* characters in a string for use in an SQL statement
 /*--------------------------------------------------------------*/
function real_escape($str){
  global $con;
  $escape = mysqli_real_escape_string($con,$str);
  return $escape;
}
/*--------------------------------------------------------------*/
/* Function for Remove html characters
/*--------------------------------------------------------------*/
function remove_junk($str){
  $str = nl2br($str);
  $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
  return $str;
}
/*--------------------------------------------------------------*/
/* Function for Uppercase first character
/*--------------------------------------------------------------*/
function first_character($str){
  $val = str_replace('-'," ",$str);
  $val = ucfirst($val);
  return $val;
}
/*--------------------------------------------------------------*/
/* Function for Checking input fields not empty
/*--------------------------------------------------------------*/
function validate_fields($var){
  global $errors;
  foreach ($var as $field) {
    $val = remove_junk($_POST[$field]);
    if(isset($val) && $val==''){
      $errors = $field ." can't be blank.";
      return $errors;
    }
  }
}
/*--------------------------------------------------------------*/
/* Function for Display Session Message
   Ex echo displayt_msg($message);
/*--------------------------------------------------------------*/
function display_msg($msg = '') {
    $output = '';
    if (!empty($msg) && is_array($msg)) { // Check if $msg is an array
       foreach ($msg as $key => $value) {
          $output .= "<div class=\"alert alert-{$key}\">";
          $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
          $output .= remove_junk(first_character($value));
          $output .= "</div>";
       }
       return $output;
    } else {
      return ""; // Return empty string if $msg is not an array or is empty
    }
 }
 
 
/*--------------------------------------------------------------*/
/* Function for redirect
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
/*--------------------------------------------------------------*/
/* Function for find out total saleing price, buying price and profit
/*--------------------------------------------------------------*/
function total_price($totals){
  $sum = 0;
  $sub = 0;
  $profit = 0;
  
  if(is_array($totals) && count($totals) > 0) {
      foreach($totals as $total) {
          $sum += (float)($total['total_saleing_price'] ?? 0);
          $sub += (float)($total['total_buying_price'] ?? 0);
          $profit = $sum - $sub;
      }
  }
  
  return array(
      number_format($sum, 2),
      number_format($profit, 2)
  );
}
/*--------------------------------------------------------------*/
/* Function for Readable date time
/*--------------------------------------------------------------*/
function read_date($str){
     if($str)
      return date('F j, Y, g:i:s a', strtotime($str));
     else
      return null;
  }
/*--------------------------------------------------------------*/
/* Function for  Readable Make date time
/*--------------------------------------------------------------*/
function make_date(){
  return strftime("%Y-%m-%d %H:%M:%S", time());
}
/*--------------------------------------------------------------*/
/* Function for  Readable date time
/*--------------------------------------------------------------*/
function count_id(){
  static $count = 1;
  return $count++;
}
/*--------------------------------------------------------------*/
/* Function for Creting random string
/*--------------------------------------------------------------*/
function randString($length = 5)
{
  $str='';
  $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

  for($x=0; $x<$length; $x++)
   $str .= $cha[mt_rand(0,strlen($cha))];
  return $str;
}

function get_recent_orders($user_id, $limit = 5) {
  global $db;
  return $db->query("SELECT * FROM orders WHERE user_id = '{$user_id}' ORDER BY order_date DESC LIMIT {$limit}");
}

function get_featured_products($limit = 4) {
  global $db;
  return $db->query("SELECT * FROM products WHERE featured = 1 LIMIT {$limit}");
}




function format_date($date) {
  if(empty($date) || $date == '0000-00-00 00:00:00') {
      return 'Date not available';
  }
  try {
      return date("M j, Y", strtotime($date));
  } catch (Exception $e) {
      return 'Invalid date';
  }
}

function order_status_label($status) {
  $labels = [
      'pending' => 'warning',
      'processing' => 'info',
      'shipped' => 'primary',
      'delivered' => 'success',
      'cancelled' => 'danger'
  ];
  return $labels[strtolower($status)] ?? 'default';
}
?>
