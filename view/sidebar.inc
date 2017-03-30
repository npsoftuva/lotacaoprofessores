<?php
  $atual = explode("/",$_SERVER['PHP_SELF'])[count(explode("/",$_SERVER['PHP_SELF']))-1];
  $atual = explode(".", $atual)[0]
?>
<div class="sidebar">
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
      <li <?php if ($atual == "index") echo 'class="active"';?> >
        <a href="index.php">
          <i class="pe-7s-home"></i><p>Dashboard</p>
        </a>
      </li>
      <li <?php if ($atual == "professor") echo 'class="active"';?> >
        <a href="professor.php">
          <i class="pe-7s-users"></i><p>Professor</p>
        </a>
      </li>
      <li <?php if ($atual == "disciplina") echo 'class="active"';?> >
        <a href="disciplina.php">
          <i class="pe-7s-notebook"></i><p>Disciplina</p>
        </a>
      </li>
      <li <?php if ($atual == "sala") echo 'class="active"';?> >
        <a href="sala.php">
          <i class="pe-7s-display2"></i><p>Sala</p>
        </a>
      </li>
      <li <?php if ($atual == "fluxo") echo 'class="active"';?> >
        <a href="fluxo.php">
          <i class="pe-7s-refresh-2"></i><p>Fluxo</p>
        </a>
      </li>
      <li <?php if ($atual == "calendario") echo 'class="active"';?> >
        <a href="calendario.php">
          <i class="pe-7s-date"></i><p>Calendário</p>
        </a>
      </li>
    </ul>
  </div>
</div>