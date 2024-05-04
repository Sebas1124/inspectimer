<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear un usuario</h1>
            </div>
            <div class="modal-body">

                <form id="updateUserForm">
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
                    <button disabled id="updateUser" class="btn btn-outline-success">Crear usuario</button>
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
    const openModalButtons = document.querySelectorAll('.openModal');
    const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    let updateUserClickListener = null;

    const clearAllInputs = () => {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            if (input.name !== '_token') {
                input.value = '';
            }
        });
    }

    const onCreateUser = () => {
        clearAllInputs();

        const inputs = document.querySelectorAll('input');
        const password = document.getElementById('password');

        const buttonCreate = document.getElementById('updateUser');
        buttonCreate.textContent = 'Crear usuario';
        buttonCreate.setAttribute('disabled', true);

        const updateButtonState = () => {
            const inputs = document.querySelectorAll('input:not([type="hidden"])'); // Excluir campos ocultos
            const password = document.getElementById('password');
            const isPasswordValid = parseInt(password.value.length) >= 8;

            const allInputsFilled = Array.from(inputs).every(input => {
                const value = input.value.trim();
                return value !== '' && value.match(/^\s*$/) === null; // Validar que el valor no esté vacío ni sea solo espacios en blanco
            });

            if (allInputsFilled && isPasswordValid) {
                buttonCreate.removeAttribute('disabled');
            } else {
                buttonCreate.setAttribute('disabled', true);
            }
        };

        inputs.forEach(input => {
            input.addEventListener('input', updateButtonState);
        });

        password.addEventListener('input', updateButtonState);

        if (updateUserClickListener) {
            buttonCreate.removeEventListener('click', updateUserClickListener);
        }

        updateUserClickListener = function (e) {
            e.preventDefault();
            const form = document.getElementById('updateUserForm');
            const formData = new FormData(form);

            $.ajax({
                url: '{{ route('admin.users.store') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 1500);

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
        };

        buttonCreate.addEventListener('click', updateUserClickListener);
    }

    const onUpdateUser = (userId) => {
        clearAllInputs();

        const password = document.getElementById('password');

        const buttonCreate = document.getElementById('updateUser');
        buttonCreate.textContent = 'Editar usuario';
        buttonCreate.removeAttribute('disabled');

        const updateButtonState = () => {
            const isPasswordValid = password.value.length >= 8;

            if (isPasswordValid) {
                buttonCreate.removeAttribute('disabled');
            } else {
                buttonCreate.setAttribute('disabled', true);
            }
        };

        password.addEventListener('input', updateButtonState);

        if (updateUserClickListener) {
            buttonCreate.removeEventListener('click', updateUserClickListener);
        }

        updateUserClickListener = function (e) {
            e.preventDefault();
            const form = document.getElementById('updateUserForm');
            const formData = new FormData(form);

            $.ajax({
                url: '{{ route('admin.users.update', ':userId') }}'.replace(':userId', userId),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 1500);

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
        };

        buttonCreate.addEventListener('click', updateUserClickListener);

        $.ajax({
            url: '{{ route('admin.users.edit', ':userId') }}'.replace(':userId', userId),
            method: 'GET',
            success: function (response) {
                const { name, email, password, gender } = response;
                document.getElementById('name').value = name;
                document.getElementById('email').value = email;
                document.getElementById('password').value = password;
                document.querySelector('.select').value = gender;
            },
            error: function (error) {
                console.log(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salió mal!, ' + error + '!',
                    footer: '<a href>Por favor intenta de nuevo</a>'
                });
            }
        });
    }

    openModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            const modalTitle = this.getAttribute('data-modal-title');
            const modalContent = this.getAttribute('data-modal-content');

            const modalTitleElement = document.querySelector('.modal-title');
            const modalBodyElement = document.querySelector('.modal-body');

            modalTitleElement.textContent = modalTitle;

            myModal.show();

            if (this.getAttribute('data-type') === 'create') {
                onCreateUser();
            } else if (this.getAttribute('data-type') === 'edit') {
                const userId = this.getAttribute('data-userId');
                onUpdateUser(userId);
            }
        });
    });

    const closeModalButton = document.getElementById('closeModal');
    closeModalButton.addEventListener('click', function () {
        myModal.hide();
    });
});
</script>