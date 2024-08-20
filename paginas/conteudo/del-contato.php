<?php 
include('../../config/conexao.php');
if(isset($_GET['idDel'])) {
    $id = $_GET['idDel'];

    $select = "SELECT foto_contatos FROM tb_contatos WHERE id_contatos=:id";
    try {
        $result = $conect->prepare($select);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $contar = $result->rowCount();


        $contar = $result->rowCount();
        if($contar > 0) {
            $show = $result->fetch(PDO::FETCH_OBJ);
            $foto = $show->$foto_contatos;
       
            if($foto != 'avatar-padrao.png') {
                $filePath = "../../img/cont/" . $foto;
                //Verifica se o arquivo existe no servidor
                if(file_exists($filePath)) {
                    unlink($filePath);
                }
            } 
            //Agora delete o registro do banco de dados
            $delete = "DELETE FROM tb_contatos WHERE id_contatos=:id";
            try {
                $result = $conect->prepare($delete);
                $result->bindValue(':id',$id, PDO::PARAM_INT);
                $result->execute();

                $contar = $result->rowCount();
                if($contar > 0) {
                    header("Location: ../home.php");
                } else {
                    header("Location: ../home.php");
                }


            } catch (PDOException $e) {
                echo "<strong>ERRO DE DELETE</strong>";
                $e->getMessage();
            }
        } else {
            header("Location: ../home.php");
        }

        } catch(PDOException $e) {
            echo"<strong>ERRO DE SELECT:</strong>" . $e->getMessage();

    }
}