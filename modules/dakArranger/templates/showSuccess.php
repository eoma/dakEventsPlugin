<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', $arranger['name'] . ' - ' . __('Arranger')) ?>
<h1><?php echo $arranger['name'] ?></h1>

<table>
  <tbody>
    <tr>
      <th><?php echo __('Id') ?>:</th>
      <td><?php echo $arranger['id'] ?></td>
    </tr>
    <tr>
      <th><?php echo __('Name') ?>:</th>
      <td><?php echo $arranger['name'] ?></td>
    </tr>
    <tr>
      <th><?php echo __('Description') ?>:</th>
      <td><?php echo $arranger['description'] ?></td>
    </tr>
    <tr>
      <th><?php echo __('Created at') ?>:</th>
      <td><?php echo $arranger['created_at'] ?></td>
    </tr>
    <tr>
      <th><? echo __('Updated at') ?>:</th>
      <td><?php echo $arranger['updated_at'] ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('@dak_arranger_index') ?>"><?php echo __('Back to list') ?></a>

<h2 id="events"><?php echo __('Events scheduled for %1%', array('%1%' => $arranger['name'])) ?></h2>

<?php include_partial('dakEvent/listShortDescription', array('events' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_arranger_show?id=' . $arranger['id'], 'pager' => $pager)) ?>
<?php endif ?>
