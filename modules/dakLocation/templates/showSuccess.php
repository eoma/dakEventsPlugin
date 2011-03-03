<?php use_helper('Date') ?>
<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', $location['name'] . ' - ' . __('Location')) ?>
<?php slot('feeds', auto_discovery_link_tag('atom', '@dak_api_filteredEvents?sf_format=atom&location_id=' . $festival['id'], array('title' => __('Events for %1%', $location['name'])))) ?>

<h1><?php echo $location['name'] ?></h1>

<?php echo $location->getRaw('description') ?>

<p><small><?php echo __('Created at %1%. Updated at %2%.', array('%1%' => format_datetime($location['created_at']), '%2%' => format_datetime($location['updated_at']))) ?></small></p>

<a href="<?php echo url_for('@dak_location_index') ?>"><?php echo __('Back to list') ?></a>

<h2><?php echo __('Events scheduled for %1%', array('%1%' => $location['name'])) ?></h2>

<p>
  <label><input type="radio" name="menu" checked="checked" onclick="$('#itemView').show();$('#calendarView').hide()" />Show in item view</label>
  <label><input type="radio" name="menu" onclick="$('#itemView').hide();$('#calendarView').show()" />Show in calendar view</label>
</p>

<div id="itemView">
<?php  include_partial('dakEvent/listShortDescription', array('events' => $pager->getResults())) ?>

<?php  if ($pager->haveToPaginate()): ?>
  <?php include_partial('dakGlobal/pager', array('route' => '@dak_location_show?id=' . $location['id'], 'pager' => $pager)) ?>
<?php endif ?>
</div>
<div id="calendarView">
  <?php include_partial('dakGlobal/fullCalendar', array('url' => '@dak_api_filteredEvents', 'extraUrlQuery' => 'location_id=' . $location['id'])) ?>
</div>
