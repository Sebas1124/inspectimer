

<div class="modal fade" id="exampleModalCancel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Rechazar horas</h1>
        </div>
        <div class="modal-body">
          
          <form id="cancelHours">
              @csrf
                <div class="mb-3">
                    <input type="hidden" class="form-control" id="registroID" name="registroId" required>
                </div>
              <div class="mb-3">
                    <label for="name" class="form-label">Comentario</label>
                  <textarea class="form-control" id="comentariocancelar" name="comentario" required></textarea>
              </div>
              <button type="submit" disabled id="cancelHoursButton" class="btn btn-outline-success">Crear usuario</button>
          </form>
  
        </div>
        <div class="modal-footer">
          <button type="button" id="closeModalCancel" class="btn btn-outline-danger d-flex justify-content-center align-items-center gap-3" data-bs-dismiss="modal">
            <Strong>Cerrar</Strong> <ion-icon name="close-circle-outline"></ion-icon>
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const closeModalButton  = document.getElementById('closeModalCancel');
        const textArea          = document.getElementById('comentariocancelar');
        const acceptHoursButton = document.getElementById('cancelHoursButton');
  
        textArea.addEventListener('input', function () {
            // Verifica si todos los inputs tienen datos
            const allInputsFilled = textArea.value.trim() !== '';
  
            // Habilita el botón si todos los inputs tienen datos
            if (allInputsFilled) {
              acceptHoursButton.removeAttribute('disabled');
            } else {
              acceptHoursButton.setAttribute('disabled', 'disabled');
            }
        });

        acceptHoursButton.addEventListener('click', (e) => {
            e.preventDefault();
            let registroId = document.getElementById('registroID').value;
            let comentario = document.getElementById('comentariocancelar').value;
            
            $.ajax({
                url: '{{ route('employees.cancelarHoras') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    registroId,
                    comentario
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Horas Canceladas',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.reload();
                    });
                }
            })

        });
        
    });
  </script>