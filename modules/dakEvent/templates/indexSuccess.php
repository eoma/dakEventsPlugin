<?php slot('title', __('Event list')) ?>
<h1><?php echo __('Event list') ?></h1>

<?php include_partial('listShortDescription', array('events' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_event_index', 'pager' => $pager)) ?>
<?php endif; ?>
