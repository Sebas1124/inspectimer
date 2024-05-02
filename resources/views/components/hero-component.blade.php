<section class="section banner banner-section">
    <div class="container banner-column">
       <img class="banner-image" src="{{ asset('imgs/HeroImage.png') }}" alt="Illustration">
       <div class="banner-inner">
          <h1 class="heading-xl">Bienvenido a SIS-IT.</h1>
          <p class="paragraph">
             Nuestro sistema de gestion de empleados donde serás dueño de tu tiempo.
             Marca aquí tu inicio de jornada y descansos.
             <br>
             <br>
             <strong>&copy; 2024 SIS-IT. Todos los derechos reservados.</strong>
          </p>
          @component('components.buttons-components', ['disabled' => false, 'breakDisabled' => false ])
              
          @endcomponent
       </div>
    </div>
</section>