<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>Hello, world!</title>
    <style type="text/css">
      .body {
        background: #FFFFFF;
      }
      .left-bar {
        flex: 25%;
        background: #333F4D;
        color: #fff;
        max-width: 200px;
        top: 0;
        bottom: 0;
        z-index: 100;
        position: fixed;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        width: 16.66%;
      }

      .sidebar {
        top: 0;
        height: calc(100vh - 48px);
        overflow-x: hidden;
        overflow-y: auto;
        position: sticky;
      }

      .right-bar {
        flex: 75%;
        max-width: 83.333333%;
      }
      .main {
        color: #fff;
      }
      .main ul li a {
        /*color: #fff;*/
      }
      .main .header {
        background: #494E53;
      }
      .left-content {
        flex: 25%;
        max-width: 200px;
        z-index: 100;
        position: sticky;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        width: 16.66%;
      }
      .sidebar-content{
        top: 0;
        height: calc(100vh - 48px);
        overflow-x: hidden;
        overflow-y: auto;
      }
      .right-content {
        flex: 75%;
        max-width: 75%;
      }
      
      .fixed-bar {
        flex: 25%;
        top: 0;
        max-width: 200px;
        z-index: 100;
        position: fixed;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        width: 16.66%;
      }

    </style>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top bg-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-envelope"></i> 
                <span class="badge badge-light">9</span>
                <span class="sr-only">(current)</span>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <h4 class="header p-2">You have 4 messages</h4>
                <div class="content overflow-auto">
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle mx-1">
                    <div class="body pr-4">
                      <h5 class="heading mb-2">Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h5>
                      <p class="description">Some quick example text to build </p>
                    </div>
                  </div>
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle mx-1">
                    <div class="body pr-4">
                      <h5 class="heading mb-2">Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h5>
                      <p class="description">Some quick example text to build </p>
                    </div>
                  </div>
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle mx-1">
                    <div class="body pr-4">
                      <h5 class="heading mb-2">Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h5>
                      <p class="description">Some quick example text to build </p>
                    </div>
                  </div>
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle mx-1">
                    <div class="body pr-4">
                      <h5 class="heading mb-2">Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h5>
                      <p class="description">Some quick example text to build </p>
                    </div>
                  </div>
                </div>
                <h4 class="footer text-center p-2"><a href="#">See All Messages</a></h4>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-bell"></i>
                <span class="badge badge-light">9</span>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <h4 class="header p-2">You have 4 messages</h4>
                <div class="content overflow-auto">
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <div class="body pr-4">
                      <p class="description"><i class="fa fa-users text-aqua"></i>
                      Some quick example text to build </p>
                    </div>
                  </div>
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <div class="body pr-4">
                      <p class="description"><i class="fa fa-users text-aqua"></i>
                      Some quick example text to build </p>
                    </div>
                  </div>
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <div class="body pr-4">
                      <p class="description"><i class="fa fa-users text-aqua"></i>
                      Some quick example text to build </p>
                    </div>
                  </div>
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <div class="body pr-4">
                      <p class="description"><i class="fa fa-users text-aqua"></i>
                      Some quick example text to build </p>
                    </div>
                  </div>
                </div>
                <h4 class="footer text-center p-2"><a href="#">See All Messages</a></h4>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-flag"></i>
                <span class="badge badge-light">9</span>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <h4 class="header p-2">You have 4 messages</h4>
                <div class="content overflow-auto">
                  <div class="dropdown-item py-2">
                    <div class="body px-auto">
                      <h5 class="heading mb-2">Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h5>
                      <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <div class="body px-auto">
                      <h5 class="heading mb-2">Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h5>
                      <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <div class="body px-auto">
                      <h5 class="heading mb-2">Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h5>
                      <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="dropdown-item d-flex flex-row justify-content-center align-items-center py-2">
                    <div class="body px-auto">
                      <h5 class="heading mb-2">Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h5>
                      <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <h4 class="footer text-center p-2"><a href="#">See All Messages</a></h4>
              </div>
            </li>
            <li class="nav-item user-panel dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
              </a>
              <div class="dropdown-menu text-center py-0" aria-labelledby="navbarDropdown">
                <div class="dropdown-item">
                  <div class="header py-2">
                    <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                    <p class="title">
                      Alexander Pierce - Web Developer
                      <small class="d-block">Member since Nov. 2012</small>
                    </p>
                  </div>
                  <div class="body py-2 px-3">
                    <ul class="list-unstyled d-flex flex-row justify-content-between align-items-center">
                      <li><a href="">Followers</a></li>
                      <li><a href="">Sales</a></li>
                      <li><a href="">Friends</a></li>
                    </ul>
                  </div>
                  <div class="footer py-3 px-3 d-flex flex-row justify-content-between align-items-center">
                    <button type="button" class="btn btn-primary btn-sm">Primary</button>
                    <button type="button" class="btn btn-primary btn-sm">Primary</button>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <div class="wraper">
      <div class="container-fluid  pl-0">
        <div class="body d-flex flex-row align-items-start">
          <div class="left-bar px-1 py-2">
            <div class="sidebar my-3">
              <div class="user-panel my-5 d-flex flex-row justify-content-start align-items-center">
                <div class="image px-3">
                  <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                </div>
                <div class="info">
                  <p class="username">Admin</p>
                  <p>online</p>
                </div>
              </div>
              <div class="menu my-2">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-bar ml-auto pl-3">
            <div class="main m-0 p-0">
              <div class="header p-3">
                <ol class="breadcrumb" style="margin-bottom: 5px;">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">Library</a></li>
                  <li class="active">Data</li>
                </ol>
                <h4>Header</h4>
              </div>
              <div class="content p-3 d-flex flex-row justify-content-start">
                <div id="content" class="left-content py-2">
                  <div class="sidebar-content">
                    <ul class="list-unstyled">
                      <li><a href="">Lorem ipsum dolor</a></li>
                      <li><a href="">Lorem ipsum dolor</a></li>
                      <li><a href="">Lorem ipsum dolor</a></li>
                      <li><a href="">Lorem ipsum dolor</a></li>
                      <li><a href="">Lorem ipsum dolor</a></li>
                    </ul>
                  </div>
                </div>
                <div class="right-content ml-auto pl-3">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">© 2017-2019 Company Name</p>
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#">Privacy</a></li>
                  <li class="list-inline-item"><a href="#">Terms</a></li>
                  <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script type="text/javascript">
      window.onscroll = function() {myFunction()};
      var navbar = document.getElementById('content');
      var sticky = navbar.offsetTop;
      function myFunction() {
        if (window.pageYOffset >= sticky) {
          navbar.classList.add("fixed-bar")
        } else {
          navbar.classList.remove("fixed-bar");
        }
      }
    </script>
  </body>
</html>