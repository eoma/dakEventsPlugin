<?php 
use_helper('Date');
?>

<div id="eventData">
  <p>
    <b>Where?</b> 
    <?php 
      if (!$event['location_id']) {
        echo $event['customLocation']; 
       } else {
        echo link_to($event['commonLocation']['name'], '@dak_location_admin_show/?id='. $event['location_id']);
      } 
     ?>
  </p>
  <p>
    <b>When?</b> 
    <?php 
    if ($event['startDate'] == $event['endDate']):
    ?>
    <?php echo format_date($event['startDate']) ?> from <? echo $event['startTime'] ?> to <?php echo $event['endTime'] ?>
    <?php else: ?>
    from <?php echo format_date($event['startDate']) . ' ' . $event['startTime'] ?> to <?php echo format_date($event['endDate']) . ' ' . $event['endTime'] ?>
    <?php endif ?>
  </p>
  <p>
    <b>Who?</b> <?php echo link_to($event['arranger']['name'], '@dak_arranger_admin_show/?id=' . $event['arranger_id']) ?>
  </p>
  <p>
    <b>What?</b> <?php foreach ($event['categories'] as $c) { echo link_to($c['name'], '@dak_category_admin_show/?id=' . $c['id']) .' '; } ?>
  </p>
  <p>
    <small>Created at <?php echo format_datetime($event['created_at']) ?>. Updated at <?php echo format_datetime($event['updated_at']) ?>.</small>
  </p>
</div>

<div id="eventContent">
  <h2><?php echo $event['title'] ?></h2>

 <?echo $event->getRaw('leadParagraph'); ?>
 <?echo $event->getRaw('description'); ?>

  <?php if (!empty($event['linkout'])): ?>
  <p>Read more <a href="<?php echo $events['linkout'] ?>">here</a></p>
  <?php endif ?>

</div>
