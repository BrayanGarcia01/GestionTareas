<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous">
  </script>
<link rel="stylesheet" type="text/css" href="estilos.css">
	<meta charset="utf-8">
	<meta name="viewport content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie-edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<body>
	

    <?php  
    if (!file_exists($_GET['cedula'].".json"))  
	{ 

		$time = time();
		$fecha = date("d-m-y", $time);
	  	$fh = fopen( $_GET['cedula'].".json", 'w') or die("Se produjo un error al crear el archivo");
	  
	  $texto ="{\n\"cedula\":\"".$_GET['cedula']."\",\n";
	  $texto .="\"tareas\":[\n	{\n";
	  $texto .="	\"nombre\":\"Planear semana\",\n";
	  $texto .="	\"fecha\":\"".$fecha."\",\n";
	  $texto .="	\"terminada\":\"false\"\n	},\n";
	  $texto .="	{\n	\"nombre\":\"Ser feliz\",\n";
	  $texto .="	\"fecha\":\"".$fecha."\",\n";
	  $texto .="	\"terminada\":\"false\"\n	}\n	]\n";
	  $texto .="}";
	  fwrite($fh, $texto) or die("No se pudo escribir en el archivo");
	  
	  fclose($fh);
	}
	?>
	<?php
        include "usuario.php";
        $miUsuario;
        $info = file_get_contents($_GET['cedula'].".json");
        //FormatoJson
        $us = json_decode($info,true);
        //Cedula
        $miUsuario= new usuario($us['cedula']);
		//Agragamos las tareas del usuario
        foreach ($us['tareas'] as $tarea) {
        	$miUsuario->addTarea(new tarea($tarea['nombre'],$tarea['fecha'],$tarea['terminada']));
        	
        }
        
    ?>
 
	<script type="text/javascript">
		
	    $(document).ready(function() {
	    	$("#btnAgregar").click(function(){
	    		var varCedula =$("input[name='cedula']").val();
				var varFecha=$("input[name='fechaTarea']").val();
				var varNombre =$("input[name='nombreTarea']").val();
				$.ajax({
                    	type: "GET",
                    	url: "agregarTarea.php",
                        data:{
                        	cedula:varCedula,
                        	nombreTarea:varNombre,
                        	fechaTarea:varFecha,
                        },
                    	success: function (response){
                    		alert(response);
                    	}
                   
                });
	    	});

	       $("button[name='buttonTachar']").click(function(){

	       		var numero=$(this).val();
	       		mensaje= "#"+numero;
	       		if($(mensaje).hasClass('tachado')){
	       			document.getElementsByName("buttonTachar")[numero].innerHTML="Marcar"; 
	       			$(mensaje).removeClass("tachado");
	       			
	       			$.ajax({
                    	type: "GET",
                    	url: "procesarDatos.php",
                        data:{
                        	cedula:<?php echo $_GET['cedula']?>,
                        	tarea:numero,
                        	terminada:"false"
                        },
                    	success: function (response) {
                    	},
                    	error:function(){
                    	}
                   
                	});
                	
                	    	
	       		}else{
	       			document.getElementsByName("buttonTachar")[numero].innerHTML="Desmarcar";
	       			$(mensaje).addClass("tachado");
	       			$.ajax({
                    	type: "GET",
                    	url: "procesarDatos.php",
                        data:{
                        	cedula:<?php echo $_GET['cedula']?>,
                        	tarea:numero,
                        	terminada:"true"
                        },
                    	success: function (response) {
                    	},
                    	error:function(){
                    	}
                    
                	});
	       		}

	       });
	      

	    });
	 
	 
    </script>

  	
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <a class="navbar-brand" href="#">SW3</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav">
	      <li class="nav-item active">
	        <a class="nav-link" href="index.html">Regresar</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link disabled" href="#"><?php echo "Documento de indetidad: ".$miUsuario->getCedula()?></a>
	      </li>
	    </ul>
	  </div>
	</nav>
    <div class="contenedor">
    	
    <div class="container separacion">
    	<div class="row ">
			<div class="col-sm-12 col-md-3 col-lg-3 col-xl">
				<div class="divIndicaciones">
					<p class="lead pJustify">
						¿Tienes muchas tareas pendientes y no crees poder gestionarlas bien?, pues esta fantástica página web te ayudará a gestionar las tareas que tengas que cumplir. Tienes una tarea nueva, solamente pulsa en <b> agregar tarea</b>, ingresa los datos y ya tendrás agendada tu tarea, si ya cumpliste tu tarea simplemente da al botón <b>marcar</b>, si la marcaste por error, no hay problema pulsa en <b>desmarcar</b>. Disfruta tu aplicación.
					</p>
				</div>
			</div>
			<div class="col-sm-12 col-md-9 col-lg-9">

				<ul class="list-group">
		   			<table class="table">
			  		<thead class="thead-light">
			    	<tr>
			      		<th scope="col">#</th>
			      		<th scope="col">Nombre de tarea</th>
			      		<th scope="col">Fecha</th>
			      		<th scope="col">Accion</th>
			   		</tr>
			  		</thead>
			  		<tbody>
		    			<?php $valor=0;
				        foreach( $miUsuario->getTareas() as $t):
				    	?>
		   	
					    <tr id=<?php echo "\"".$valor."\""?> class=<?php if($miUsuario->getTareas()[$valor]->getTerminada()=="true"){ echo "\"tachado\"";}else{ echo "\"\"";}?> >
					      <th  scope="row"><?php echo $valor+1;?></th>
					      <td> <?php echo $miUsuario->getTareas()[$valor]->getNombre(); ?></td>
					      <td> <?php echo $miUsuario->getTareas()[$valor]->getFecha(); ?> </td>
					      <td><button name="buttonTachar"  value=<?php echo "\"".$valor."\"" ?> class="btn btn-primary buttonMarcacion" ><?php if($miUsuario->getTareas()[$valor]->getTerminada()=="true"){ echo "Desmarcar";}else{ echo "Marcar";}?></button> </td>
					    </tr>

			 			<?php $valor+=1;?>

						<?php endforeach;?>
					</tbody>
					</table>
				</ul>
			</div>    		
	    </div>
	    <form action="#" method="get">
	    	<input type="" class="escondido" name="cedula" value=<?php echo "\"".$miUsuario->getCedula()."\""?>>
			<div class="row">
			    	<div class="col-md-3">
			    		<label>Nombre de la tarea</label>
			    	</div>
			    	<div class="col-md-9">
			    		<input type="text" name="nombreTarea">
			    	</div>  	
			    	
			    </div>
			    <div class="row">
			    	<div class="col-md-3">
			    		<label>Fecha</label>
			    	</div>
			    	<div class="col-md-3">
			    		<input type="text" name="fechaTarea">
			    	</div>
			    	<div class="col-md-6">
			    		<button id="btnAgregar" class="btn btn-primary">Agregar Tarea</button>
			    		
			    	</div>
			    </div>

		</form>
	</div> 
	

	<footer class="container mt-4">
  <div class="row">
    <div class="col">
      <p class="text-center">Universidad del Cauca</p>
    </div>
  </div>
</footer>
			

	
	
</body>
</html>
