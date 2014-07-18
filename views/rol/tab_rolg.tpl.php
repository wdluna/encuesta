<!--  
  rolgView 

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
      action="<?php echo $PATH_DOMAIN ?>/rol/<?php echo $PATH_EVENT ?>/">
    <input name="rol_id" id="rol_id" type="hidden" value="<?php echo $rol_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/rol/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'rol_id', width : GetColumnSize(5), sortable : true, align: 'center'},
            {display: 'C&oacute;digo', name : 'rol_cod', width : GetColumnSize(5), sortable : true, align: 'left'},            
            {display: 'Descripci&oacute;n', name : 'rol_descripcion', width : GetColumnSize(45), sortable : true, align: 'left'},
            {display: 'Archivo del rol', name : 'rol_titulo', width : GetColumnSize(45), sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            //{name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'rol_id', isdefault: true},
            {display: 'C&oacute;digo', name : 'rol_cod'},
            {display: 'Descripci&oacute;n', name : 'rol_descripcion'},
            {display: 'Archivo del rol', name : 'rol_titulo'}         
        ],
        sortname: "rol_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE ROLES DE USUARIOS',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 380
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#rol_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/rol/edit/");
            document.getElementById('formA').submit();
        }
    }
    
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            $.post("<?php echo $PATH_DOMAIN ?>/rol/findReg/",{rol_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                if(data != true){
                    if($('.trSelected div',grid).html()){
                        if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                            $.post("<?php echo $PATH_DOMAIN ?>/rol/delete/",{rol_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                                if(data != true){
                                    $('.pReload',grid.pDiv).click();
                                }
                        });
                    }
                    else{
                        alert("Por favor, seleccione un registro");
                    }
                }else{
                    alert("No se puede eliminar el registro");
                }
            });
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/rol/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#rol_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/rol/edit/");
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