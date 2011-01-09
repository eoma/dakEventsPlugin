<?php use_helper('Date') ?>
<?php foreach ($events as $e): ?>
    <entry>
      <title>
        <?php echo $e['title'] . "\n" ?>
      </title>
      <link href="<?php echo url_for('@dak_event_show?id=' . $e['id'], true) ?>" />
      <id><?php echo sha1($e['id']) ?></id>
      <updated><?php echo gmstrftime('%Y-%m-%dT%H:%M:%SZ', strtotime($e['updated_at'])) ?></updated>
      <summary type="xhtml">
        <div xmlns="http://www.w3.org/1999/xhtml">
          <p>
            <strong><?php echo __('Location') ?>:</strong> <?php if ($e['location_id'] > 0) { echo $e['commonLocation']['name']; } else { echo $e['customLocation']; } ?><br />
            <strong><?php echo __('Start') ?>:</strong> <?php echo format_datetime($e['startDate'] . ' ' . $e['startTime']) ?><br />
            <strong><?php echo __('Arranger') ?>:</strong> <?php echo $e['arranger']['name'] ?><br />
            <strong><?php echo __('Category') ?>:</strong> <ul><?php foreach($e['categories'] as $c) { echo '<li>' . $c['name'] . '</li>'; } ?></ul>
          </p>
 
	  <?php if ($e['festival_id'] > 0): ?>
          <p>
	    <?php echo __('Part of festival') . "\n" ?>
	    <?php echo link_to($e['festival']['title'] . ' ' . format_date($e['festival']['startDate']), '@dak_festival_show?id=' . $e['festival_id']) . "\n" ?>
	  </p>
	  <?php endif ?>

          <p>
            <?php echo $e->getRaw('leadParagraph') ?>
          </p>
        </div>
      </summary>
    </entry>
<?php endforeach ?>
