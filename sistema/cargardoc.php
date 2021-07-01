<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>Soportes Documentales | KAWAG</title>
</head>

<?php include_once "includes/header.php"; ?>
<?php 
include('conexiondoc.php'); # En este caso, acá empieza el codigo PHP  para que este formulario conecte con la bse de datos almacenanda en el servidor.

$tmp = array();
$res = array();

$sel = $con->query("SELECT * FROM files");
while ($row = $sel->fetch_assoc()) {
    $tmp = $row;
    array_push($res, $tmp);
} 
?>

<html>
    <body>

            <div class="row justify-content-md-center">
                <div class="col-8">
                <div style="text-align:center;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Cargar nuevo documento
                       
                    </button>
                    
                    <div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Soportes Documentales</h1>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>#</th>
							<th>FECHA DE CARGA</th>
							<th>TITULO</th>
							<th>ASUNTO</th>
							<th>ACCIONES</th>
						</tr>
					</thead>
					<tbody>
                            <?php foreach ($res as $val) { ?>
                                <tr>
                                    <td><?php echo $val['id'] ?> </td> <!--Estas son las columnas que se encuentran en la base datos del proyecto-->
                                    <td><?php echo $val['date'] ?> </td>
                                    <td><?php echo $val['title'] ?></td>
                                    <td><?php echo $val['description'] ?></td>
                                    <td>
                                        <button onclick="openModelPDF('<?php echo $val['url'] ?>')" class="btn btn-primary" type="button">Visualizar Documento</button><!--la acción que debe ejecutar la maquina, al momento de presionar ael boton visualizar documento-->
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal --><!--cuando se habla de modal, es la ventana flotante donde se puede visualizar los documentos PDF.-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cargar nuevo documento</h5><!--este es el boton para que se ejecute la tarea de cargar el documento en el servidor-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><!--lo que se mostrará en pantalla-->
                        <form enctype="multipart/form-data" id="form1">
                            <div class="form-group">
                                <label for="title">Título del documento</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="description">Asunto del documento</label>
                                <input type="text" class="form-control" id="description" name="description">
                            </div>
                            <div class="form-group">
                                <label for="description">Adjuntar Documento</label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                        </form><!--termina lo que se mostrará en pantalla-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="location.reload()">Cerrar</button><!--Este es el boton, al momento de presionarlo, cierra el formulario nodal, y ejecutar la unción reload de la página, escrita en codigo JavaScript; en la línea 178-->
                        <button type="button" class="btn btn-primary" onclick="onSubmitForm()">Guardar</button><!--Este es el boton para guardar datos en el formulario + base de datos y en el Ajax-->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdf" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Vista del documento</h5><!--Este boton sirve mas que todo para que al presionar en el mismo, se puede ver el documento en pdf cargado, esa una función JavaScript-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe id="iframePDF" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
       
 <!-- EN EL SIGUIENTE SCRIPT, LO QUE HACE ES CARGAR EL DOCUMENTO EN PDF, CUANDO SE DA CLIC EN EL BOTON GUARGAR, INTEGRADO EN EL FORMULARIO; ESCRITO EN LA LINA 120, se trabaja con AJAX y javascript-->

        <script>
                            function onSubmitForm() {
                                var frm = document.getElementById('form1');
                                var data = new FormData(frm);
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function () {
                                    if (this.readyState == 4) {
                                        var msg = xhttp.responseText;
                                        if (msg == '¡Archivo cargado exitosamente!') {
                                            alert(msg);
                                            $('#exampleModal').modal('hide')
                                        } else {
                                            alert(msg);
                                        }

                                    }
                                };
                                xhttp.open("POST", "upload.php", true);
                                xhttp.send(data);
                                $('#form1').trigger('reset');
                            }
                            function openModelPDF(url) {
                                $('#modalPdf').modal('show');
                                $('#iframePDF').attr('src','<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/SISFAC-KAWAG/sistema/'; ?>'+ url); 
                            }
        </script>
        <!-- EN EL SIGUIENTE SCRIPT, LO QUE HACE ES RECARGAR LA PAGINA, AL MOMENTO DE PRESIONAR EL BOTÓN "CERRAR" DEL NODAL ESCRITO EN LA LINEA 119; LA CUAL ES UNA FUNCIÓN JAVASCRIPT -->
        <script>
                                location.reload(cargardoc.php); 
        </script> 
 </body>

</html>

<?php include_once "includes/footer.php"; ?>

<!--TODO: Se debe codificar, para la activación del menú desplegable logout ->

