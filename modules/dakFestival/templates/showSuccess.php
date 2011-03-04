<?php
include_partial('dakGlobal/assets');
use_helper('I18N', 'Date');
slot('title', $festival['title'] . ' - ' . __('Festival'));
slot('feeds',
  auto_discovery_link_tag('atom', '@dak_api_filteredEvents?sf_format=atom&festival_id=' . $festival['id'], 
    array(
      'title' => __('Events for %1%', array('%1%' => $festival['title'] . ' ' . $festival['startDate']))
    )
  )
) ?>

<?php include_partial('dakFestival/showFullFestival', array('festival' => $festival, 'pager' => $pager)); ?>


