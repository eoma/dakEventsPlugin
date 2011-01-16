<categories>
  <?php foreach ($categories as $c): ?>
  <category>
    <id><?php echo $c['id'] ?></id>
    <name><?php echo $c['name'] ?></name>
  </category>
  <?php endforeach ?>
</categories>
