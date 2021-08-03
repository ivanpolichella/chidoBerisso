<?php 
session_start();
if(!isset($_SESSION['carrito'])){
  header('Location: ./index.php');
}
$arreglo  = $_SESSION['carrito'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Mi tienda</title>
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
    <form action="./php/insertarpedido.php" method="post">
      
      <div class="site-section">
        <div class="container">
          <div class="row">
          
            <div class="col-md-12 mb-5 mb-md-0">
              <h2 class="h3 mb-3 text-black">Detalles del Envío</h2>
              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="c_fname" class="text-black">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_fname" name="c_fname">
                  </div>
                  <div class="col-md-6">
                    <label for="c_lname" class="text-black">Apellido <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_lname" name="c_lname">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_address" class="text-black">Direccion <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Ej: Calle 38 entre montevideo y 174 n5144 (Piedras A la Vista), Berisso">
                  </div>
                </div>
                <div class="form-group row mb-5">
                  <div class="col-md-6">
                    <label for="c_email_address" class="text-black">Mail <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_email_address" name="c_email_address">
                  </div>
                  <div class="col-md-6">
                    <label for="c_phone" class="text-black">Telefono <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_phone" name="c_phone" placeholder="Phone Number">
                  </div>
                </div>
              <div class="row mb-5">
                <div class="col-md-12">
                  <h2 class="h3 mb-3 text-black">Orden</h2>
                  <div class="p-3 p-lg-5 border">
                    <table class="table site-block-order-table mb-5">
                      <thead>
                        <th>Producto</th>
                        <th>Total</th>
                      </thead>
                      <tbody>
                      <?php
                        $total = 0; 
                        for($i=0;$i<count($arreglo);$i++){
                          $total =$total+ ($arreglo[$i]['Precio']*$arreglo[$i]['Cantidad']);
                        
                      ?>
                        <tr>
                          <td>$<?php echo $arreglo[$i]['Nombre'];?> </td>
                          <td>$<?php echo  number_format($arreglo[$i]['Precio'], 2, '.', '');?></td>
                        </tr>
                    
                        <?php 
                          }
                        ?>
                        <tr>
                          <td> <b>Total Final</b>  </td>
                          <td id="tdTotalFinal" 
                            data-total="<?php echo $total;?>">$<?php echo number_format($total, 2, '.', '');?></td>
                        </tr>
                      </tbody>
                    </table>

                  

                    <div class="form-group">
                      <button class="btn btn-primary btn-lg py-3 btn-block" type="submit">PAGAR</button>
                    </div>

                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- </form> -->
        </div>
      </div>
    </form>           
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
        $("#button-addon2").click(function(){
          var codigo = $("#c_code").val();
          $.ajax({
            url:"./php/validarcodigo.php",
            data:{ 
              codigo:codigo
            },
            method:'POST'
          }).done(function(respuesta){
            if(respuesta == "error" || respuesta == "codigo no valido"){
                $("#error").show();
                $("#id_cupon").val("");
            }else{
              var arreglo = JSON.parse(respuesta);
              if(arreglo.tipo == "moneda"){
                $("#textoCupon").text("Usted tiene un descuento de "+arreglo.valor+" pesos");
                $("#tdTotal").text( arreglo.valor+"MXN");
                var total = parseFloat($("#tdTotalFinal").data('total')) - arreglo.valor;
                $("#tdTotalFinal").text("$"+ total.toFixed(2) );
              }else{
                $("#textoCupon").text("Usted tiene un descuento de "+arreglo.valor+"% en su compra");
                $("#tdTotal").text( arreglo.valor+"%");
                var total =   parseFloat($("#tdTotalFinal").data('total')) - ( (arreglo.valor/100) * parseFloat($("#tdTotalFinal").data('total')) ) ;
                $("#tdTotalFinal").text("$"+ total.toFixed(2) );
              }
              $("#formCupon").hide();
              $("#datosCupon").show();
              $("#id_cupon").val(arreglo.id);
            }
          })
        });
        $("#c_code").keyup(function(){
          $("#error").hide();
        });
    });
   </script>               
  </body>
</html>