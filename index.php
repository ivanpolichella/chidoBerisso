<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Chido Berisso</title>
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
          <div class="col-md-9 order-2">
            <div class="row mb-5">
              <?php 
                include('./php/conexion.php');
                if(isset($_GET['texto'])){
                  $texto = $_GET['texto'];
                  if (!preg_match("/^[a-zA-Z]+/", $texto)) {
                    echo  '<h2>Sólo se permiten letras en el buscador</h2>';
                  }else{
                  $resultado = $conexion ->query("select * from combos 
                      where nombre_combo like '%".$_GET['texto']."%' or 
                      descripcion like '%".$_GET['texto']."%'
                      order by id DESC limit 10")or die($conexion -> error);
                  
                  if(mysqli_num_rows($resultado) == 0)
                    echo  '<h2>Sin resultados para la busqueda de: '.$texto.'</h2>';
                  }
                }else{
                  $resultado = $conexion ->query("select * from combos order by id DESC ")or die($conexion -> error);
                }
                
                if(isset($resultado))
                  while($fila = mysqli_fetch_array($resultado)){
                ?>
                  <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up" >
                    <div class="block-4 text-center" style="border: 4px solid #222325; border-radius: 0.55rem;">
                      <figure class="block-4-image">
                        <a href="shop-single.php?id=<?php echo $fila['id'];?>">
                        <img src="images/<?php echo $fila['imagen'];?>" alt="<?php echo $fila['nombre_combo'];?>" class="img-fluid" style="max-height: 365px; width:100%"></a>
                      </figure>
                      <div class="block-4-text p-4">
                        <h3><a href="shop-single.php?id=<?php echo $fila['id'];?>"><?php echo $fila['nombre_combo'];?></a></h3>
                        <p class="mb-0"><?php echo $fila['descripcion'];?></p>
                        <p class="text-primary font-weight-bold">$<?php echo $fila['precio_combo'];?></p>
                      </div>
                     
                    </div>
                  </div>
                <?php } ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="site-section site-blocks-2">
                <div class="row justify-content-center text-center mb-5">
                  <div class="col-md-7 site-section-heading pt-4">
                    <h2>Categorias</h2>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/veggie.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Preparacion</span>
                        <h3>Veggie</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/bondiola.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Preparacion</span>
                        <h3>Bondiola</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/pollo.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Preparacion</span>
                        <h3>Pollo</h3>
                      </div>
                    </a>
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
    
  </body>
</html>