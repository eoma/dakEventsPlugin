<?php slot('title', $location['name'] . ' - ' . __('Location')) ?>
<h1><?php echo $location['name'] ?></h1>

<table>
  <tbody>
    <tr>
      <th><?php echo __('Id') ?>:</th>
      <td><?php echo $location['id'] ?></td>
    </tr>
    <tr>
      <th><?php echo __('Name') ?>:</th>
      <td><?php echo $location['name'] ?></td>
    </tr>
    <tr>
      <th><?php echo __('Description') ?>:</th>
      <td><?php echo $location['description'] ?></td>
    </tr>
    <tr>
      <th><?php echo __('Created at') ?>:</th>
      <td><?php echo $location['created_at'] ?></td>
    </tr>
    <tr>
      <th><?php echo __('Updated at') ?>:</th>
      <td><?php echo $location['updated_at'] ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('@dak_location_index') ?>"><?php echo __('Back to list') ?></a>

<h2><?php echo __('Events scheduled for %1%', array('%1%' => $location['name'])) ?></h2>

<?php include_partial('dakEvent/listShortDescription', array('events' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_location_show?id=' . $location['id'], 'pager' => $pager)) ?>
<?php endif ?>
