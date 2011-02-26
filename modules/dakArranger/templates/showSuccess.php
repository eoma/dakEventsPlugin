<?php include_partial('dakGlobal/assets') ?>
<?php use_helper('Date') ?>
<?php slot('title', $arranger['name'] . ' - ' . __('Arranger')) ?>

<h1><?php echo $arranger['name'] ?></h1>

<?php echo $arranger->getRaw('description') ?>

<p><small><?php echo __('Created at %1%. Updated at %2%.', array('%1%' => format_datetime($arranger['created_at']), '%2%' => format_datetime($arranger['updated_at']))) ?></small></p>

<a href="<?php echo url_for('@dak_arranger_index') ?>"><?php echo __('Back to list') ?></a>

<h2 id="events"><?php echo __('Events scheduled for %1%', array('%1%' => $arranger['name'])) ?></h2>

<p>
<?php echo link_to(
        __('Add events for this arranger to your calendar'),
        '@dak_api_filteredEvents?sf_format=ical',
        array(
          'query_string' => 'arranger_id=' . $arranger['id'],
          'absolute' => true,
        )
      );
?>
</p>

<?php include_partial('dakEvent/listShortDescription', array('events' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_arranger_show?id=' . $arranger['id'], 'pager' => $pager)) ?>
<?php endif ?>
