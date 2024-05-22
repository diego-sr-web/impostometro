<?php include '../controller/function.php'; ?>
<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap demo</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="../css/estilo.css">
</head>

<body class="bg">

  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="card">
          <iframe id="impostometro" class="bg3" src="https://impostometro.com.br/widget/contador/" width="1050" height="130" scrolling="yes" frameborder="0"></iframe>
        </div>
      </div>
    </div>
  </div>

  <div id="data-atual" class="div-sobreposta"> </div>

  <div class="container">
    <div class="row bg-w">
      <div class="col-6">
        <canvas id="dolargraph"></canvas>
      </div>
      <div class="col-6">
        <canvas id="bitcoingraph"></canvas>
      </div>
    </div>

    <div class="row">
      <div class="col d-flex align-items-stretch mt-2 bgw">
        <div class="card w-100">
          <div class="card-body box bg1">
            <?php
            // Supondo que $ibovespa['regularMarketPrice'] já está definido
            $preco = $ibovespa['regularMarketPrice'];

            if ($preco < 0) {
              $ibov_cor = '#ff9688';
              $simbol = '-';
              $icon = "<i class='bi bi-arrow-down-short'></i>";
            } else {
              $simbol = '+';
              $ibov_cor = '#90ee90 ';
              $ibov_icon = "<i class='bi bi-arrow-up-short'></i>";
            }
            ?>
            <h5 class="card-title box-nome">IBOVESPA</h5>
            <p class="card-text box-valor">
              <?php echo $ibovespa['regularMarketPrice']; ?>
            </p>
            <p class="card-text box-time" style="font-size:10px; color: <?= $ibov_cor; ?> ">
              <?= $simbol ?>
              <?php echo $ibovespa['regularMarketChange']; ?> 
              <?= $ibov_icon ; ?>
              (<?php echo $ibovespa ['regularMarketChangePercent']; ?>%)
            </p>
          </div>
        </div>
      </div>

      <?php foreach ($data as $itens) :
        $string = $itens['name'];
        $titulo = abreviarString($string, 19);
      ?>
        <div class="col d-flex align-items-stretch mt-2 bgw">
          <div class="card w-100">
            <div class="card-body box bg1">
              <h5 class="card-title box-nome"><?php echo $titulo; ?></h5>
              <p class="card-text box-valor"><?php echo converterParaReais($itens['ask']) ?></p>
              <p class="card-text box-time"><?php echo converterParaData($itens['timestamp']) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>


<div><canvas id="dolargraph1" width="400" height="200"></canvas></div>
<div><canvas id="bitcoingraph1" width="400" height="200"></canvas></div>
<div><canvas id="dolargraph2" width="400" height="200"></canvas></div>
<div><canvas id="bitcoingraph2" width="400" height="200"></canvas></div>
  






<script>
      // Dados para o gráfico de Dólar
  const dolarData = {
    labels: <?php echo $dolar_data_semanal; ?>,
    datasets: [{
      label: 'Dólar(USD)/Real(BRL)',
      data: <?php echo $dolar_valor_semanal; ?>,
      borderColor: 'rgba(36,83,81,1)',
      backgroundColor: 'rgba(36,83,81,0.8)',
      fill: true,
      tension: 0.6
    }]
  };

  // Configuração do gráfico de Dólar
  const dolarConfig = {
    type: 'line',
    data: dolarData,
    options: {
      scales: {
        x: {
          title: {
            display: true,
          }
        },
        y: {
          title: {
            display: true,
            text: 'Taxa de Câmbio (BRL)'
          }
        }
      },
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      }
    }
  };
  const dolarCtx = document.getElementById('dolargraph').getContext('2d');
  const dolarGraph = new Chart(dolarCtx, dolarConfig);
  const bitcoinData = {
    labels: <?php echo $btc_data_semanal; ?>,
    datasets: [{
      label: 'Bitcoin/Real(BRL)',
      data: <?php echo $btc_valor_semanal; ?>,
      borderColor: 'rgba(172,79,83,1)',
      backgroundColor: 'rgba(172,79,83,0.8)',
      fill: true,
      tension: 0.6
    }]
  };

  const bitcoinConfig = {
    type: 'line',
    data: bitcoinData,
    options: {
      scales: {
        x: {
          title: {
            display: true,
          }
        },
        y: {
          title: {
            display: true,
            text: 'Preço (R$-BRL)'
          }
        }
      },
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      }
    }
  };

  // Renderização do gráfico de Bitcoin
  const bitcoinCtx = document.getElementById('bitcoingraph').getContext('2d');
  const bitcoinGraph = new Chart(bitcoinCtx, bitcoinConfig);
