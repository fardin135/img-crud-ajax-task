<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="{{ request()->is('/') ? 'nav-link nav-active text-white bg-primary rounded' : 'nav-link nav-hover'}}" aria-current="page" href="/">Task 1</a>
        </li>
        <li class="nav-item">
          <a class="{{ request()->is('task-2') ? 'nav-link nav-active text-white bg-primary rounded' : 'nav-link nav-hover'}}" aria-current="page" href="/task-2">Task 2</a>
        </li>
        <li class="nav-item">
          <a class="{{ request()->is('task-3') ? 'nav-link nav-active text-white bg-primary rounded' : 'nav-link nav-hover'}}" aria-current="page" href="/task-3 ">Task 3</a>
        </li>
      </ul>
      <div class="d-flex">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="{{ request()->is('login') ? 'nav-link nav-active text-white bg-primary rounded' : 'nav-link nav-hover'}}" aria-current="page" href="/login">Login</a>
        </li>
        <li class="nav-item">
          <a class="{{ request()->is('registration') ? 'nav-link nav-active text-white bg-primary rounded' : 'nav-link nav-hover'}}" aria-current="page" href="/registration">Register</a>
        </li>
      </ul>
      </div>
    </div>
  </div>
</nav>



