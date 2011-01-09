<?php
$arrangers = '';
foreach ($festival->getArrangers() as $arranger) {
  $arrangers .= $arranger->getName() . ', ';
}
echo substr($arrangers, 0, -2);
