<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', $category['name'] . ' - ' . __('Category')) ?>

<h1><?php echo $category['name'] ?></h1>

<a href="<?php echo url_for('@dak_category_index') ?>"><?php echo __('Back to list') ?></a>

<h2><?php echo __('Events scheduled for %1%', array('%1%' => $category['name'])) ?></h2>

<?php include_partial('dakEvent/listShortDescription', array('events' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_category_show?id=' . $category['id'], 'pager' => $pager)) ?>
<?php endif ?>
