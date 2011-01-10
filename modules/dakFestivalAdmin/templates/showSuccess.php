<?php
use_helper('I18N', 'Date');
?>

<div id="eventData">
  <ul>
    <?php echo $helper->linkToEdit($dak_festival, array('params' => array(), 'class_suffix' => 'edit', 'label' => 'Edit')) ?>
    <?php echo $helper->linkToDelete($dak_festival, array('params' => array(), 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete')) ?>
    <li><?php echo link_to('Add event to this festival', '@dak_event_admin_new?festival_id=' . $dak_festival['id']) ?></li>
  </ul>
  <p>
    <b>Where?</b> 
    <?php 
      if (!$festival['location_id']) {
        echo $festival['customLocation']; 
      } else {
        echo link_to($festival['commonLocation']['name'], '@dak_location_admin_show?id='. $dak_festival['location_id']);
      } 
     ?>
  </p>
  <p>
    <b>When?</b> 
    <?php 
    if ($dak_festival['startDate'] == $dak_festival['endDate']):
    ?>
    <?php echo format_date($dak_festival['startDate']) ?> from <? echo $dak_festival['startTime'] ?> to <?php echo $dak_festival['endTime'] ?>
    <?php else: ?>
    from <?php echo format_date($dak_festival['startDate']) . ' ' . $dak_festival['startTime'] ?> to <?php echo format_date($dak_festival['endDate']) . ' ' . $festival['endTime'] ?>
    <?php endif ?>
  </p>
  <p>
    <b>Who?</b>
  </p>
  <?php
  if (count($dak_festival['arrangers']) > 0) {
    echo "<ul>\n";

    foreach ($dak_festival['arrangers'] as $arranger) {
      echo "<li>" . link_to($arranger['name'], '@dak_arranger_admin_show?id=' . $arranger['id']) . "</li>\n";
    }

    echo "</ul>";
  }
  ?>
  <p>
    <b>What?</b> <?php //echo link_to($dak_festival['category']['name'], '@dak_category_admin_show?id=' . $dak_festival['category_id'])?>
  </p>
  <p>
    <small>Created at <?php echo format_datetime($dak_festival['created_at']) ?>. Updated at <?php echo format_datetime($dak_festival['updated_at']) ?>.</small>
  </p>
  <p>
    <?php echo link_to('Back to list', '@dak_festival_admin') ?>
  </p>
</div>

<div id="eventContent">
  <h2><?php echo $dak_festival['title'] ?></h2>

 <?echo $dak_festival->getRaw('leadParagraph'); ?>
 <?echo $dak_festival->getRaw('description'); ?>

  <?php if (!empty($dak_festival['linkout'])): ?>
  <p>Read more <a href="<?php echo $dak_festival['linkout'] ?>">here</a></p>
  <?php endif ?>

  <h2>Events at this festival</h2>

  <?php if (count($dak_festival['events']) > 0): ?>
  <table>
    <tbody>
      <?php foreach ($dak_festival['events'] as $dak_event): ?>
      <tr>
        <td>
          <?php echo link_to($dak_event['title'], '@dak_event_admin_show?id=' . $dak_event['id']) ?><br />
          <?php include_partial('dakEventAdmin/startEndDateTime', array('dak_event' => $dak_event)) ?><br />
          Location: <?php include_partial('dakEventAdmin/location', array('dak_event' => $dak_event)) ?><br />
          Categories: <?php foreach ($dak_event['categories'] as $c) { echo link_to($c, '@dak_category_admin_show?id=' . $c['id']) . " "; } ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <p>No events at this festival</p>
  <?php endif ?>
</div>





