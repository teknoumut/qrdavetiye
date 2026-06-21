<?php
 = file_get_contents('edit.blade.php');
 = explode("\n", );
 = 0;  = 0;
foreach ( as  => ) {
    preg_match_all('/<div[\s>]/', , );
     += count([0]);
    preg_match_all('#</div>#', , );
     += count([0]);
}
echo "Open: , Close: , Diff: " . ( - );
