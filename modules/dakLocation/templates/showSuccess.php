<?php use_helper('Date') ?>
<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', $location['name'] . ' - ' . __('Location')) ?>

<h1><?php echo $location['name'] ?></h1>

<?php echo $location->getRaw('description') ?>

<p><small><?php echo __('Created at %1%. Updated at %2%.', array('%1%' => format_datetime($location['created_at']), '%2%' => format_datetime($location['updated_at']))) ?></small></p>

<a href="<?php echo url_for('@dak_location_index') ?>"><?php echo __('Back to list') ?></a>

<h2><?php echo __('Events scheduled for %1%', array('%1%' => $location['name'])) ?></h2>

<?php include_partial('dakEvent/listShortDescription', array('events' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_location_show?id=' . $location['id'], 'pager' => $pager)) ?>
<?php endif ?>
