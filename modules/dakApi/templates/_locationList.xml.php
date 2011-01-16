<locations>
  <?php foreach ($locations as $l): ?>
  <location>
    <id><?php echo $l['id'] ?></id>
    <name><?php echo $l['name'] ?></name>
  </location>
  <?php endforeach ?>
</locations>