</script>

<script>
  // Primeira instância dos gráficos

  // Dados para o gráfico de Dólar
  const dolarData1 = {
    labels: <?php echo $dolar_data_semanal; ?>,
    datasets: [{
      label: 'Dólar(USD)/Real(BRL)',
      data: <?php echo $dolar_valor_semanal; ?>,
      borderColor: 'rgba(36,83,81,1)',
      backgroundColor: 'rgba(36,83,81,0.8)',
      fill: true,
      tension: 0.6
    }]
  };

  // Configuração do gráfico de Dólar
  const dolarConfig1 = {
    type: 'line',
    data: dolarData1,
    options: {
      scales: {
        x: {
          title: {
            display: true,
          }
        },
        y: {
          title: {
            display: true,
            text: 'Taxa de Câmbio (BRL)'
          }
        }
      },
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      }
    }
  };
  const dolarCtx1 = document.getElementById('dolargraph1').getContext('2d');
  const dolarGraph1 = new Chart(dolarCtx1, dolarConfig1);

  // Dados para o gráfico de Bitcoin
  const bitcoinData1 = {
    labels: <?php echo $btc_data_semanal; ?>,
    datasets: [{
      label: 'Bitcoin/Real(BRL)',
      data: <?php echo $btc_valor_semanal; ?>,
      borderColor: 'rgba(172,79,83,1)',
      backgroundColor: 'rgba(172,79,83,0.8)',
      fill: true,
      tension: 0.6
    }]
  };

  const bitcoinConfig1 = {
    type: 'line',
    data: bitcoinData1,
    options: {
      scales: {
        x: {
          title: {
            display: true,
          }
        },
        y: {
          title: {
            display: true,
            text: 'Preço (R$-BRL)'
          }
        }
      },
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      }
    }
  };

  // Renderização do gráfico de Bitcoin
  const bitcoinCtx1 = document.getElementById('bitcoingraph1').getContext('2d');
  const bitcoinGraph1 = new Chart(bitcoinCtx1, bitcoinConfig1);
</script>

<script>
  // Segunda instância dos gráficos

  // Dados para o gráfico de Dólar
  const dolarData2 = {
    labels: <?php echo $dolar_data_semanal; ?>,
    datasets: [{
      label: 'Dólar(USD)/Real(BRL)',
      data: <?php echo $dolar_valor_semanal; ?>,
      borderColor: 'rgba(36,83,81,1)',
      backgroundColor: 'rgba(36,83,81,0.8)',
      fill: true,
      tension: 0.6
    }]
  };

  // Configuração do gráfico de Dólar
  const dolarConfig2 = {
    type: 'line',
    data: dolarData2,
    options: {
      scales: {
        x: {
          title: {
            display: true,
          }
        },
        y: {
          title: {
            display: true,
            text: 'Taxa de Câmbio (BRL)'
          }
        }
      },
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      }
    }
  };
  const dolarCtx2 = document.getElementById('dolargraph2').getContext('2d');
  const dolarGraph2 = new Chart(dolarCtx2, dolarConfig2);

  // Dados para o gráfico de Bitcoin
  const bitcoinData2 = {
    labels: <?php echo $btc_data_semanal; ?>,
    datasets: [{
      label: 'Bitcoin/Real(BRL)',
      data: <?php echo $btc_valor_semanal; ?>,
      borderColor: 'rgba(172,79,83,1)',
      backgroundColor: 'rgba(172,79,83,0.8)',
      fill: true,
      tension: 0.6
    }]
  };

  const bitcoinConfig2 = {
    type: 'line',
    data: bitcoinData2,
    options: {
      scales: {
        x: {
          title: {
            display: true,
          }
        },
        y: {
          title: {
            display: true,
            text: 'Preço (R$-BRL)'
          }
        }
      },
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      }
    }
  };

  // Renderização do gráfico de Bitcoin
  const bitcoinCtx2 = document.getElementById('bitcoingraph2').getContext('2d');
  const bitcoinGraph2 = new Chart(bitcoinCtx2, bitcoinConfig2);
</script>


<script src="../js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>