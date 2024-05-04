@extends('layouts.App')

@section('css')

<style>

    .OtpContainer {
        width: 100%;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .Maincontainer {
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        padding: 50px 20px;
        text-align: center;
    }

    .title {
        font-size: 25px;
        margin-bottom: 30px;
    }

    #otp-form {
        width: 100%;
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
    }

    #otp-form input {
        border: none;
        background-color: #121517;
        color: white;
        font-size: 32px;
        text-align: center;
        padding: 10px;
        width: 100%;
        max-width: 70px;
        height: 70px;
        border-radius: 4px;
        outline: 2px solid rgb(66, 66, 66);
    }

    #otp-form input:focus-visible {
        outline: 2px solid royalblue;
    }

    #otp-form input.filled {
        outline: 2px solid rgb(7, 192, 99);
    }

    #verify-btn {
        cursor: pointer;
        display: inline-block;
        margin-top: 30px;
        background: royalblue;
        color: white;
        padding: 7px 10px;
        border-radius: 4px;
        font-size: 16px;
        border: none;
    }


</style>

@endsection

@section('content')

<section class="OtpContainer">
    <div class="Maincontainer">

      <h1 class="title">Ingresa tu código OTP</h1>

        <p>Hemos enviado un código de seguridad a tu email</p>

        <input class="form-control" name="password" value="{{ $password }}" type="hidden">
        <input class="form-control" name="password" value="{{ $user->email }}" type="hidden">


      <form id="otp-form">
        <input type="text" class="otp-input" maxlength="1">
        <input type="text" class="otp-input" maxlength="1">
        <input type="text" class="otp-input" maxlength="1">
        <input type="text" class="otp-input" maxlength="1">
        <input type="text" class="otp-input" maxlength="1">
        <input type="text" class="otp-input" maxlength="1">
      </form>

      <button id="verify-btn">Verificar código</button>

    </div>

</section>

@endsection

@section('js')

<script>

    const form = document.querySelector("#otp-form");
    const inputs = document.querySelectorAll(".otp-input");
    const verifyBtn = document.querySelector("#verify-btn");

    const isAllInputFilled = () => {
        return Array.from(inputs).every((item) => item.value);
    };

    const deleteNoNumeric = (field) => {
        field.value = field.value.replace(/[^0-9]/, "");
    };

    const isAllInputNumeric = () => {
        return Array.from(inputs).every((item) => !isNaN(item.value));
    };

    const getOtpText = () => {
        let text = "";
        inputs.forEach((input) => {
            text += input.value;
        });
        return text;
    };

    const verifyOTP = () => {
        if ( isAllInputFilled() && isAllInputNumeric() ) {
            const text = getOtpText();

            $.ajax({
                url: "{{ route('login.confirm') }}",
                type: "POST",
                data: {
                    otp: text,
                    _token: "{{ csrf_token() }}",
                    email: "{{ $user->email }}",
                    password: "{{ $password }}"
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Has iniciado sesión correctamente'
                    }).then(() => {
                        
                        $.ajax({
                            url: "{{ route('login') }}",
                            type: "POST",
                            data: {
                                email: "{{ $user->email }}",
                                password: "{{ $password }}",
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                window.location.href = "{{ route('index') }}";
                            },
                            error: function(err) {
                                console.log(err)
                            }
                        });

                    });
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: err.responseJSON.message
                    });

                    inputs.forEach((input) => {
                        input.value = "";
                        toggleFilledClass(input);
                    });
                }
            });
            
        }
    };

    const toggleFilledClass = (field) => {
        if (field.value) {
            field.classList.add("filled");
        } else {
            field.classList.remove("filled");
        }
    };

    form.addEventListener("input", (e) => {
        const target = e.target;
        const value = target.value;
        console.log({ target, value });
        deleteNoNumeric(target);
        toggleFilledClass(target);
        if (target.nextElementSibling) {
            target.nextElementSibling.focus();
        }
        verifyOTP();
    });

    inputs.forEach((input, currentIndex) => {
    // fill check
    toggleFilledClass(input);

    // paste event
    input.addEventListener("paste", (e) => {
        e.preventDefault();
        const text = e.clipboardData.getData("text");
        console.log(text);
        inputs.forEach((item, index) => {
        if (index >= currentIndex && text[index - currentIndex]) {
            item.focus();
            item.value = text[index - currentIndex] || "";
            toggleFilledClass(item);
            verifyOTP();
        }
        });
    });

    // backspace event
    input.addEventListener("keydown", (e) => {
        if (e.keyCode === 8) {
        e.preventDefault();
        input.value = "";
        toggleFilledClass(input);

        if (input.previousElementSibling) {
            input.previousElementSibling.focus();
        }
        
        } else {

        if (input.value && input.nextElementSibling) {
            input.nextElementSibling.focus();
        }

        }
    });
    });

    verifyBtn.addEventListener("click", () => {
        verifyOTP();
    });

</script>

@endsection