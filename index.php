<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Múltiplo de arquivos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
    if(isset($_POST['enviar-formulario'])){

        $formatosPermitidos = array("png","jpg","jpeg","gif");
        $quantidadeArquivo = count($_FILES['arquivo']['name']);
        $contatdor = 0;

        while($contatdor < $quantidadeArquivo){

            $fileName = pathinfo($_FILES['arquivo']['name'][$contatdor], PATHINFO_FILENAME);   
            $extensao = pathinfo($_FILES['arquivo']['name'][$contatdor], PATHINFO_EXTENSION);

            // Verificar se a extensão exites no array de fomatos permitidos
            if(in_array($extensao, $formatosPermitidos)){

                $pastaDestino = "arquivos/";
                $temporario = $_FILES['arquivo']['tmp_name'][$contatdor]; //caminho temporario do arquivo
                $novoNome = $fileName."-".uniqid().".".$extensao;

                // verificar se ouve o envio(upload) 
                if(move_uploaded_file($temporario, $pastaDestino.$novoNome)){
                        $estiloCSS = 'style="background:#337711;"';
                        $menssagem[] = "Enviado com <b>sucesso</b> para pasta $pastaDestino <br> Novo nome: $novoNome <br>";
                }else{
                        $estiloCSS = 'style="background:#ff0000;"';
                        $menssagem[] = "Não foi possível enviar <br>";
                }

            }else{
                $estiloCSS = 'style="background:#ff0000;"';
                $menssagem[] = "O formato <b> $extensao </b> não é permitido <br>";
            }

            $contatdor++;
        }

    }
?>

<h1>Upload Múltiplo de arquivos</h1>
    <div id="form-div">
        <p>Formatos de arquivos permitidos (<b>png, jpg, jpeg e gif</b>)</p>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" id="formulario">
           <input type="file" name="arquivo[]" multiple>
           <button type="submit" name="enviar-formulario" id="enviar-formulario">Enviar</button>
        </form>
   </div>

   <div class="messagens" id="messagens" <?php echo $estiloCSS; ?> >
    <p>Status do Upload</p>
        <?php
            //Exibir mensagens
            if(!empty($menssagem)){
                foreach($menssagem as $msg){
                    echo "<li>$msg</li><br>";
                }
            }
        ?>
   </div>

</body>
</html>