<?php
$arrangers = '';
foreach ($dak_festival->getArrangers() as $arranger) {
  $arrangers .= $arranger->getName() . ', ';
}
echo substr($arrangers, 0, -2);
