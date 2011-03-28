<?php 
use_helper('I18N', 'Date');

// rp is an acronym for route prefix
$rp = array(
  'event'    => '@dak_event',
  'festival' => '@dak_festival',
  'location' => '@dak_location',
  'arranger' => '@dak_arranger',
  'category' => '@dak_category',
);

if (isset($inAdmin) && ($inAdmin == true)) {
  foreach ($rp as &$v) $v .= '_admin';
} else {
  $inAdmin = false;
}

?>

<h1><?php echo $festival['title'] ?></h1>

<div id="eventData">
  <p>
    <b><?php echo __('Where?') ?></b> 
    <?php 
      if (!$festival['location_id']) {
        echo $festival['customLocation']; 
      } else {
        echo link_to($festival['commonLocation']['name'], $rp['location'] . '_show?id='. $festival['location_id']);
      } 
     ?>
    <br />
    <b><?php echo __('When?') ?></b> 
    <?php 
      $startDatetime = $festival['startDate'] . ' ' . $festival['startTime'];
      $endDatetime = $festival['endDate'] . ' ' . $festival['endTime'];
      if ($festival['startDate'] == $festival['endDate']) {
        echo __('%1% from %2% to %3%',  array('%1%' => format_date($startDatetime, 'p'), '%2%' => format_date($startDatetime, 'HH:mm'), '%3%' => format_date($endDatetime, 'HH:mm')));
      } else {
        echo __('from %1% to %2%', array('%1%' => format_date($startDatetime, 'p') . ' ' . format_date($startDatetime, 'HH:mm'), '%2%' => format_date($endDatetime, 'p') . ' ' . format_date($endDatetime, 'HH:mm')));
      }
    ?>
    <br />
    <?php if (strlen($festival['covercharge']) > 0): ?>
      <b><?php echo __('Covercharge') ?></b>: <?php echo $festival['covercharge'] ?><br />
    <?php endif ?>
    <b><?php echo __('Who?') ?></b>
    <?php
    if (count($festival['arrangers']) > 0) {
      foreach ($festival['arrangers'] as $arranger) {
        echo link_to($arranger['name'], $rp['arranger'] . '_show?id=' . $arranger['id']) . " \n";
      }
    }
    ?>
    <br />
    <?php if (!isset($inAdmin) || !$inAdmin): ?>
    <?php echo link_to('Add these festival events to your calendar', '@dak_api_filteredEvents?sf_format=ical', array('query_string' => 'festival_id=' . $festival['id'])) ?><br />
    <?php endif ?>
    <small><?php echo __('Created at %1%. Updated at %2%.', array('%1%' => format_datetime($festival['created_at']), '%2%' => format_datetime($festival['updated_at']))) ?></small>
  </p>
</div>

<div id="eventContent">

 <p><?echo $festival->getRaw('leadParagraph'); ?></p>
 <?echo $festival->getRaw('description'); ?>

  <?php if (!empty($festival['linkout'])): ?>
  <p><?php echo __('Read more <a href="%1%">here</a>', array('%1%' => $festival['linkout'])) ?></p>
  <?php endif ?>

  <h2><?php echo __('Events at this festival') ?></h2>

  <?php include_partial('dakEvent/listShortDescription', array('events' => $pager->getResults(), 'inAdmin' => $inAdmin)) ?>

  <?php if ($pager->haveToPaginate()): ?>
    <?php include_partial('global/pager', array('route' => $rp['festival'] . '_show?id=' . $festival['id'], 'pager' => $pager, 'inAdmin' => $inAdmin)) ?>
  <?php endif ?>
</div>



