<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style type="text/css">
    .container {
      display: flex;
      flex-wrap: wrap;
    }

    .box {
      padding: 50px;
      width: 100%;
    }
    .blue {
      flex: 1;
      background: blue;
    }
    .red {
      flex: 1;
      background: red;
    }
    .green {
      flex: 3;
      background: green;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="box blue"></div>
    <div class="box red"></div>
    <div class="box green"></div>
  </div>
</body>
</html>