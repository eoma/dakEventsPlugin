  <event>
    <id><?php echo $event['id'] ?></id>
    <title><?php echo $event['title'] ?></title>
    <url><?php echo $event['url'] ?></url>
    <leadParagraph><?php echo $event['leadParagraph'] ?></leadParagraph>
    <description><?php echo $event['description'] ?></description>
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
        <width><?php echo $event['primaryPicture']['thumb']['height'] ?></width>
      </thumb>
    </primaryPicture>
    <?php endif ?>
    <?php if (count($event['pictures']) > 0): ?>
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
          <width><?php echo $p['thumb']['height'] ?></width>
        </thumb>
      </picture>
      <?php endforeach ?>
    </pictures>
    <?php endif ?>
  </event>
