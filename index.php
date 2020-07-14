<?php
 $conex = mysqli_connect("127.0.0.1", "root", "", "desarrolloweb");

    if (!$conex) {
     echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
     echo "errno de depuración: " . mysqli_connect_errno();
     echo "error de depuración: " . mysqli_connect_error();
     echo "</p>";
     exit;
    }
    $nombre = "";
    $cantidad = "";
    $precio = "";
    $id_prod = "";
    $fecha_vencimiento = "";
    $accion = "Agregar";
    if(isset($_POST["accion"]) && ($_POST["accion"] == "Agregar")){
       $stmt = $conex->prepare("INSERT INTO producto (nombre, cantidad, precio, fecha_vencimiento) VALUES (?, ?, ?, ?)");
       $stmt->bind_param('ssss',$nombre, $cantidad, $precio, $fecha_vencimiento);
       $nombre = $_POST["nombre"];
       $cantidad = $_POST["cantidad"];
       $precio = $_POST["precio"];
       $fecha_vencimiento = $_POST["fecha_vencimiento"];
       $stmt->execute();
       $stmt->close();
       $nombre = "";
       $cantidad = "";
       $precio = "";
       $fecha_vencimiento = "";
    } else if (isset($_POST["accion"]) && ($_POST["accion"] == "Modificar")){
       $stmt = $conex->prepare("UPDATE producto SET nombre = ?, cantidad = ?, precio = ?, fecha_vencimiento = ? WHERE id_prod = ?");
       $stmt->bind_param('ssssi',$nombre, $cantidad, $precio, $fecha_vencimiento, $id_prod);
       $nombre = $_POST["nombre"];
       $cantidad = $_POST["cantidad"];
       $precio = $_POST["precio"];
       $fecha_vencimiento = $_POST["fecha_vencimiento"];
       $id_prod = $_POST["id_prod"];
       $stmt->execute();
       $stmt->close();
       $nombre = "";
       $cantidad = "";
       $precio = "";
       $fecha_vencimiento = "";
    } else if(isset($_GET["update"])){
        $result = $conex->query("SELECT * FROM producto WHERE id_prod=".$_GET["update"]);
        if($result->num_rows > 0){
            $row1 = $result->fetch_assoc();
            $id_prod = $row1["id_prod"];
            $nombre = $row1["nombre"];
            $cantidad = $row1["cantidad"];
            $precio = $row1["precio"];
            $fecha_vencimiento = $row1["fecha_vencimiento"];
            $accion ="Modificar";
        }
    } else if(isset($_POST["eliCodigo"])){
        $stmt = $conex->prepare("DELETE  FROM producto WHERE id_prod = ?");
        $stmt->bind_param('i', $id_prod);
        $id_prod = $_POST["eliCodigo"];
        $stmt->execute();
        $stmt->close();
        $id_prod = "";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<!-- basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- mobile metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<!-- site metas -->
<title>Deber de Desarrollo Web</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<!-- site icons -->
<link rel="icon" href="images/fevicon/fevicon.png" type="image/gif" />
<!-- bootstrap css -->
<link rel="stylesheet" href="css/bootstrap.min.css" />
<!-- Site css -->
<link rel="stylesheet" href="css/style.css" />
<!-- responsive css -->
<link rel="stylesheet" href="css/responsive.css" />
<!-- colors css -->
<link rel="stylesheet" href="css/colors1.css" />
<!-- custom css -->
<link rel="stylesheet" href="css/custom.css" />
<!-- wow Animation css -->
<link rel="stylesheet" href="css/animate.css" />
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>
<body id="default_theme" class="it_service about">
<!-- header -->
<header id="default_header" class="header_style_1">
  <!-- header top -->
  <div class="header_top">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="full">
            <div class="topbar-left">
              <ul class="list-inline">
                <li> <span class="topbar-label"><i class="fa  fa-home"></i></span> <span class="topbar-hightlight">Quito Ecuador</span> </li>
                <li> <span class="topbar-label"><i class="fa fa-envelope-o"></i></span> <span class="topbar-hightlight"><a href="mailto:herediajm37@yahoo.es">herediajm37@yahoo.es</a></span> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end header top -->
</header>
<!-- end header -->
<!-- inner page banner -->
<div id="inner_banner" class="section inner_banner_section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="title-holder">
            <div class="title-holder-cell text-left">
              <h1 class="page-title">Deber de desarrollo web</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end inner page banner -->
<!-- section -->
<div class="section padding_layout_1">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="main_heading text_align_center">
          <form id="forma" name="forma" method="post" action="index.php">
            <h2>DISTRICELL</h2>
            <h1>Gestión de Productos</h1>
            <br> <br>
            <div class="row">
            <div class="col-md-6">
            <table border="1" class="product-table price_contant">
                <tr class="price_head">
                    <td><strong>ID</strong></td>
                    <td><strong>Producto</strong></td>
                    <td><strong>Cantidad</strong></td>
                    <td><strong>Precio</strong></td>
                    <td><strong>Fecha Vencimiento</strong></td>
                    <td><strong>Eliminar</strong></td>

                </tr>
                <?php
                    $result = $conex->query("SELECT * FROM PRODUCTO");
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><a style="color:#007bff" href="index.php?update=<?php echo $row["id_prod"]; ?>"><?php echo $row["id_prod"]; ?></a></td>
                    <td><?php echo $row["nombre"]; ?></td>
                    <td><?php echo $row["cantidad"]; ?></td>
                    <td><?php echo $row["precio"]; ?></td>
                    <td><?php echo $row["fecha_vencimiento"]; ?></td>
                    <td><input type="radio" name="eliCodigo" value="<?php echo $row["id_prod"]; ?>"></td>
                </tr>
                        <?php } 
                    } else {?>
                    <tr>
                        <td colspan="4"> No hay datos</td>
                    </tr>
                    <?php } ?>
                    <br> <br>
                    <br> <br>
            </table>
            <table class="product-table">
                <tr>
                    <td colspan=3><input class="btn" type="button" name="eliminar" value="Eliminar" onclick="eliminarProducto();"></td>
                </tr>
            </table>
            </div>
            <div class="col-md-6">
                <input type="hidden" name="id_prod" value ="<?php echo $id_prod ?>">
                <h5><strong>Nuevo Producto<strong></h5>
                <br> <br>
                <table border="0">
                    <tr>
                        <td><label id="lblNombre" for="nombre">Nombre:</label></td>
                        <td><input class="field_custom" type="text" name="nombre" value="<?php echo $nombre ?>" maxlength="100" size="25" required="true"></td>
                    </tr>
                    <tr>
                        <td><label id="lblCantidad" for="cantidad">Cantidad:</label></td>
                        <td><input class="field_custom" type="number" name="cantidad" value="<?php echo $cantidad ?>" maxlength="5" size="6"></td>
                    </tr>
                    <tr>
                        <td><label id="lblPrecio" for="precio">Precio:</label></td>
                        <td><input class="field_custom" type="text" name="precio" value="<?php echo $precio ?>" maxlength="10" size="6"></td>
                    </tr>
                    <tr>
                        <td><label id="lblFechaV" for="fecha_vencimiento">Fecha de Vencimiento:</label></td>
                        <td><input class="field_custom" type="text" name="fecha_vencimiento" value="<?php echo $fecha_vencimiento ?>" maxlength="10" size="6"></td>
                    </tr>
                    <tr><td colspan=2><input class="btn" type="submit" name="accion" value="<?php echo $accion; ?>"/></td></tr>
                </table>
            </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end section -->
<!-- footer -->
<footer style="	background: #ffffff;">
    <div class="row">
      <div class="cprt">
        <p>Jonatan Heredia © Copyrights 2020</p>
      </div>
    </div>
</footer>
<!-- end footer -->
</body>
<script>
    function eliminarProducto()
    {
        document.getElementById('forma').submit();
    }
</script>
</html>