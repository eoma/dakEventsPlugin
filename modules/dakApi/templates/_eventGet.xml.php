  <event>
    <id><?php echo $event['id'] ?></id>
    <title><?php echo $event['title'] ?></title>
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
      <startDate><?php echo $event['festival']['startDate'] ?></startDate>
      <startTime><?php echo $event['festival']['startTime'] ?></startTime>
    </festival>
    <?php endif ?>
  </event>
