<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', __('Event list')) ?>
<h1><?php echo __('Event list') ?></h1>

<p>
  <a href="<?php echo url_for('@dak_api_upcomingEvents?sf_format=ical') ?>">
    <?php echo __('Add upcoming events to your calendar (iCalendar format)') ?>
  </a>
</p>

<?php include_partial('listShortDescription', array('events' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_event_index', 'pager' => $pager)) ?>
<?php endif; ?>
