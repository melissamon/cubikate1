<?php 

$hostname="localhost";
$database="id2716259_bd_cubikate";
$username="id2716259_root";
$password="Admin123!";

$json=array();

if(isset($_GET["email"])&&($_GET["RUT_maestro"])){
    //$usuario=$_GET['RUT_maestro'];
    $Correo=$_GET['email'];
    $RUT_maestro=$_GET['RUT_maestro'];

    $codigo = rand(1111,9999);

    require("PHPMailer_5.2.4/class.phpmailer.php");

    $mail = new PHPMailer();

    //Luego tenemos que iniciar la validación por SMTP:
    $mail->IsSMTP();
    $mail->SMTPDebug = 2;
    $mail->Host = "smtp.gmail.com"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com "pop.gmail.com";
    $mail->SMTPSecure="ssl";
    $mail->SMTPAuth = true;
    $mail->Username = "cubikate.uniacc@gmail.com"; //doc.elec1@gmail.com"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 

    $mail->Password = "clave1604"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
    $mail->Port = 465; // Puerto de conexión al servidor de envio. 995 -- 465

    $mail->From = "cubikate.uniacc@gmail.com"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
    $mail->FromName = "Cristian Echeverria"; //A RELLENAR Nombre a mostrar del remitente. 
    $mail->AddAddress($Correo); 
    $mail->IsHTML(true); // El correo se envía como HTML 
    $mail->Subject = "Registro App Cubikate"; // Este es el titulo del email. 

    $body = "Estimado, \r\r Su clave temporal será {$codigo} y para continuar con su registro "; 
    $body .= "necesita acceder al siguiente enlace: \r";
    $body .= "https://uniacc.000webhostapp.com/cubikate/administracion.php?codigo_act={$codigo}&RUT_maestro={$RUT_maestro}";

    $mail->Body = $body; // Mensaje a enviar. 
    $exito = $mail->Send(); // Envía el correo.
    if($exito){ 
        
        //Guardar el código en la BD para posteriormente consultarlo desde el correo del maestro
        $conexion=mysqli_connect($hostname,$username,$password,$database);
        
        $consulta="UPDATE tabla_Maestros SET codigo_act='{$codigo}' WHERE RUT_maestro= '{$RUT_maestro}'"; 
        
        
		$resultado=mysqli_query($conexion,$consulta);

        $results["Respuesta"]='Revise su correo para continuar';
        $json['datos'][]=$results;
        echo json_encode($json);
        }
    else
    { 
        $results["Respuesta"]='No fue posible enviar el correo';
        $json['datos'][]=$results;
        echo json_encode($json);
    }
}
else
{
    $results["Respuesta"]='No fue posible enviar el correo';
	$json['datos'][]=$results;
	echo json_encode($json);
    
}

?>