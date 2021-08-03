<?php 
  session_start();
  //unset($_SESSION['carrito']);
  include './php/conexion.php';
  if(isset($_POST['id'])){
    $nombre ="";
    $precio= "";
    $imagen="";
    $id = $_POST['id'];
    $cantidad = $_POST['cantidadCombo'];
    unset($_POST['id']);
    unset($_POST['Cantidad']);
    unset($_POST['cantidadCombo']);
    $res= $conexion->query('select * from combos where id='.$id)or die($conexion->error);
    $fila = mysqli_fetch_array($res);
    $nombre=$fila['nombre_combo'];
    $precio = $fila['precio_combo'];
    $imagen = $fila['imagen'];
    
    if(isset($_SESSION['carrito'])){
      $arregloNuevo = array(
        'Id'=> $id,
        'Nombre'=> $nombre,
        'Precio'=>$precio,
        'Imagen'=> $imagen,
        'Cantidad' => $cantidad,
        'Items' => $_POST
      );
      $arreglo = $_SESSION['carrito'];
      array_push($arreglo, $arregloNuevo);
      $_SESSION['carrito']=$arreglo;
    }else{
      $arregloNuevo[] = array(
        'Id'=> $id,
        'Nombre'=> $nombre,
        'Precio'=>$precio,
        'Imagen'=> $imagen,
        'Cantidad' => $cantidad,
        'Items' => $_POST
      );
      $_SESSION['carrito']=$arregloNuevo;
    }
    header("Location: ./cart.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tienda </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
  
  <div class="site-wrap">
  <?php include("./layouts/header.php"); ?> 

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <form class="col-md-12" method="post">
            <div class="site-blocks-table">
              <table class="table" style="border: 4px solid #222325; border-radius: 0.55rem;">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Imagen</th>
                    <th class="product-name">Combo</th>
                    <th class="product-price">Percio Del Combo</th>
                    <th class="product-quantity">Cantidad</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                <?php  
                  $total = 0;
                  if(isset($_SESSION['carrito'])){ 
                    $arregloCarrito =$_SESSION['carrito'];
                    for($i=0;$i<count($arregloCarrito);$i++){
                      $total= $total + ( $arregloCarrito[$i]['Precio'] * $arregloCarrito[$i]['Cantidad'] );
                ?>
                  <tr>
                    <td class="product-thumbnail">
                      <img src="images/<?php echo $arregloCarrito[$i]['Imagen']; ?>" alt="Image" class="img-fluid">
                    </td>
                    <td class="product-name">
                      <h2 class="h5 text-black"><?php echo $arregloCarrito[$i]['Nombre']; ?></h2>
                      <?php
                      foreach($arregloCarrito[$i]['Items'] as $nombre_campo => $valor){ ?>
                      <p><?php echo $nombre_campo.' '.$valor?></p>
                      <?php } ?>
                    </td>
                    <td>$<?php echo $arregloCarrito[$i]['Precio']; ?></td>
                    <td>
                    <?php echo $arregloCarrito[$i]['Cantidad']; ?>
                    </td>
                    <td class="cant<?php echo $arregloCarrito[$i]['Id']; ?>">
                      $<?php echo $arregloCarrito[$i]['Precio'] * $arregloCarrito[$i]['Cantidad']; ?></td>
                    <td><a href="#" class="btn btn-primary btn-sm btnEliminar" data-id="<?php echo $arregloCarrito[$i]['Id'];?>">X</a></td>
                  </tr>
                  
                  <?php } } ?>
                 
                </tbody>
              </table>
            </div>
          </form>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">TOTAL  </h3>
                  </div>
                </div>
                <div class="row mb-5">
                  <div class="col-md-6">
                    <span class="text-black">Total</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black" id="total">$<?php echo $total;?></strong>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <button class="btn btn-primary py-3 btn-block" onclick="window.location='checkout.php'">Ingresar Datos Del Envio </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
                
    <?php include("./layouts/footer.php"); ?> 
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <script>
    $(document).ready(function(){
      $(".btnEliminar").click(function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var boton = $(this);
        $.ajax({
          method:'POST',
          url:'./php/eliminarCarrito.php',
          data:{
            id:id
          }
        }).done(function(respuesta){
         boton.parent('td').parent('tr').remove();
        });
      });
    });
  </script>
    
  </body>
</html>