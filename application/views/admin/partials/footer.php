     
            </div>
            <!-- /.container-fluid -->

<div class="spacer-100"></div>
        </div>
        <!-- /#page-wrapper -->

    </div>  
    <!-- /#wrapper -->

    <!-- jQuery -->
 
  <script>
     window.for_js = {};
      <?php if(isset($for_js)):?> 
        window.for_js = <?=json_encode($for_js)?>; 
      <?php endif; ?>
      function v(key,_default){
        if(window.for_js[key])
          return window.for_js[key];
        return _default;
      }
  </script>
 <script src="<?=base_url('env.js');?>"></script> 
 <script src="<?=base_url('assets/js/env-support.js');?>"></script> 

 <script src="<?=base_url('assets/js/jquery.js');?>"></script>
 
 <script src="<?=base_url('assets/js/mousetrap.min.js');?>"></script>
 <script src="<?=base_url('assets/js/ctrl-q-click.js');?>"></script>

 <script src="<?=base_url('assets/js/bootstrap.min.js');?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/chosen.jquery.js')?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/select2.js')?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/jquery-validate.js')?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/vue.min.js')?>"></script>

 <script type="text/javascript" src="<?=base_url('assets/js/vue-select.js')?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/app.js')?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/vex.combined.min.js')?>"></script>

 <script type="text/javascript">
  function getBaseUrl(){
    return <?=json_encode(site_url())?>;
  }
 </script>
 <script type="text/javascript" src="<?=base_url('assets/js/party-name-pop-up.js')?>"></script>
 
 <? if(isset($js_files)): ?>
  <? foreach($js_files as $js_file): 
      if(strstr($js_file,'jquery-1.11.1.min.js'))
        continue;
  ?>
    <script type="text/javascript" src="<?=at($js_file)?>"></script>
  <? endforeach; ?>
<? endif;?>



<script>
jQuery(function(){
  $('form.validate').each(function(){
    $(this).validate();
  })
  $(".chosen-select").chosen();
 $("._datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
})
</script>
<!-- Hiding the domestic usertype column when export customer is added  -->
<script>
function goBack() {
    window.history.back();
}
</script>

<div style='height:20px;'></div>  
</body>
</html>

