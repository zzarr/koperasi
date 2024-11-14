<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet">
  <link rel="stylesheet" href="demo2/assets/css/fontawesome.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link rel="stylesheet" href="demo2/assets/css/flag-icons.css" />
  <!-- Core CSS -->
  <link rel="stylesheet" href="demo2/assets/css/core-dark.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="demo2/assets/css/theme-default-dark.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="demo2/assets/css/demo.css" />
  <!-- Vendors CSS -->
  <link rel="stylesheet" href="demo2/assets/css/node-waves.css" />

  <link rel="stylesheet" href="demo2/assets/css/perfect-scrollbar.css" />
  <link rel="stylesheet" href="demo2/assets/css/typehead.css" />
  <!-- Vendor -->
  <link rel="stylesheet" href="demo2/assets/css/form-validation.css" />
  <link rel="stylesheet" href="demo2/assets/css/page-auth.css">
  <script src="demo2/assets/js/helpers.js"></script>
  <script src="demo2/assets/js/template-customizer.js"></script>
  <script src="demo2/assets/js/config.js"></script>

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-6">
        <div class="card">
          <div class="card-body">

            <div class="app-brand justify-content-center mb-6">
              <a href="index.html" class="app-brand-link">
                <span class="app-brand-text demo text-heading fw-bold">Login</span>
              </a>
            </div>

            <!-- /Logo -->
            <h4 class="mb-1">Selamat Datang! 👋</h4>
            <p class="mb-6">Masuk ke akun anda untuk melanjutkan.</p>

            <form id="formAuthentication" class="mb-4" class="mb-4" action="{{ route('login') }}" method="POST">
              @csrf
              <div class="mb-6">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan email" autofocus required>
              </div>
              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer" id="toggle-password"><i class="ti ti-eye-off"></i></span>
                </div>
              </div>
              @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  @foreach ($errors->all() as $error)
                      <p class="mb-0"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/> <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                                      </svg>  {{ $error }}</p>
                  @endforeach
              </div>
          @endif
              <div class="my-8">
                <div class="mb-6">
                  <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>


  <script src="demo2/assets/js/jquery.js"></script>
  <script src="demo2/assets/js/popper.js"></script>
  <script src="demo2/assets/js/bootstrap.js"></script>
  <script src="demo2/assets/js/node-waves.js"></script>
  <script src="demo2/assets/js/perfect-scrollbar.js"></script>
  <script src="demo2/assets/js/hammer.js"></script>
  <script src="demo2/assets/js/typeahead.js"></script>
  <script src="demo2/assets/js/menu.js"></script>
  <script src="demo2/assets/js/popular.js"></script>
  <script src="demo2/assets/js/bootstrap5.js"></script>
  <script src="demo2/assets/js/auto-focus.js"></script>
  <script src="demo2/assets/js/i18n.js"></script>

  <!-- Main JS -->
  <script src="demo2/assets/js/main.js"></script>


  <!-- Page JS -->
  <script src="demo2/assets/js/pages-auth.js"></script>
  <script src="demo2/assets/js/gtm.js"></script>

  <!-- toogle password -->
  <script>
    document.getElementById("toggle-password").addEventListener("click", function() {
      const passwordField = document.getElementById("password");
      const icon = this.querySelector("i");

      // Toggle the type attribute
      if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("ti-eye-off");
        icon.classList.add("ti-eye");
      } else {
        passwordField.type = "password";
        icon.classList.remove("ti-eye");
        icon.classList.add("ti-eye-off");
      }
    });
  </script>
  </body>

</html>