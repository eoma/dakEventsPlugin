<?php // This partial demands a list of events ?>
<?php use_helper('HtmlList') ?>

<?php

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

<table id="eventList" class="dak_padded_table">
  <tbody>
    <?php foreach ($events as $event): ?>
    <tr class="<?php echo HtmlList::Alternate('odd','even'); ?>">
      <td>
        <?php if($event['primaryPicture_id'] > 0) 
          include_partial('dakGlobal/picture', array('picture' => $event['primaryPicture'], 'format' => 'list'));
        ?>
        <div class="shortEvent">
          <?php echo link_to($event['title'], $rp['event'] . '_show?id=' . $event['id']) ?><br />
          <span>
            <?php
            if (strlen(strip_tags($event->getRaw('leadParagraph'))) > 100) { 
              echo substr(strip_tags($event->getRaw('leadParagraph')), 0, 97) . '...';
            } else {
              echo strip_tags($event->getRaw('leadParagraph'));
            }
            ?>
          </span><br />
          <?php echo __('When?') ?> <?php include_partial('dakEvent/startEndDateTime', array('event' => $event)) ?><br />
          <?php echo __('Location') ?>: <?php include_partial('dakEvent/location', array('event' => $event)) ?><br />
          <?php if (strlen($event['covercharge']) > 0): ?>
            <?php echo __('Covercharge') ?>: <?php echo $event['covercharge'] ?><br />
          <?php endif ?>
          <?php if (strlen($event['age_limit']) > 0): ?>
            <?php echo __('Age limit') ?>: <?php echo $event['age_limit'] ?><br />
          <?php endif ?>
          <?php echo __('Arranger') ?>: <?php echo link_to($event['arranger']['name'], $rp['arranger'] . '_show?id=' . $event['arranger_id']) ?><br />
          <?php echo __('Categories') ?>: <?php foreach ($event['categories'] as $c) echo link_to($c['name'], $rp['category'] . '_show?id=' . $c['id']) . " "; ?><br />
          <?php if ($event['festival_id'] > 0): ?> 
            <?php echo __('Part of festival') ?>
            <?php echo link_to($event['festival']['title'] . ' ' . format_date($event['festival']['startDate']), $rp['festival'] . '_show?id=' . $event['festival_id']) ?>
          <?php endif ?>
        </div>
      </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
