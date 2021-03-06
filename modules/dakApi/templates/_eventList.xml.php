<?php use_helper('Date') ?>
<events>
<?php foreach ($events as $event): ?>
  <event>
    <id><?php echo $event['id'] ?></id>
    <title><?php echo $event['title'] ?></title>
    <url><?php echo $event['url'] ?></url>
    <ical><?php echo $event['ical'] ?></ical>
    <?php if (isset($event['leadParagraph'])): ?>
    <leadParagraph><?php echo $event['leadParagraph'] ?></leadParagraph>
    <?php endif ?>
    <?php if (isset($event['description'])): ?>
    <description><?php echo $event['description'] ?></description>
    <?php endif ?>
    <startDate><?php echo $event['startDate'] ?></startDate>
    <startTime><?php echo $event['startTime'] ?></startTime>
    <endDate><?php echo $event['endDate'] ?></endDate>
    <endTime><?php echo $event['endTime'] ?></endTime>
    <createdAt><?php echo $event['created_at'] ?></createdAt>
    <updatedAt><?php echo $event['updated_at'] ?></updatedAt>
    <categories>
      <?php foreach ($event['categories'] as $c): ?>
      <category>
        <id><?php echo $c['id'] ?></id>
        <name><?php echo $c['name'] ?></name>
      </category>
      <?php endforeach ?>
    </categories>
    <arranger>
      <id><?php echo $event['arranger']['id'] ?></id>
      <name><?php echo $event['arranger']['name'] ?></name>
    </arranger>
    <?php if ($event['location_id'] > 0): ?>
    <commonLocation>
      <id><?php echo  $event['commonLocation']['id'] ?></id>
      <name><?php echo $event['commonLocation']['name'] ?></name>
    </commonLocation>
    <?php else: ?>
    <customLocation>
      <name><?php echo $event['customLocation'] ?></name>
    </customLocation>
    <?php endif ?>
    <?php if ($event['festival_id'] > 0): ?>
    <festival>
      <id><?php echo $event['festival']['id'] ?></id>
      <title><?php echo $event['festival']['title'] ?></title>
      <url><?php echo $event['festival']['url'] ?></url>
      <startDate><?php echo $event['festival']['startDate'] ?></startDate>
      <startTime><?php echo $event['festival']['startTime'] ?></startTime>
    </festival>
    <?php endif ?>
    <?php if (!empty($event['primaryPicture'])): ?>
    <primaryPicture>
      <id><?php echo $event['primaryPicture']['id'] ?></id>
      <description><?php echo $event['primaryPicture']['description'] ?></description>
      <url><?php echo $event['primaryPicture']['url'] ?></url>
      <height><?php echo $event['primaryPicture']['height'] ?></height>
      <width><?php echo $event['primaryPicture']['width'] ?></width>
      <thumb>
        <url><?php echo $event['primaryPicture']['thumb']['url'] ?></url>
        <height><?php echo $event['primaryPicture']['thumb']['height'] ?></height>
        <width><?php echo $event['primaryPicture']['thumb']['width'] ?></width>
      </thumb>
    </primaryPicture>
    <?php endif ?>
    <?php if (!empty($event['pictures'])): ?>
    <pictures>
      <?php foreach ($event['pictures'] as $p): ?>
      <picture>
        <id><?php echo $p['id'] ?></id>
        <description><?php echo $p['description'] ?></description>
        <url><?php echo $p['url'] ?></url>
        <height><?php echo $p['height'] ?></height>
        <width><?php echo $p['width'] ?></width>
        <thumb>
          <url><?php echo $p['thumb']['url'] ?></url>
          <height><?php echo $p['thumb']['height'] ?></height>
          <width><?php echo $p['thumb']['width'] ?></width>
        </thumb>
      </picture>
      <?php endforeach ?>
    </pictures>
    <?php endif ?>
    <?php if (strlen($event['covercharge']) > 0): ?>
    <covercharge><?php echo $event['covercharge'] ?></covercharge>
    <?php endif ?>
  </event>
<?php endforeach ?>
</events>
