

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Crear un usuario</h1>
      </div>
      <div class="modal-body">
        
        <form id="createNewUserForm">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Genero</label>
                <select class="form-control select" name='gender' required>
                    <option value="man">Hombre</option>
                    <option value="woman">Mujer</option>
                    <option value="other">Otro</option>
                </select>
            </div>
            <button type="submit" disabled id="createNewUser" class="btn btn-outline-success">Crear usuario</button>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" id="closeModal" class="btn btn-outline-danger d-flex justify-content-center align-items-center gap-3" data-bs-dismiss="modal">
          <Strong>Cerrar</Strong> <ion-icon name="close-circle-outline"></ion-icon>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      const openModalButton   = document.getElementById('openModal');
      const closeModalButton  = document.getElementById('closeModal');
      const myModal           = new bootstrap.Modal(document.getElementById('exampleModal'));
      const password          = document.getElementById('password');
      const buttonCreate      = document.getElementById('createNewUser');
      const inputs            = document.querySelectorAll('input');
      const correo            = document.getElementById('email').value;

      inputs.forEach(input => {
          input.addEventListener('input', function () {
              // Verifica si todos los inputs tienen datos
              const allInputsFilled = Array.from(inputs).every(input => input.value.trim() !== '');

              if (allInputsFilled) {
                  buttonCreate.removeAttribute('disabled');
              } else {
                  buttonCreate.setAttribute('disabled', true);
              }
          });
      });

      password.addEventListener('input', function () {
          if (password.value.length >= 8) {
            buttonCreate.removeAttribute('disabled');
          } else {
            buttonCreate.setAttribute('disabled', true);
          }
      });
      
      openModalButton.addEventListener('click', function () {
        // Mostrar el modal
        myModal.show();
      });

      closeModalButton.addEventListener('click', function () {
        // Ocultar el modal
        myModal.hide();
      });

      buttonCreate.addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.getElementById('createNewUserForm');
        const formData = new FormData(form);

        $.ajax({
          url: '{{ route('admin.users.store') }}',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            console.log(response);
            myModal.hide();
          },
          error: function (error) {
            
            const message = error.responseJSON.message

            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Algo salió mal!, ' + message + '!',
              footer: '<a href>Por favor intenta de nuevo</a>'
            });

          }
        });

      });
  });
</script>