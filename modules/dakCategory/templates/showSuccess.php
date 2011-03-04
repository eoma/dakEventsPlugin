<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', $category['name'] . ' - ' . __('Category')) ?>
<?php slot('feeds',
  auto_discovery_link_tag('atom', '@dak_api_filteredEvents?sf_format=atom&category_id=' . $category['id'],
    array('title' => __('Events for %1%', array('%1%' => $category['name'])))
  )
) ?>

<h1><?php echo $category['name'] ?></h1>

<a href="<?php echo url_for('@dak_category_index') ?>"><?php echo __('Back to list') ?></a>

<h2><?php echo __('Events scheduled for %1%', array('%1%' => $category['name'])) ?></h2>

<?php include_partial('dakEvent/listShortDescription', array('events' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_category_show?id=' . $category['id'], 'pager' => $pager)) ?>
<?php endif ?>
