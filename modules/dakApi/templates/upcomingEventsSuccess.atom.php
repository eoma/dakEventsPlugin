<?php use_helper('Date') ?>
<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n" ?>
<feed xmlns="http://www.w3.org/2005/Atom">

<title><?php echo __('Event calendar') ?></title>
<subtitle><?php echo __('Upcoming events') ?></subtitle>
<link href="<?php echo url_for('@dak_api_upcomingEvents?sf_format=atom', true) ?>" rel="self"/>
<link href="<?php echo url_for('@homepage', true) ?>"/>
<updated><?php echo gmstrftime('%Y-%m-%dT%H:%M:%SZ', $latestUpdate) ?></updated>
<author>
  <name><?php echo __('Event calendar') ?></name>
</author>
<id><?php echo url_for('@dak_api_upcomingEvents?sf_format=atom', true) ?></id>

<?php include_partial('eventList', array('events' => $data['data'])) ?>

</feed>
