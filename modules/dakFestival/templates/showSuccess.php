<?php
use_helper('I18N', 'Date');
slot('title', $festival['title'] . ' - ' . __('Festival'));
?>
<h1><?php echo $festival['title'] ?></h1>

<div id="eventData">
  <p>
    <b><?php echo __('Where?') ?></b> 
    <?php 
      if (!$festival['location_id']) {
        echo $festival['customLocation']; 
      } else {
        echo link_to($festival['commonLocation']['name'], '@dak_location_show?id='. $festival['location_id']);
      } 
     ?>
  </p>
  <p>
    <b><?php echo __('When?') ?></b> 
    <?php 
    if ($festival['startDate'] == $festival['endDate']):
    ?>
    <?php echo __('%1% from %2% to %3%',  array('%1%' => format_date($festival['startDate']), '%2%' => $festival['startTime'], '%3%' => $festival['endTime'])) ?>
    <?php else: ?>
    <?php echo __('from %1% to %2%', array('%1%' => format_date($festival['startDate']) . ' ' . $festival['startTime'], '%2%' => format_date($festival['endDate']) . ' ' . $festival['endTime'])) ?>
    <?php endif ?>
  </p>
  <p>
    <b><?php echo __('Who?') ?></b>
  </p>
  <?php
  if (count($festival['arrangers']) > 0) {
    echo "<ul>\n";

    foreach ($festival['arrangers'] as $arranger) {
      echo "<li>" . link_to($arranger['name'], '@dak_arranger_show?id=' . $arranger['id']) . "</li>\n";
    }

    echo "</ul>";
  }
  ?>
  <p>
    <small><?php echo __('Created at %1%. Updated at %2%.', array('%1%' => format_datetime($festival['created_at']), '%2%' => format_datetime($festival['updated_at']))) ?></small>
  </p>
  <p>
    <?php echo link_to(__('Back to list'), '@dak_festival_index') ?>
  </p>
</div>

<div id="eventContent">
  <h2><?php echo $festival['title'] ?></h2>

 <?echo $festival->getRaw('leadParagraph'); ?>
 <?echo $festival->getRaw('description'); ?>

  <?php if (!empty($festival['linkout'])): ?>
  <p><?php echo __('Read more <a href="%1%">here</a>', array('%1%' => $festival['linkout'])) ?></p>
  <?php endif ?>

  <h2><?php echo __('Events at this festival') ?></h2>

  <?php include_partial('dakEvent/listShortDescription', array('events' => $pager->getResults())) ?>

  <?php if ($pager->haveToPaginate()): ?>
    <?php include_partial('global/pager', array('route' => '@dak_festival_show?id=' . $festival['id'], 'pager' => $pager)) ?>
  <?php endif ?>
</div>





