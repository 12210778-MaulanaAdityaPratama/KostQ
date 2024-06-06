<div class="bs-callout bs-callout-primary mt-3">
  <h4><i class="fa fa-newspaper-o"></i> Promosi Terbaru</h4>
</div>
<ul class="list-group">
  <?php
  foreach ($promosi_sidebar as $promosi_sidebar) {
  ?>
    <li class="list-group-item">
      <span class="badge">NEW</span>
      <?php echo anchor('promosi/read/' . $promosi_sidebar->slug_promosi . '', '' . $promosi_sidebar->nama_promosi . '') ?>
    </li>
  <?php } ?>
</ul>