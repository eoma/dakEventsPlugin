<?php
use_helper('I18N', 'Date');
?>

<div id="eventData">
  <ul>
    <?php echo $helper->linkToEdit($festival, array('params' => array(), 'class_suffix' => 'edit', 'label' => 'Edit')) ?>
    <?php echo $helper->linkToDelete($festival, array('params' => array(), 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete')) ?>
    <li><?php echo link_to('Add event to this festival', '@event_new?festival_id=' . $festival['id']) ?></li>
  </ul>
  <p>
    <b>Where?</b> 
    <?php 
      if (!$festival['location_id']) {
        echo $festival['customLocation']; 
      } else {
        echo link_to($festival['commonLocation']['name'], '@location_show?id='. $festival['location_id']);
      } 
     ?>
  </p>
  <p>
    <b>When?</b> 
    <?php 
    if ($festival['startDate'] == $festival['endDate']):
    ?>
    <?php echo format_date($festival['startDate']) ?> from <? echo $festival['startTime'] ?> to <?php echo $festival['endTime'] ?>
    <?php else: ?>
    from <?php echo format_date($festival['startDate']) . ' ' . $festival['startTime'] ?> to <?php echo format_date($festival['endDate']) . ' ' . $festival['endTime'] ?>
    <?php endif ?>
  </p>
  <p>
    <b>Who?</b>
  </p>
  <?php
  if (count($festival['arrangers']) > 0) {
    echo "<ul>\n";

    foreach ($festival['arrangers'] as $arranger) {
      echo "<li>" . link_to($arranger['name'], '@arranger_show?id=' . $arranger['id']) . "</li>\n";
    }

    echo "</ul>";
  }
  ?>
  <p>
    <b>What?</b> <?php //echo link_to($festival['category']['name'], '@category_show?id=' . $festival['category_id'])?>
  </p>
  <p>
    <small>Created at <?php echo format_datetime($festival['created_at']) ?>. Updated at <?php echo format_datetime($festival['updated_at']) ?>.</small>
  </p>
  <p>
    <?php echo link_to('Back to list', '@festival') ?>
  </p>
</div>

<div id="eventContent">
  <h2><?php echo $festival['title'] ?></h2>

 <?echo $festival->getRaw('leadParagraph'); ?>
 <?echo $festival->getRaw('description'); ?>

  <?php if (!empty($festival['linkout'])): ?>
  <p>Read more <a href="<?php echo $festival['linkout'] ?>">here</a></p>
  <?php endif ?>

  <h2>Events at this festival</h2>

  <?php if (count($festival['events']) > 0): ?>
  <table>
    <tbody>
      <?php foreach ($festival['events'] as $event): ?>
      <tr>
        <td>
          <?php echo link_to($event['title'], '@event_show?id=' . $event['id']) ?><br />
          <?php include_partial('event/startEndDateTime', array('event' => $event)) ?><br />
          Location: <?php include_partial('event/location', array('event' => $event)) ?><br />
          Categories: <?php foreach ($event['categories'] as $c) { echo link_to($c, '@category_show?id=' . $c['id']) . " "; } ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <p>No events at this festival</p>
  <?php endif ?>
</div>





