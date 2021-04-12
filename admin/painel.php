<?php
require 'valida.php';
$dataHj = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Patrícia Cylene | Agendamento</title>
  <link rel="icon" type="image/png" href="https://patriciacylene.com.br/meta/favicon-32x32.png" sizes="32x32">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body >
  <nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <div class="container"> <a class="navbar-brand" href="#">
        <i class="fa d-inline fa-lg fa-stop-circle"></i>
        <b> PATRÍCIA CYLENE</b>
      </a> <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar16">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar16">
        <ul class="navbar-nav ml-auto">          
          <!-- <li class="nav-item"> <a class="btn navbar-btn ml-md-2 btn-light text-dark" href="#">FAQ</a> </li> -->
        </ul> <a href="logout.php" class="btn navbar-btn ml-md-2 btn-danger text-white">Sair</a>
      </div>
    </div>
  </nav>
  <div class="py-5">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
          <h2 class="text-center pb-4 text-success"><b><?= $_SESSION['nome'] ?></b></h2>
        </div>
      </div>
      

      <div class="row">
        <div class="col-md-12">
          <h3 class="">Agendamento <span class="badge badge-success"> confirmado</span></h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered ">
              <thead class="thead-light">
                <tr>
                  <th>Data</th>    
                  <th>Data/Hora</th>
                  <th>Aluno</th>
                  <th>Monitor</th>
                  <th>Link</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                
                if($_SESSION['tipo'] != '1')
                  $query = "SELECT al.nome AS aluno, a.`descricao`, a.`data_inicio`, a.`data_fim`, a.`link`, m.`nome` AS monitor
                  FROM `agendamento_aluno` aa
                  LEFT JOIN agendamentos a ON aa.`id_agendamento` = a.`id`
                  LEFT JOIN `monitores` m ON a.`id_monitor` = m.`id`
                  JOIN alunos al ON aa.id_aluno = al.id
                  WHERE m.id=$id_monitor AND a.`data_fim` >='$dataHj'";
                else 
                  $query = "SELECT al.nome AS aluno, a.`descricao`, a.`data_inicio`, a.`data_fim`, a.`link`, m.`nome` AS monitor
                  FROM `agendamento_aluno` aa
                  LEFT JOIN agendamentos a ON aa.`id_agendamento` = a.`id`
                  LEFT JOIN `monitores` m ON a.`id_monitor` = m.`id`
                  JOIN alunos al ON aa.id_aluno = al.id
                  WHERE a.`data_fim` >='$dataHj'";

                $smtp = $con->prepare($query);
                $smtp->execute();
                $rows = $smtp->fetchAll(PDO::FETCH_OBJ);

                foreach($rows as $row):                                 
              ?>
                <tr>    
                  <td><?= date('d/m/Y', strtotime($row->data_inicio)); ?></td>              
                  <td><?= $row->descricao ?></td>
                  <td><?= $row->aluno ?></td>
                  <td><?= $row->monitor ?></td>
                  <td><a target="_blank" class="btn btn-warning" href="<?= $row->link ?>">Entrar</a></td>
                  
                  <!-- <td>
                    <input type="checkbox" name="inputAgenda" wm-agendar wm-idAgenda="<?= $row->id ?>" wm-idAluno="<?= $_SESSION['id'] ?>">
                  </td> -->
                </tr>
                <?php                   
                  endforeach;
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="js/agendar.js"></script>
</body>

</html>