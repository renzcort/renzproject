<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Hello, world!</title>
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
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
    </header>

    <main class="wraper mt-5">
      <div class="row">
        <div class="col-2 side-left">
          <div class="sidebar container-fluid">
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
              <ul class="list-unstyled d-flex flex-column justify-content-center align-items-center">
                <li class="p-2"><a href="">Lorem ipsum dolor</a></li>
                <li class="p-2"><a href="">Lorem ipsum dolor</a></li>
                <li class="p-2"><a href="">Lorem ipsum dolor</a></li>
                <li class="p-2"><a href="">Lorem ipsum dolor</a></li>
                <li class="p-2"><a href="">Lorem ipsum dolor</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-9 side-right">
          <div class="content">
            <div class="header-content"></div>
            <div class="main-content"></div>
          </div>
          <footer></footer>
        </div>
      </div>
    </main>

    <!-- <main class="wraper container-fluid" role="main">
      <div class="row">
        <div class="col-2 sidebar overflow-hidden">
          <div class="main-sidebar overflow-hidden overflow-auto">
            <div class="user-panel d-flex flex-row">
              <div class="image p-2 bd-highlight">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
              </div>
              <div class="info p-2 bd-highlight">
                <p>Admin</p>
                <a href="#" class="pr-3 mt-3"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
            </div>
            <div class="menu">
              <ul class="nav flex-column mt-2">
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
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Saved reports</span>
                <a class="d-flex align-items-center text-muted" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                </a>
              </h6>
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
        <div class="col-10 content p-0 ml-sm-auto col-lg-10 px-0 mt-5">
          <div class="breadcrumb-content container pb-0">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
              </ol>
            </nav>
          </div>
          <div class="main container pt-2">
            <div class="header d-flex justify-content-between align-items-center border-bottom">
              <h1 class="font-weight-normal">Dashboard</h1>
              <div class="btn-toolbar mb-2">
                <div class="btn-group mr-2">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>                  
              </div>
            </div>
            <div class="main-content mt-4 mb-3">
              <h4 class="font-weight-light pt-4 pb-2">System</h4>
              <ul class="d-flex flex-row mb-4 pb-4 border-bottom list-unstyled">
                <li class="p-2 bd-highlight">General</li>
                <li class="p-2 bd-highlight">Routes</li>
                <li class="p-2 bd-highlight">Users</li>
                <li class="p-2 bd-highlight">Email</li>
                <li class="p-2 bd-highlight">Plugins</li>
              </ul>
              <h4 class="font-weight-light pt-4 pb-2">Content</h4>
              <ul class="d-flex flex-row mb-4 pb-4 border-bottom list-unstyled">
                <li class="p-2 bd-highlight">Fields</li>
                <li class="p-2 bd-highlight">Sections</li>
                <li class="p-2 bd-highlight">Assets</li>
                <li class="p-2 bd-highlight">Globals</li>
                <li class="p-2 bd-highlight">Categories</li>
                <li class="p-2 bd-highlight">Tags</li>
                <li class="p-2 bd-highlight">Locales</li>
              </ul>
            </div>
          </div>
          <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2017-2019 Company Name</p>
            <ul class="list-inline">
              <li class="list-inline-item"><a href="#">Privacy</a></li>
              <li class="list-inline-item"><a href="#">Terms</a></li>
              <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
          </footer>
        </div>
      </div>
    </main> -->
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>