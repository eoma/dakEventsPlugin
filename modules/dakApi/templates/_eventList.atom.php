<?php use_helper('Date', 'dakEvent') ?>
<?php foreach ($events as $e): ?>
    <entry>
      <title>
        <?php echo $e['title'] . "\n" ?>
      </title>
      <link href="<?php echo url_for('@dak_event_show?id=' . $e['id'], true) ?>" />
      <id><?php echo url_for('@dak_event_show?id=' . $e['id'], true) ?></id>
      <updated><?php echo gmstrftime('%Y-%m-%dT%H:%M:%SZ', strtotime($e['updated_at'])) ?></updated>
      <content type="xhtml">
        <div xmlns="http://www.w3.org/1999/xhtml" class="vevent">
          <h2 class="summary">
            <?php echo $e['title']; ?>
          </h2>
          <abbr class="dtstamp" title="<?php echo gmstrftime('%Y-%m-%dT%H:%M:%SZ', strtotime($e['created_at'])) ?>" />
          <abbr class="last-modified" title="<?php echo gmstrftime('%Y-%m-%dT%H:%M:%SZ', strtotime($e['updated_at'])) ?>" />
          <p>
            <strong><?php echo __('Location') ?>:</strong> <span class="location"><?php echo dakEventHelper::getLocation($e) ?></span><br />
            <strong><?php echo __('Start') ?>:</strong>
            <abbr class="dtstart" title="<?php echo $e['startDate'] . 'T' . $e['startTime'] . 'Z' ?>">
              <?php echo format_datetime($e['startDate'] . ' ' . $e['startTime']) ?>
            </abbr><br />
            <strong><?php echo __('End') ?>:</strong>
            <abbr class="dtend" title="<?php echo $e['endDate'] . 'T' . $e['endTime'] . 'Z' ?>">
              <?php echo format_datetime($e['endDate'] . ' ' . $e['endTime']) ?>
            </abbr><br />
            <?php if (strlen($e['covercharge']) > 0): ?>
            <strong><?php echo __('Covercharge') ?>:</strong> <?php echo $e['covercharge'] ?><br />
            <?php endif ?>
            <strong><?php echo __('Arranger') ?>:</strong> <?php echo $e['arranger']['name'] ?><br />
            <strong><?php echo __('Category') ?>:</strong> <ul><?php foreach($e['categories'] as $c) { echo '<li>' . $c['name'] . '</li>'; } ?></ul>
          </p>
 
	  <?php if ($e['festival_id'] > 0): ?>
      <p>
	    <?php echo __('Part of festival') . "\n" ?>
	    <?php echo link_to($e['festival']['title'] . ' ' . format_date($e['festival']['startDate']), '@dak_festival_show?id=' . $e['festival_id'], array('absolute' => true)) . "\n" ?>
	  </p>
	  <?php endif ?>

          <?php if (isset($e['leadParagraph'])): ?>
          <p class="description">
            <?php echo $e->getRaw('leadParagraph') ?>
          </p>
          <?php endif ?>
          
          <p>
            <small><a href="<?php echo $e['ical'] ?>"><?php echo __('Add event to your calendar (iCalendar format)') ?></a></small>
          </p>
        </div>
      </content>
      <?php foreach ($e['categories'] as $c): ?>
      <category term="<?php echo $c['name'] ?>" />
      <?php endforeach ?>
      <gd:when startTime="<?php echo $e['startDate'] . 'T' . $e['startTime'] . 'Z' ?>" endTime="<?php echo $e['endDate'] . 'T' . $e['endTime'] . 'Z' ?>" />
      <gd:where label="<?php echo dakEventHelper::getLocation($e) ?>" />
    </entry>
<?php endforeach ?>
