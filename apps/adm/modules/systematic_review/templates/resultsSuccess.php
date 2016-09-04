<?php ob_start();?>
<ul class="dropdown-menu">
  <li><a href="http://www.york.ac.uk/inst/crd/pdf/Systematic_Reviews.pdf" target="_blank"><i class="icon-external-link"></i> Undertaking Systematic Review of Research on Effectiveness. <br />CRD’s Guidance for those Carrying Out or Commissioning Reviews<br>- Khan <em>et al.</em>, 2001</a></li>
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('support' => $support, 'id' => $id));
?>
<?php if ($sf_user->hasCredential('systematic')) : ?>
  <div class="rows-fluid">
    <div class="span3 bs-docs-sidebar">
      <ul id="submenu" class="nav nav-list bs-docs-sidenav affix span3">
        <li><a href="#dosestudos"><i class="icon-chevron-right"></i> <?php echo __('A respeito dos Estudos') ?></a></li>
        <li><a href="#resultados"><i class="icon-chevron-right"></i> <?php echo __('Resultados Obtidos') ?></a></li>
        <li><a href="#info"><i class="icon-chevron-right"></i> <?php echo __('Informações Adicionais') ?></a></li>
        <!--  <li class="active"><a href="<?php //echo 'systematic_review/resultsView?id='.$id ?>"><i class="icon-download"></i> <?php //echo __('Visualizar Relatório') ?></a></li> -->
        <li class="active"><a href="<?php echo url_for('systematic_review/resultsDownload?id='.$id) ?>"><i class="icon-download"></i> <?php echo __('Download do Relatório (.docx)') ?></a></li>
      </ul>
    </div>
    <div class="span9">
        <h2><?php echo __('Formatar o Relatório Principal') ?></h2>
        <?php include '_form_results.php' ?>
    </div>
  </div>

  <script type="text/javascript">
    $('#rsl_result_data_sintesys').wysihtml5();
    $('#rsl_result_class_description').wysihtml5();
    $('#rsl_result_meta_sintesys').wysihtml5();
    $('#rsl_result_results').wysihtml5();
    $('#rsl_result_discussions').wysihtml5();
    $('#rsl_result_conclusions').wysihtml5();
    $('#rsl_result_practice_implications').wysihtml5();
    $('#rsl_result_search_implications').wysihtml5();
    $('#rsl_result_appointments').wysihtml5();

    $(document).ready(function () {
      $(".finaliza").click(function(e){
        $.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $id?>, activity: 17 });
      });
    });
  </script>
<?php else : ?>
  <?php include '_restricted.php' ?>
<?php endif; ?>

<?php //include '_sidebar.php' ?>

