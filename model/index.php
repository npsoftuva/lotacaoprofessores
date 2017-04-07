<?php
  include_once('Fluxo.class.php');
  include_once('Disciplina.class.php');
  include_once('Componente.class.php');

  $f1 = new Fluxo();
  $f1->setAll("20121","1","9");
  $f2 = new Fluxo();
  $f2->setAll("20161","2","8");

  $F[] = $f1;
  $F[] = $f2;

  $d1 = new Disciplina();
  $d1->setAll("1", "CANA");
  $d2 = new Disciplina();
  $d2->setAll("2", "Estrutura");

  $D[] = $d1;
  $D[] = $d2;

  $c1 = new Componente();
  $c1->setAll($f1, $d1, "5", "80");
  $c2 = new Componente();
  $c2->setAll($f2, $d2, "1", "80");

  $C[] = $c1;
  $C[] = $c2;
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    var fluxo = {};
    var disciplina = {};

    <?php foreach ($F as $f) { ?>
      fluxo[<?php echo $f->__get("flx_cod"); ?>] = [
      <?php for ($i = 1; $i < $f->__get("flx_sem"); $i++) { ?>
      {display: "<?php echo $i; ?>", value: "<?php echo $i; ?>" },
      <?php } ?>
      {display: "<?php echo $f->__get('flx_sem'); ?>", value: "<?php echo $f->__get('flx_sem'); ?>" }
      ];
    <?php } ?>
        
    $("#fluxo").change(function() {
      var parent = $(this).val();
      list(fluxo[parent]);
    });
    
    list(fluxo[<?php echo $F[0]->__get('flx_cod');?>]);

    function list(array_list) {
      $("#semestre").html("");
      $(array_list).each(function (i) {
        $("#semestre").append("<option value="+array_list[i].value+">"+array_list[i].display+"</option>");
      });
    }

    <?php foreach ($C as $c) { ?>
      disciplina[<?php echo $c->__get("flx_cod")->__get("flx_cod"); ?>][<?php echo $c->__get("cmp_sem"); ?>] = [
      {display: "<?php echo $c->__get('dcp_cod')->__get('dcp_cod'); ?>", value: "<?php echo $c->__get('dcp_cod')->__get('dcp_nom'); ?>" }
      ];
    <?php } ?>

    $("#semestre").change(function() {
      var semestre = $(this).val();
      listDisc(disciplina[$("#fluxo").val()][semestre]);
    });

    listDisc(disciplina[<?php echo $C[1]->__get('flx_cod')->__get('flx_cod');?>][<?php echo $C[1]->__get('cmp_sem');?>]);

    function listDisc(array_list) {
      $("#disciplina").html("");
      $(array_list).each(function (i) {
        $("#disciplina").append("<option value="+array_list[i].value+">"+array_list[i].display+"</option>");
      });
    }
  });
</script>

Category :
<select name="fluxo" id="fluxo">
  <?php foreach ($F as $f) { ?>
  <option value="<?php echo $f->__get("flx_cod"); ?>"><?php echo $f->__get("flx_cod"); ?></option>
  <?php } ?>
</select>
<select name="semestre" id="semestre"></select>
<select name="disciplina" id="disciplina"></select>




