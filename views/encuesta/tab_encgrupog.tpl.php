<!--  
  encgrupogView 

  @package
  @author lic. castellon
  @copyright DGGE
  @version $Id$ 2014.04.14
  @access public
-->

<div class="clear"></div><br/>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/encgrupo/<?php echo $PATH_EVENT ?>/">
    <input name="egr_id" id="egr_id" type="hidden" value="<?php echo $egr_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/encgrupo/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'egr_id', width : GetColumnSize(5), sortable : true, align: 'center'},
            {display: 'C&oacute;digo', name : 'egr_codigo', width : GetColumnSize(10), sortable : true, align: 'left'},            
            {display: 'Nombre', name : 'egr_nombre', width : GetColumnSize(85), sortable : true, align: 'left'},
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            //{name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'egr_id', isdefault: true},
            {display: 'C&oacute;digo', name : 'egr_codigo'},
            {display: 'Descripci&oacute;n', name : 'egr_nombre'},
        ],
        sortname: "egr_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE GRUPOS DE ENCUESTA',
        useRp: true,
        rp: 15,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 380
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#egr_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/encgrupo/edit/");
            document.getElementById('formA').submit();
        }
    }
    
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/encgrupo/delete/",{egr_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                });
            }
            else{
                alert("Por favor, seleccione un registro");
            }
            
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/encgrupo/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#egr_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/encgrupo/edit/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Por favor, seleccione un registro");
            }
        }
    }
    
    function GetColumnSize(percent){ 
        screen_res = ($(document).width()-50)*1;         
        col = parseInt((percent*(screen_res/100))); 
        if (percent != 100){ 
            return col; 
        }else{ 
            return col; 
        } 
    }     
</script>