<?php 
use_helper('Date');
?>

<div id="eventData">
  <p>
    <b>Where?</b> 
    <?php 
      if (!$dak_event['location_id']) {
        echo $dak_event['customLocation']; 
       } else {
        echo link_to($dak_event['commonLocation']['name'], '@dak_location_admin_show?id='. $dak_event['location_id']);
      } 
     ?>
  </p>
  <p>
    <b>When?</b> 
    <?php 
    if ($dak_event['startDate'] == $dak_event['endDate']):
    ?>
    <?php echo format_date($dak_event['startDate']) ?> from <? echo $dak_event['startTime'] ?> to <?php echo $dak_event['endTime'] ?>
    <?php else: ?>
    from <?php echo format_date($dak_event['startDate']) . ' ' . $dak_event['startTime'] ?> to <?php echo format_date($dak_event['endDate']) . ' ' . $dak_event['endTime'] ?>
    <?php endif ?>
  </p>
  <p>
    <b>Who?</b> <?php echo link_to($dak_event['arranger']['name'], '@dak_arranger_admin_show?id=' . $dak_event['arranger_id']) ?>
  </p>
  <p>
    <b>What?</b> <?php foreach ($dak_event['categories'] as $c) { echo link_to($c['name'], '@dak_category_admin_show?id=' . $c['id']) .' '; } ?>
  </p>
  <p>
    <small>Created at <?php echo format_datetime($dak_event['created_at']) ?>. Updated at <?php echo format_datetime($dak_event['updated_at']) ?>.</small>
  </p>
</div>

<div id="eventContent">
  <h2><?php echo $dak_event['title'] ?></h2>

 <?echo $dak_event->getRaw('leadParagraph'); ?>
 <?echo $dak_event->getRaw('description'); ?>

  <?php if (!empty($dak_event['linkout'])): ?>
  <p>Read more <a href="<?php echo $dak_event['linkout'] ?>">here</a></p>
  <?php endif ?>

</div>
