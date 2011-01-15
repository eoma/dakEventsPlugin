<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', $category['name'] . ' - ' . __('Category')) ?>
<h1><?php echo $category['name'] ?></h1>

<table>
  <tbody>
    <tr>
      <th><?php echo __('Id') ?>:</th>
      <td><?php echo $category['id'] ?></td>
    </tr>
    <tr>
      <th><?php echo __('Name') ?>:</th>
      <td><?php echo $category['name'] ?></td>
    </tr>
    <tr>
      <th><?php echo __('Created at') ?>:</th>
      <td><?php echo $category['created_at'] ?></td>
    </tr>
    <tr>
      <th><?php echo __('Updated at') ?>:</th>
      <td><?php echo $category['updated_at'] ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('@dak_category_index') ?>"><?php echo __('Back to list') ?></a>

<h2><?php echo __('Events scheduled for %1%', array('%1%' => $category['name'])) ?></h2>

<?php include_partial('dakEvent/listShortDescription', array('events' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_category_show?id=' . $category['id'], 'pager' => $pager)) ?>
<?php endif ?>
