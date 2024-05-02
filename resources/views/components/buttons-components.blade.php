<div class="container">

    @if ( Auth::check() )
        <input name="userId" id="UserInputId" type="hidden" value="{{ Auth::user()->id }}">
    @endif

    @php
        $disabled = ( Auth::check() ) ? false : true;
        $breakDisabled = isset($breakDisabled) ? $breakDisabled : false;
    @endphp

    <div class="row mb-3">
        <div class="col mb-2">
            <button id="InicioJornadaButton" {{ isset($disabled) && $disabled ? 'disabled' : '' }} class="btn btn-outline-success w-100 btn-lg">
                Inicio de jornada
            </button>
        </div>
        <div class="col mb-2">
            <button {{ isset($disabled) && $disabled ? 'disabled' : '' }} id="FinJornadaButton" class="btn btn-outline-danger w-100 btn-lg">
                Fin de jornada
            </button>
        </div>
    </div>
    @if ( !$disabled )
        <div class="row mb-2">
            <div class="col mb-2">
                <button {{ isset($breakDisabled) && $breakDisabled ? 'disabled' : '' }} id="BreakStart" class="btn btn-outline-primary w-100 btn-lg">
                    Inicio de descanso
                </button>
            </div>
            <div class="col mb-2">
                <button {{ isset($disabled) && $disabled ? 'disabled' : '' }} id="BreakFinish" class="btn btn-outline-warning w-100 btn-lg">
                    Fin de descanso
                </button>
            </div>
        </div>
    @endif
</div>

<script>

    const InicioJornadaButton = document.getElementById('InicioJornadaButton');
    const FinJornadaButton    = document.getElementById('FinJornadaButton');
    const BreakStart          = document.getElementById('BreakStart');
    const BreakFinish         = document.getElementById('BreakFinish');

    BreakStart.disabled = true;
    BreakFinish.disabled = true;

    const storeJornada = ( userId, hora, fecha, token, tipo ) => {

        $.ajax({
        url: '/admin/employees/store',
        type: 'POST',
        data: {
            userId,
            hora,
            fecha,
            tipo,
            _token: token
        },
        success: function(response) {
            Swal.fire({
                title: tipo,
                text: response.message,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });

            ( tipo == 'Fin de jornada' )
                ? InicioJornadaButton.disabled = false
                : InicioJornadaButton.disabled = true;

            BreakStart.disabled = false;
            BreakFinish.disabled = false;

        },
        error: function(error) {
            Swal.fire({
                title: tipo,
                text: error.responseJSON.message,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });

            InicioJornadaButton.disabled = false;
            BreakStart.disabled = true;
            BreakFinish.disabled = true;
        }
        });
    }

    InicioJornadaButton.addEventListener('click', (e) => {

        e.preventDefault();

        Swal.fire({
            title: 'Inicio de jornada',
            text: '¿Estás seguro de marcar tu inicio de jornada?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {

                const userId    = document.getElementById('UserInputId').value;
                const hora      = new Date().toLocaleTimeString().split(' ')[0];
                const fecha     = new Date().toLocaleDateString();
                const token     = '{{ csrf_token() }}';
                const tipo      = 'Inicio de jornada';

                storeJornada( userId, hora, fecha, token, tipo );
            }
        });

    });

    FinJornadaButton.addEventListener('click', (e) => {

        e.preventDefault();

        Swal.fire({
            title: 'Fin de jornada',
            text: '¿Estás seguro de marcar tu fin de jornada?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#28a745'
        }).then((result) => {
            if (result.isConfirmed) {

                const userId    = document.getElementById('UserInputId').value;
                const hora      = new Date().toLocaleTimeString().split(' ')[0];
                const fecha     = new Date().toLocaleDateString();
                const token     = '{{ csrf_token() }}';
                const tipo      = 'Fin de jornada';

                storeJornada( userId, hora, fecha, token, tipo );

                InicioJornadaButton.disabled = false;
                BreakStart.disabled = true;
                BreakFinish.disabled = true;
            }
        });

    });



</script>