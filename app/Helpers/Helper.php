$uri = ['/rnd/data/standar’, '/rnd/data/standar'];
function set_active($uri, $output = ‘active’)
{sda
 if( is_array($uri) ) {
   foreach ($uri as $u) {
     if (Route::is($u)) {
       return $output;
     }
   }
 } else {
   if (Route::is($uri)){
     return $output;
   }
 }
}