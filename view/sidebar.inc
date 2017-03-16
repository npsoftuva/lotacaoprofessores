<?php
  $atual = explode("/",$_SERVER['PHP_SELF'])[count(explode("/",$_SERVER['PHP_SELF']))-1];
?>
<div class="sidebar" data-color="blue">
  <!--
    Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
    Tip 2: you can also add an image using data-image tag
  -->

  <div class="sidebar-wrapper">
    <div class="logo">
      <a href="/" class="simple-text">
        LotaProf
      </a>
    </div>

    <ul class="nav">
      <li <?php if ($atual == "index.php") echo 'class="active"';?> >
        <a href="index.php">
          <i class="pe-7s-home"></i><p>Dashboard</p>
        </a>
      </li>
      <li <?php if ($atual == "professor.php") echo 'class="active"';?> >
        <a href="professor.php">
          <i class="pe-7s-users"></i><p>Professor</p>
        </a>
      </li>
      <li <?php if ($atual == "disciplina.php") echo 'class="active"';?> >
        <a href="disciplina.php">
          <i class="pe-7s-notebook"></i><p>Disciplina</p>
        </a>
      </li>
      <li <?php if ($atual == "sala.php") echo 'class="active"';?> >
        <a href="sala.php">
          <i class="pe-7s-display2"></i><p>Sala</p>
        </a>
      </li>
    </ul>
  </div>
</div>