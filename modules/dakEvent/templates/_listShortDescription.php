<?php // This partial demands a list of events ?>
<?php use_helper('HtmlList') ?>

<table id="eventList">
  <tbody>
    <?php foreach ($events as $event): ?>
    <tr class="<?php echo HtmlList::Alternate('odd','even'); ?>">
      <td>
        <?php echo link_to($event['title'], '@dak_event_show?id=' . $event['id']) ?><br />
        <span>
          <?php 
          if (strlen($event['leadParagraph']) > 100) { 
            echo substr($event['leadParagraph'], 0, 97) . '...';
          } else {
            echo $event['leadParagraph'];
          }
          ?>
        </span><br />
        <?php echo __('When?') ?> <?php include_partial('dakEvent/startEndDateTime', array('event' => $event)) ?><br />
        <?php echo __('Location') ?>: <?php include_partial('dakEvent/location', array('event' => $event)) ?><br />
        <?php echo __('Arranger') ?>: <?php echo link_to($event['arranger']['name'], '@dak_arranger_show?id=' . $event['arranger_id']) ?><br />
        <?php echo __('Categories') ?>: <?php foreach ($event['categories'] as $c) { echo link_to($c['name'], '@dak_category_show?id=' . $c['id']) . " "; } ?><br />
        <?php if ($event['festival_id'] > 0): ?> 
          <?php echo __('Part of festival') ?>
          <?php echo link_to($event['festival']['title'] . ' ' . format_date($event['festival']['startDate']), '@dak_festival_show?id=' . $event['festival_id']) ?>
        <?php endif ?>
      </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
