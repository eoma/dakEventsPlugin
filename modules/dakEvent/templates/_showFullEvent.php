<?php 
use_helper('Date', 'I18N');

//
// This is a partial template for use in both frontend and backend
//

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
}

?>
<h1><?php echo $event['title'] ?></h1>

<div id="eventData">
  <p>
    <strong><?php echo __('Where?') ?></strong> 
    <?php 
      if (!$event['location_id']) {
        echo $event['customLocation']; 
       } else {
        echo link_to($event['commonLocation']['name'], $rp['location'] . '_show?id='. $event['location_id']);
      } 
     ?>
  </p>
  <p>
    <strong><?php echo __('When?') ?></strong>
    <?php 
      if ($event['startDate'] == $event['endDate']) {
        echo __('%1% from %2% to %3%',  array('%1%' => format_date($event['startDate']), '%2%' => $event['startTime'], '%3%' => $event['endTime']));
      } else {
        echo __('from %1% to %2%', array('%1%' => format_date($event['startDate']) . ' ' . $event['startTime'], '%2%' => format_date($event['endDate']) . ' ' . $event['endTime']));
      }
    ?>
  </p>
  <p>
    <strong><?php echo __('Who?') ?></strong>
    <?php echo link_to($event['arranger']['name'], $rp['arranger'] . '_show?id=' . $event['arranger_id']) ?>
  </p>
  <p>
    <strong><?php echo __('What?') ?></strong>
    <?php foreach ($event['categories'] as $c) echo link_to($c['name'], $rp['category'] . '_show?id=' . $c['id']) . ' '; ?>
  </p>
  <?php if ($event['festival_id'] > 0): ?>
  <p>
    <?php echo __('Part of') . ' ' . link_to($event['festival']['title'] . ' ' . format_date($event['festival']['startDate']), $rp['festival'] .  '_show?id=' . $event['festival_id']); ?>
  </p>
  <?php endif ?>
  <p>
    <small><?php echo __('Created at %1%. Updated at %2%.', array('%1%' => format_datetime($event['created_at']), '%2%' => format_datetime($event['updated_at']))) ?></small>
  </p>
</div>

<div id="eventContent">
  <h2><?php echo $event['title'] ?></h2>

 <?echo $event->getRaw('leadParagraph'); ?>
 <?echo $event->getRaw('description'); ?>

  <?php if (!empty($event['linkout'])): ?>
  <p><?php echo __('Read more <a href="%1%">here</a>', array('%1%' => $events['linkout'])) ?></p>
  <?php endif ?>

</div>
